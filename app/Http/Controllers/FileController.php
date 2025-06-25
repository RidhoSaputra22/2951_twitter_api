<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function posts($filename)
    {
        $path = storage_path('app/public/posts/' . $filename);
        // dd($path);

        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response()->file($path, [
            'Content-Type' => mime_content_type($path),
            'Access-Control-Allow-Origin' => '*',
        ]);
    }

    public function users($filename)
    {
        $path = storage_path('app/public/users/' . $filename);
        // dd($path);

        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response()->file($path, [
            'Content-Type' => mime_content_type($path),
            'Access-Control-Allow-Origin' => '*',
        ]);
    }

    public function uploadPhoto(Request $request)
    {
        if (Validator::make($request->all(), [
            'photo' => 'required',
        ])->fails()) {
            return response()->json(Validator::make($request->all(), [
                'photo' => 'required',
            ])->errors(), 422);
        }

        if ($request->hasFile('photo')) {
            Storage::disk('public')->putFile('posts', $request->file('photo'));
            $photo = $request->file('photo')->hashName();
        }
        return response()->json([
            'status' => 200,
            'photo' => config('app.url') . '/file/posts/'  . $photo,
            'message' => 'Photo uploaded successfully'
        ]);
    }
}
