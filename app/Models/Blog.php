<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'user_id'
    ];

    public function setTitleAttribute($value) 
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    
    public function Category()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function User() 
    {
        return $this->belongsTo(User::class);    
    }
}
