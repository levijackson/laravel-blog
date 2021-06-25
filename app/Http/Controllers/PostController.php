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
            ->orderBy('created_at','desc')
            ->get();

        //return blog.blade.php template from resources/views folder
        return view('blog.index', ['posts' => $posts, 'title' => 'Blog Posts']);
    }

    public function create(Request $request)
    {
      if ($request->user()->canManagePosts()) {
        return view('blog.posts.create');
      } else {
        return redirect('/')
            ->withErrors('You do not have permission to create posts.');
      }
    }

    public function single(Request $request, string $slug)
    {
        $post = Post::where('slug', $slug)->first();

        if ($post) {
            return view('blog.posts.single', ['post' => $post]);
        }
        
        return redirect('/')
            ->withErrors('This post does not exist.');
    }

    public function save(Request $request)
    {
        $post = new Post();
        $post->title = $request->get('title');
        $post->metaTitle = $request->get('metaTitle');
        $post->body = $request->get('body');
        $post->metaDescription = $request->get('metaDescription');
        $post->slug = $request->get('urlSlug') ?? Str::slug($post->title);
        $post->user_id = $request->user()->id;

        if ($request->has('draft')) {
            $post->active = 0;
            $message = 'Draft saved!';
        } else {
            $post->active = 1;
            $message = 'Post published!';
        }

        $post->save();

        return redirect('admin/blog/post/' . $post->slug)
            ->withMessage($message);
    }

    public function edit(Request $request, string $slug)
    {
        $post = Post::where('slug', $slug)->first();

        if ($post && ($request->user()->id == $post->user_id || $request->user()->isAdmin())) {
            return view('blog.posts.edit', ['post' => $post]);
        }
        
        return redirect('/')
            ->withErrors('You do not have permission to edit this post.');
    }

    public function update(Request $request, string $slug)
    {
        $post = Post::where('slug', $slug)->first();

        if ($request->has('delete')) {
            $post->delete();
            $message = 'Post deleted!';
            return redirect('admin/blog/post/')
                ->withMessage($message);
        }

        $post->title = $request->get('title');
        $post->metaTitle = $request->get('metaTitle');
        $post->body = $request->get('body');
        $post->metaDescription = $request->get('metaDescription');
        $post->slug = $request->get('urlSlug') ?? Str::slug($post->title);
        $post->user_id = $request->user()->id;

        $message = 'Post updated!';

        $post->save();

        return redirect('admin/blog/post/' . $post->slug)
            ->withMessage($message);
    }
}
