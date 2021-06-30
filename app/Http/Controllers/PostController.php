<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\Post;

use App\Http\Requests\PostRequest;

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
      if ($request->user() && $request->user()->canManagePosts()) {
        return view('blog.posts.create');
      } else {
        return redirect('/')
            ->withErrors('You do not have permission to create posts.');
      }
    }

    public function single(Request $request, string $slug)
    {
        $where = ['slug' => $slug];
        if (!$request->user() || !$request->user()->canManagePosts()) {
            $where['active'] = '1';
        }

        $post = Post::where($where)->first();
        if ($post) {
            $comments = $post->comments()->get();
            return view('blog.posts.single', ['post' => $post, 'comments' => $comments]);
        }
        
        return redirect('/')
            ->withErrors('This post does not exist.');
    }

    public function save(PostRequest $request)
    {
        if ($request->user() && !$request->user()->canManagePosts()) {
            return redirect('/');
        }

        $data = $request->validated();

        $post = new Post();
        $post->title = $data['title'];
        $post->metaTitle = $data['metaTitle'] ?? '';
        $post->body = $data['body'];
        $post->metaDescription = $data['metaDescription'] ?? '';
        $post->slug = $data['slug'] ?? Str::slug($post->title);
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

        if ($post && ($request->user() && ($request->user()->id == $post->user_id || $request->user()->isAdmin()))) {
            return view('blog.posts.edit', ['post' => $post]);
        }
        
        return redirect('/')
            ->withErrors('You do not have permission to edit this post.');
    }

    public function update(PostRequest $request, string $slug)
    {
        if (!$request->user() || !$request->user()->canManagePosts()) {
            return redirect('/');
        }
        
        $post = Post::where('slug', $slug)->first();

        if (!$post) {
            return redirect('/');
        }

        $data = $request->validated();

        if ($request->has('delete')) {
            $post->delete();
            $message = 'Post deleted!';
            return redirect('admin/blog/post/')
                ->withMessage($message);
        }

        $post->title = $request->get('title');
        $post->title = $data['title'];
        $post->metaTitle = $data['metaTitle'] ?? '';
        $post->body = $data['body'];
        $post->metaDescription = $data['metaDescription'] ?? '';
        $post->slug = $data['slug'] ?? Str::slug($post->title);

        $message = 'Post updated!';

        $post->save();

        return redirect('admin/blog/post/' . $post->slug)
            ->withMessage($message);
    }
}
