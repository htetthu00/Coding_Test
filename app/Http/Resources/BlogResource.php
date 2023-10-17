<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    protected $auth_user;

    public function __construct($resource, $auth_user = null)
    {
        $this->auth_user = $auth_user;

        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->auth_user ? $this->body : Str::limit($this->body, 30),
            'user' => new UserResource($this->User),
            'categories' => CategoryResource::collection($this->Category),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
        ];
    }
}
