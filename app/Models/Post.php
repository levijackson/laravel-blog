<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * Get the comments made on the post
     *
     * @return array App\Models\Comment
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'post_id');
    }
    
    /**
     * Get the user who created the post
     *
     * @return App\Models\User
     */
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
