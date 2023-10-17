<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function index()
    {
        if(auth('sanctum')->user()) {
            return BlogResource::collection(Blog::with('Category:id,name')->paginate(10))
                ->additional(['result' => 1, 'message' => 'Success']); 
        } else {
            return BlogResource::collection(Blog::with('Category:id,name')->orderBy('created_at', 'DESC')->paginate(10))
                ->additional(['result' => 1, 'message' => 'Success. For more details, please login.']);
        }
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

    public function show($slug)
    {
        $blog = Blog::with('Category:id,name')->where('slug', $slug)->first();

        if(is_null($blog)) {
            return fail('Sorry, Your blog cannot be found.', null , 404 );
        }

        if(auth('sanctum')->user()) {
            return (new BlogResource($blog))->additional(['result' => 1, 'status' => 200, 'message' => 'Success']);
        } else {
            $data = [
                'title' => $blog->title,
                'slug' => $blog->slug,
                'created_at' => Carbon::parse($blog->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::parse($blog->updated_at)->format('Y-m-d H:i:s')
            ];

            return success('Success. For more details, please login.', $data, 200);
        }
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
