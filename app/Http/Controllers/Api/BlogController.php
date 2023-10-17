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
        return BlogResource::collection(Blog::with('Category:id,name')->paginate(10))->additional(['result' => 1, 'message' => 'Success']);    
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

        return success('Your blog is successfully created', $blog, 200);

        // return response()->json([
        //     'status' => 200,
        //     'message' => 'Blog successfully created.'
        // ]);
    }

    public function show($id)
    {
        $blog = Blog::with('Category:id,name')->where('id', $id)->first();

        if(is_null($blog)) {
            // return response()->json([
            //     'status' => 404,
            //     'message' => 'Blog not found.'
            // ]);

            return fail('Sorry, Your blog cannot be found.', null , 404 );
        }

        return (new BlogResource($blog))->additional(['result' => 1, 'status' => 200, 'message' => 'Success']);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::where('id', $id)->first();

        if(is_null($blog)) {
            return fail('Sorry, Your blog cannot be found.', null , 404 );

            // return response()->json([
            //     'status' => 404,
            //     'message' => 'Blog not found.'
            // ]);
        }

        if(auth('sanctum')->user()->id !== $blog->user_id) {
            return fail('Sorry, You have no permission to update this blog.', null , 403 );

            // return response()->json([
            //     'status' => 403,
            //     'message' => 'Forbidden'
            // ]);
        }
   
        if($request->categories) {
            $categories = explode(',', $request->categories);

            $blog->Category()->sync($categories);
        }

        $blog = $blog->update($request->only('title', 'body'));

        return success('Your blog is successfully updated', $blog, 200);

        // return response()->json([
        //     'status' => 200,
        //     'message' => 'Blog successfully updated.'
        // ]);
    }

    public function destroy($id)
    {
        $blog = Blog::where('id', $id)->first();

        if(is_null($blog)) {
            return fail('Sorry, Your blog cannot be found.', null , 404 );
            // return response()->json([
            //     'status' => 404,
            //     'message' => 'Blog not found.'
            // ]);
        }

        if(auth('sanctum')->user()->id !== $blog->user_id) {
            return fail('Sorry, You have no permission to delete this blog.', null , 403 );
            // return response()->json([
            //     'status' => 403,
            //     'message' => 'Forbidden'
            // ]);
        }

        $blog->delete();

        return success('Your blog is successfully deleted.', null, 200);

        // return response()->json([
        //     'status' => 200,
        //     'message' => 'Blog successfully deleted.'
        // ]);
    }
}
