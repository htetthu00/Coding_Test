<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if(auth('sanctum')->user()) {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'body' => $this->body,
                'user_id' => $this->user_id,
                'categories' => $this->Category,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
            ];
        } else {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'body' => Str::limit($this->body, 10),
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
            ];
        }
    }
}
