<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('active', 1)
            ->orderBy('created_at','desc');

        //return blog.blade.php template from resources/views folder
        return view('blog.index', ['posts' => $posts, 'title' => 'Blog Posts']);
    }
}
