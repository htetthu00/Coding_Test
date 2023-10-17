<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;

class UserController extends Controller
{
    public function index($slug) 
    {
        $user = User::where('slug', $slug)->first();

        if(is_null($user)) {
            return fail('Sorry, User cannot be found.', null , 404 );
        }

        return BlogResource::collection(Blog::with('Category:id,name')->where('user_id', $user->id)->paginate(10))
            ->additional(['result' => 1, 'message' => 'Success']); 
    }

    public function profileUpdate(Request $request, $slug) 
    {
        $user = User::where('slug', $slug)->first();

        if(is_null($user)) {
            return fail('Sorry, User cannot be found.', null , 404 );
        }

        if(auth('sanctum')->user()->id !== $user->id) {
            return fail('Sorry, You have no permission to update other user profile.', null , 403 );
        }

        $user = $user->update($request->only('username', 'email', 'password'));

        return success('Your profile is successfully updated', $user, 200);
    }
}
