<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The user who wrote the comment
     *
     * @return App\Models\User
     */
    public function author()
    {
      return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    /**
     * The post the comment is associated with
     *
     * @return App\Models\Post
     */
    public function post()
    {
      return $this->belongsTo('App\Models\Posts', 'post_id');
    }
  
}
