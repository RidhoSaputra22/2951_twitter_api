<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posts = Post::with('user')->latest()->get();
        return response()->json($posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = Validator::make($request->all(), [
            'body' => 'required',
            'photo' => 'nullable',
            'user' => 'required',
        ]);

        // dd($request->user['id']);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 422);
        }

        // if ($request->hasFile('photo')) {
        //     Storage::disk('public')->putFile('posts', $request->file('photo'));
        //     $photo = $request->file('photo')->hashName();
        // }

        $post = Post::create([
            'body' => $request->body,
            'photo' => $request->photo,
            'user_id' => $request->user['id']
        ]);
        return response()->json([
            'status' => 200,
            'post' => $post,
            'message' => 'Post created successfully'
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}