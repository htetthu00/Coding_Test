<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;

class UserController extends Controller
{
    public function index($username) 
    {
        $user = User::where('username', $username)->first();

        if(is_null($user)) {
            return fail('Sorry, User cannot be found.', null , 404 );
        }

        $blogs = Blog::with('Category', 'User')->where('user_id', $user->id)->paginate(10);

        return BlogResource::collection($blogs)
            ->additional(['result' => 1, 'message' => 'Success']); 
    }

    public function profileUpdate(UserRequest $request, $username) 
    {
        $user = User::where('username', $username)->first();

        if(is_null($user)) {
            return fail('Sorry, User cannot be found.', null , 404 );
        }

        if(auth('sanctum')->user()->id !== $user->id) {
            return fail('Sorry, You have no permission to update other user profile.', null , 403 );
        }

        $user = $user->update($request->validated());

        return success('Your profile is successfully updated', $user, 200);
    }
}
