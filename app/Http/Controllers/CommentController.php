<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Game;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Slynova\Commentable\Models\Comment;
use App\Http\Requests\StoreCommentRequest;

class CommentController extends Controller
{
    // Check that at least one of the fields is provided
    public static function shouldStore(StoreCommentRequest $request) {
        if($request->has('body') || $request->has('positive') || $request->has('negative')) {
            return true;
        }
        return false;
    }

    public function postAddComment($game, StoreCommentRequest $request)
    {
        if(!CommentController::shouldStore($request)) {
            return redirect()->back()->withErrors('Please specify a comment.');
        }
        $comment = new Comment;
        $comment->user_id = $request->user()->id;
        $comment->username = $request->user()->username;
        $comment->body = trim($request->input('body')) !== '' ? $request->input('body') : null;
        $comment->positive = trim($request->input('positive')) !== '' ? $request->input('positive') : null;
        $comment->negative = trim($request->input('negative')) !== '' ? $request->input('negative') : null;
        $game->comments()->save($comment);
        return redirect()->back()->with('message', 'Comment added!');
    }

    public function postAddCommentReply($comment, StoreCommentRequest $request)
    {
        if(!CommentController::shouldStore($request)) {
            return redirect()->back()->withErrors('Please specify a comment.');
        }

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

    public function getAddComment($game, Request $request)
    {
        return redirect('game/'.$game->slug);
    }

    public function getAddCommentReply($comment)
    {
        $game = Game::findOrFail($comment->commentable_id);
        return redirect('game/'.$game->slug);
    }

}
