<?php

namespace App\Http\Controllers;

use App\Http\Resources\LogResource;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

class LogController extends Controller
{
    public function index():View
    {
        $items = Upload::with(['user', 'logs'])->paginate(10);

        return view('logs.index')->with([
            'items' => $items,
            'title' => 'Imported data logs page',
            'importTypes' => Config::get('import_types'),
        ]);
    }

    public function show(Upload $upload)
    {

        $rows =  LogResource::collection($upload->logs);

        return response()->json(
            [
                'rows' => $rows,
                'upload' => $upload
            ]
        );
    }
}
