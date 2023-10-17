<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('Category', 'User')->orderBy('created_at', 'DESC')->paginate(10);

        return BlogResource::collection($blogs)->additional(['result' => 1, 'message' => 'success']);
    }

    public function store(BlogRequest $request)
    {
        $attributes = $request->validated();

        $categories = explode(',', $attributes['categories']);

        unset($attributes['categories']);

        $blog = $request->user()->Blog()->create($attributes);

        $blog->Category()->attach($categories);

        return success('Your blog is successfully created', $blog, 200);
    }

    public function show($slug)
    {
        $blog = Blog::with('Category', 'User')->where('slug', $slug)->first();

        if(is_null($blog)) {
            return fail('Sorry, Your blog cannot be found.', null , 404 );
        }

        return (new BlogResource($blog, auth('sanctum')->user()))
            ->additional(['result' => 1, 'status' => 200, 'message' => 'Success']);
    }

    public function update(Request $request, $slug)
    {
        $blog = Blog::where('slug', $slug)->first();

        if(is_null($blog)) {
            return fail('Sorry, Your blog cannot be found.', null , 404 );
        }

        if(auth('sanctum')->user()->id !== $blog->user_id) {
            return fail('Sorry, You have no permission to update this blog.', null , 403 );
        }
   
        if($request->categories) {
            $categories = explode(',', $request->categories);

            $blog->Category()->sync($categories);
        }

        $blog = $blog->update($request->only('title', 'body'));

        return success('Your blog is successfully updated', $blog, 200);

    }

    public function destroy($slug)
    {
        $blog = Blog::where('slug', $slug)->first();

        if(is_null($blog)) {
            return fail('Sorry, Your blog cannot be found.', null , 404 );
        }

        if(auth('sanctum')->user()->id !== $blog->user_id) {
            return fail('Sorry, You have no permission to delete this blog.', null , 403 );
        }

        $blog->delete();

        return success('Your blog is successfully deleted.', null, 200);
    }
}
