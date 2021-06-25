<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\DeleteCommentRequest;

class CommentController extends Controller
{
    public function save(CommentRequest $request)
    {
        if (!$request->user()) {
            return redirect('/');
        }

        $data = $request->validated();

        $comment = new Comment();
        $comment->comment = $data['comment'];
        $comment->user_id = $request->user()->id;
        $comment->post_id = $data['post_id'];

        $comment->save();

        return redirect()
            ->back();
    }

    public function delete(DeleteCommentRequest $request, int $commentId)
    {
        if (!$request->user()) {
            return redirect('/');
        }
        
        $comment = Comment::where('id', $commentId)->first();

        if ($request->has('delete')) {
            $comment->delete();
            $message = 'Comment deleted!';
        }

        return redirect()->back();
    }
}
