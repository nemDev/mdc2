<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ImportController extends Controller
{
    /**
     * @desc Show upload files form
     * @route GET /imports/upload
     * @return View
     */
    public function create(): View
    {
        return view('imports.upload');
    }

    /**
     * @desc Handle files uploading
     * @route POST /imports/upload
     * @return RedirectResponse
     */
    public function upload(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'files.*' => 'required|mimes:application/vnd.ms-excel,csv'
        ]);
        dd($data);
    }
}
