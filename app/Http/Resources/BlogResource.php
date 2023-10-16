<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'user_id' => $this->user_id,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
        ];
    }
}

// 'category' => [
//     'id' => $this->Category->id,
//     'name' => $this->Category->name,
//     'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
//     'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
// ],