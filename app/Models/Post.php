<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['image', 'caption', 'likes'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
