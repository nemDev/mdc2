<?php

namespace App\Imports;


use App\Models\Audit;
use App\Models\Log;
use App\Models\Upload;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class FileImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure, WithEvents
{

    private $modelName = '';
    private $configFile;
    private $uploadedFile;

    public function __construct(int $uploadId){
        try {
            $upload = Upload::where('id', $uploadId)->first();
            $this->modelName = ucwords($upload->import_type) . ucwords($upload->import_type_file);
            $this->configFile = Config::get('import_types')[$upload->import_type]['files'][$upload->import_type_file];
            $this->uploadedFile = $upload;
        }catch (\Exception $exception){
            echo $exception->getMessage();
        }
    }

    public function collection(Collection $rows)
    {

        $modelClass = "App\\Models\\" . $this->modelName;
        if (!class_exists($modelClass)) {
            throw new \Exception("Model class {$modelClass} does not exist.");
        }
        $model = new $modelClass();

        foreach ($rows as $row)
        {
            $newRow = $row->toArray();
            $columns = [];
            foreach ($this->configFile['update_or_create'] as $key) {
                $columns[$key] = $newRow[$key];
            }

            $existingModel = $model->where($columns)->first();

            if($existingModel){
                // Compare and find changed columns
                $changes = [];
                foreach ($newRow as $key => $value) {
                    if (isset($existingModel->$key) && $existingModel->$key != $value) {
                        $changes[] = [
                            'column' => $key,
                            'row' => $newRow['row_number'],
                            'upload_id' => $this->uploadedFile->id,
                            'old_value' => $existingModel->$key,
                            'new_value' => $value,
                            'model' => $this->modelName,
                            'model_id' => $existingModel->id
                        ];
                    }
                }

                foreach ($changes as $change) {
                    Audit::create($change);
                }

                unset($newRow['row_number']);
                $existingModel->update($newRow);
            }else{
                unset($newRow['row_number']);
                $model->create($newRow);
            }
        }
    }

    public function rules(): array  {
        $validationRules = [];
        foreach ($this->configFile['header_to_db'] as $index => $value) {
            $validationRules[$index] = self::prepareRuleForValidation($value['validation'], $value['type']);
        }
        $validationRules['row_number'] = 'nullable';

        return $validationRules;
    }

    public function prepareForValidation($data, $index){
        $dataForValidation = [];
        $dataForValidation['row_number'] = $index;
        foreach ($this->configFile['header_to_db'] as $index => $value) {
            if(isset($data[$value['label']])) {
                $dataForValidation[$index] = self::prepareValueForValidation($data[$value['label']], $value['type']);
            }
        }

        return $dataForValidation;
    }


    /*
     * @desc Function for preparing data for validation
     * @param $value
     * @param $rule - from config file, it is type property
     */

    private static function prepareValueForValidation($value, $rule){
        switch ($rule) {
            case 'date':
                if(is_numeric($value)){
                    return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
                }
                return $value;
                break;
            case 'string':
                return (string) $value;
                break;
            case 'integer':
                return (int) $value;
                break;
            case 'float':
                return (float) $value;
                break;
            case 'boolean':
                return (bool) $value;
                break;
            case 'double':
                return (double) $value;
                break;
            default:
                return $value;
                break;
        }
    }

    /*
     * @desc Function for preparing validation rules
     * @param $rule - from config file, it is validation property
     */
    private static function prepareRuleForValidation($rule, $type): array
    {
        $ruleArray = [];
        if($type == 'double'){
            $type = "numeric";
        }

        $ruleArray[] = $type;
        foreach ($rule as $key => $value) {
            $ruleString = '';
            if($value == 'required'){
                $ruleString = $value;
            }

            if($value == 'nullable'){
                $ruleString = $value;
            }
            if ($key == 'in') {
                $ruleString = Rule::in($value);
            }
            if($key == 'exists'){
                $ruleString = Rule::exists($value['table'], $value['column']);
            }

            if($key == 'unique'){
                $ruleString = Rule::unique($value['table'], $value['column']);
            }

            $ruleArray[] = $ruleString;
        }

        return $ruleArray;
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            Log::create([
                'upload_id' => $this->uploadedFile->id,
                'row' => $failure->row(),
                'column' => $failure->attribute(),
                'value' => $failure->values()[$failure->attribute()],
                'message' => implode(', ', $failure->errors())
            ]);
        }
    }

    public function registerEvents(): array
    {
        return [];
    }
}
