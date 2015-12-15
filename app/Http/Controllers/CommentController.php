<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Slynova\Commentable\Models\Comment;

class CommentController extends Controller
{
    public function postAddComment($game, Request $request)
    {
        $comment = new Comment;
        $comment->user_id = $request->user()->id;
        $comment->username = $request->user()->username;
        $comment->body = $request->input('body');
        $comment->positive = $request->input('positive');
        $comment->negative = $request->input('negative');
        $game->comments()->save($comment);
        return redirect()->back()->with('message', 'Comment added!');
    }

    public function postAddCommentReply($comment, Request $request)
    {
        $newComment = new Comment;
        $newComment->user_id = $request->user()->id;
        $newComment->commentable_id = $comment->commentable_id;
//        $newComment->commentable_type = $comment->commentable_type;
        $newComment->username = $request->user()->username;
        $newComment->body = $request->input('body');
        $newComment->save();
        $newComment->makeChildOf($comment);
        return redirect()->back()->with('message', 'Comment reply added!');
    }

}
