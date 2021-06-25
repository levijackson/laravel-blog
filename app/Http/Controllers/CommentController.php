<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function save(Request $request)
    {
        $comment = new Comment();
        $comment->comment = $request->get('comment');
        $comment->user_id = $request->user()->id;
        $comment->post_id = $request->get('post_id');

        $comment->save();

        return redirect()
            ->back();
    }
}
