<?php

namespace App\Http\Controllers;

use App\Exports\ImportedDataExport;
use App\Http\Resources\AuditResource;
use App\Jobs\ImportJob;
use App\Models\Audit;
use App\Models\Upload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use \Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;
class ImportController extends Controller
{
    private $importTypes = [];

    public function __construct(){
        $tempImportTypesArray = [];
        $importTypes = Config::get('import_types');
        foreach ($importTypes as $type => $importType) {
            foreach ($importType['files'] as $fileKey => $file) {
                $requiredHeaders = [];
                $headers = [];
                foreach ($file['header_to_db'] as $key => $fileValue) {
                    if (in_array('required', $fileValue['validation'])) {
                        $requiredHeaders[] = $fileValue['label'];
                    }
                    $headers[$key] = $fileValue['label'];
                }
                $importType['files'][$fileKey]['headers'] = $headers;
                $importType['files'][$fileKey]['requiredHeaders'] = $requiredHeaders;
                $importType['files'][$fileKey]['requiredHeadersText'] = 'Required Headers: ' . implode(', ', $requiredHeaders);
                $tempImportTypesArray[$type] = $importType;
            }
        }
        $this->importTypes = $tempImportTypesArray;
    }

    /**
     * Show imported data
     * @route GET /{type}/{file}
     * @return View
     */
    public function index(string $type, string $file, Request $request): View
    {
        $modelName = ucwords($type) . ucwords($file);
        // Dynamically create the model
        $modelClass = "App\\Models\\{$modelName}";
        if (!class_exists($modelClass)) {
            return view('imports.index')
                ->with(
                    [   'items' => [],
                        'headers' => $this->importTypes[$type]['files'][$file],
                        'title' => ucwords($this->importTypes[$type]['label']) . '-'. ucwords($file),
                        'permission' => $this->importTypes[$type]['permission_required']
                    ]
                );
        }
        $model = new $modelClass();
        //Check if there are search input
        if($request->input('search')){
            $items  = $model->search($request->input('search'))->paginate(20);
        }else{
            $items = $model->paginate(20);
        }

        return view('imports.index')
                    ->with(
                        [   'items' => $items,
                            'headers' => $this->importTypes[$type]['files'][$file],
                            'title' => ucwords($this->importTypes[$type]['label']) . '-'. ucwords($file),
                            'permission' => $this->importTypes[$type]['permission_required'],
                            'type' => $type,
                            'file' => $file
                        ]
                    );
    }

    /**
     * @desc Show upload files form
     * @route GET /imports/upload
     * @return View
     */
    public function create(): View
    {
        $importTypes = getAllowedImportTypes(auth()->user()->permissions()->pluck('name')->toArray(), $this->importTypes);
        return view('imports.upload')->with('importTypes', $importTypes);
    }

    /**
     * @desc Handle files uploading
     * @route POST /imports/upload
     * @return RedirectResponse
     */
    public function upload(Request $request): RedirectResponse
    {

        $importType = $request->input('importType');
        // Check if import type exists in config file for security reasons
        if(!array_key_exists($importType,  $this->importTypes)) {
            return back()->with(['error' => "Provided import type is invalid or you dont have permission."]);
        }

        //Get selected import type
        $selectedImportType = $this->importTypes[$importType];

        //Check for permission
        Gate::authorize('have-permission', $selectedImportType['permission_required']);

        //Check for files
        $filesValidationRule = [];
        $errors = [];
        $files = [];
        foreach ($selectedImportType['files'] as $key => $file) {
            $filename = $importType . '_' . $key . '.*';
            $filesValidationRule[$filename] = 'file|mimes:csv,xlsx';
            if($request->hasFile($filename)) {
                foreach ($request->file($filename) as $uploadedFile) {
                    $extension = $uploadedFile->getClientOriginalExtension();
                    $path = $uploadedFile->getRealPath();
                    $fileHeaders = Excel::toArray([], $path)[0][0];
                    if(!($extension == 'xlsx' || $extension == 'csv')) {
                        $errors[] =  'Only xlsx, .csv files are allowed , file ' . $uploadedFile->getClientOriginalName() . ' is invalid';
                    }elseif(!empty(array_diff($file['requiredHeaders'], $fileHeaders))){
                        $errors[] = 'There are no all required headers in ' . $uploadedFile->getClientOriginalName();
                    }else{
                        $files[] = [ 'file' => $uploadedFile , 'importType' => $importType, 'importTypeFile' => $key ];
                    }
                }

            }
        }

        if($errors){
            return back()->with(['error' => implode('.', $errors)]);
        }

        if(!$files) {
            return back()->with(['error' => 'You need to upload at least one file.']);
        }
        foreach ($files as $file) {

            $filePath = Storage::disk('local')->put('imports', $file['file']);
            $upload = Upload::create(
                [
                    'import_type' => $file['importType'],
                    'import_type_file' => $file['importTypeFile'],
                    'original_name' => $file['file']->getClientOriginalName(),
                    'path' => $filePath,
                    'extension' => $file['file']->getClientOriginalExtension(),
                    'user_id' => Auth::user()->id
                ]
            );

            ImportJob::dispatch($upload->id, $upload->path);
        }
        return back()->with('success', 'Import started. You will be notified once it’s complete.');
    }

    /**
     * @desc Fetch audits for row
     * @route GET /imports/{type}/{file}/{id}/audits
     * @return JsonResponse
     */
    public function audits(string $type, string $file, string $id): JsonResponse
    {

        $modelName = ucwords($type) . ucwords($file);
        $audits = Audit::where(['model' => $modelName, 'model_id' => $id])->with(['upload'])->get();
        $rows =  AuditResource::collection($audits);
        return response()->json([
            'rows' => $rows,
        ]);
    }

    /**
     * @desc Handle delete method for imported data row
     * @route DELETE /imports/{type}/{file}/{id}
     * @return RedirectResponse
     */
    public function destroy(string $type, string $file, int $id)
    {

        $modelName = ucwords($type) . ucwords($file);
        // Dynamically create the model
        $modelClass = "App\\Models\\{$modelName}";
        if (!class_exists($modelClass)) {
           return back()->with('error', 'Provided import type is invalid or you dont have permission.');
        }
        $model = new $modelClass();
        $row = $model->where('id', $id)->firstOrFail();

        if($row->logs){
            $row->logs->detach();
        }
        $row->delete();
        return back()->with('success', 'You have successfully deleted the imported row.');
    }

    /**
     * @desc Export report
     * @route POST /imports/{type}/{file}
     */
    public function export(string $type, string $file, Request $request)
    {
        $modelName = ucwords($type) . ucwords($file);

        $modelClass = "App\\Models\\{$modelName}";
        if (!class_exists($modelClass)) {
            return view('imports.index')
                ->with(
                    [   'items' => [],
                        'headers' => $this->importTypes[$type]['files'][$file],
                        'title' => ucwords($this->importTypes[$type]['label']) . '-'. ucwords($file),
                        'permission' => $this->importTypes[$type]['permission_required']
                    ]
                );
        }
        $dbColumns = array_keys($this->importTypes[$type]['files'][$file]['header_to_db']);
        $headers = array_values($this->importTypes[$type]['files'][$file]['headers']);
        $model = new $modelClass();
        //Check if there are search input
        if($request->input('search')){
            $items  = $model->search($request->input('search'))->get();
        }else{
            $items = $model->select($dbColumns)->get();
        }

        $rows = [];
        foreach ($items as $item) {
            $row = [];
            foreach ($dbColumns as $dbColumn) {
                $row[] = $item->{$dbColumn};
            }
            $rows[] = $row;
        }
        return Excel::download(new ImportedDataExport(collect($rows), $headers), $type . '_' .$file . time() . '.xlsx',null, $headers);
    }
}
