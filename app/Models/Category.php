<?php

namespace App\Models;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    public $fillable = [
        'name'
    ];

    public function Blog()
    {
        return $this->belongsToMany(Blog::class)->withTimestamps();
    }
}
