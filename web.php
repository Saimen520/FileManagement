<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Models\File;
use Illuminate\Http\Request;

Route::get('/FileManage', function () {
    $response = Http::get(env('APP_URL') . '/api/files');
    $files = $response->successful() ? $response->json() : [];
    return view('FileManage', compact('files'));
});

Route::get('/FileManage', function () {
    $files = File::all(); 

    return view('FileManage', compact('files'));
});


Route::post('upload-file', function (Request $request) {
    try {
        $response = Http::attach(
            'file', 
            file_get_contents($request->file('file')), 
            $request->file('file')->getClientOriginalName()
        )->post(config('app.url') . '/api/upload');

        if ($response->successful()) {
            return redirect('/FileManage')->with('message', 'File uploaded successfully!');
        } else {
            return redirect('/FileManage')->with('error', 'Failed to upload file.');
        }
    } catch (\Exception $e) {
        return redirect('/FileManage')->with('error', 'An error occurred: ' . $e->getMessage());
    }
});
