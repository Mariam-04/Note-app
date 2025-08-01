<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController  extends Controller
{
    // public function showUploadForm()
    // {
    //     return view('file.upload');
    // }

        public function showForm()
    {
        return view('file.upload');
    }

    public function upload(Request $request)
{
    $request->validate([
        'csv_file' => 'required|mimes:csv,txt|max:2048',
    ]);

    $file = $request->file('csv_file');
    $data = [];

    if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            $data[] = $row;
        }
        fclose($handle);
    }

    return view('file.upload', compact('data'));
   }

    // public function handleUpload(Request $request)
    // {
    //     $request->validate([
    //         'csv_file' => 'required|mimes:csv,txt|max:2048'
    //     ]);

    //     $data = [];

    //     if (($handle = fopen($request->file('csv_file')->getRealPath(), 'r')) !== false) {
    //         while (($row = fgetcsv($handle, 1000, ',')) !== false) {
    //             $data[] = $row;
    //         }
    //         fclose($handle);
    //     }

    //     return view('file.upload', compact('data'));
    // }
}
