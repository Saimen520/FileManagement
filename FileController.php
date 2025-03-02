<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File; 
use App\Http\Controllers;

class FileController extends Controller
{
   public function upload(Request $request)
    {
       
        $request->validate([
            'file' => 'required|mimes:jpg,png,pdf,docx,txt|max:2048', 
        ]);

        
        $uniqueId = Str::uuid();

       
        $filePath = $request->file('file')->store('uploads', 'public');

    
        $fileRecord = new File();
        $fileRecord->unique_id = $uniqueId;
        $fileRecord->name = $request->file('file')->getClientOriginalName();
        $fileRecord->path = $filePath;
        $fileRecord->save();

    
        return response()->json([
            'message' => 'File uploaded successfully!',
            'id' => $fileRecord->id,
            'unique_id' => $uniqueId,
            'path' => $filePath,
        ]);
    }

    public function list()
    {
        return response()->json(File::all());
    }

    public function download($id)
    {
        $file = File::find($id);
        if (!$file) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return Storage::download($file->path, $file->name);
    }

    public function delete($id)
    {
        $file = File::find($id);
        if (!$file) {
            return response()->json(['error' => 'File not found'], 404);
        }

        Storage::delete($file->path);
        $file->delete();

        return response()->json(['message' => 'File deleted successfully!']);
    }
}
