<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;

class BlogController extends Controller
{
    public function index()
    {
        return BlogResource::collection(Blog::all());    
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'user_id' => 'required',
            'categories' => 'required'
        ]);

        $categories = explode(',', $attributes['categories']);

        unset($attributes['categories']);

        $blog = Blog::create($attributes);

        $blog->Category()->attach($categories);

        return response()->json([
            'status' => 200,
            'message' => 'Blog successfully created.'
        ]);
    }

    public function show($id)
    {
        $blog = Blog::where('id', $id)->first();

        if(is_null($blog)) {
            return response()->json([
                'status' => 404,
                'message' => 'Blog not found.'
            ]);
        }

        return new BlogResource($blog);
    }

    public function update(Request $request, $id)
    {
        $attributes = $request->validate([
            'title' => 'nullable',
            'body' => 'nullable',
            'user_id' => 'nullable',
            'categories' => 'nullable'
        ]);

        dd($attributes);

        $blog = Blog::where('id', $id)->first();

        if(is_null($blog)) {
            return response()->json([
                'status' => 404,
                'message' => 'Blog not found.'
            ]);
        }

        $blog->update($request->only('title', 'body'));

        return response()->json([
            'status' => 200,
            'message' => 'Blog successfully updated.'
        ]);
    }

    public function destroy($id)
    {
        
    }
}
