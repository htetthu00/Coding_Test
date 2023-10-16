<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id'
    ];

    
    public function Category()
    {
        return $this->belongsToMany(Category::class);
    }

    public function User() 
    {
        return $this->belongsTo(User::class);    
    }
}
