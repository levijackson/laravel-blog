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

    public function delete(Request $request, int $commentId)
    {
        $comment = Comment::where('id', $commentId)->first();

        if ($request->has('delete')) {
            $comment->delete();
            $message = 'Comment deleted!';
        }

        return redirect()->back();
    }
}
