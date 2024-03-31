<?php

namespace App\Http\Controllers;

use App\Mail\CommentAdded;
use App\Mail\CommentReplyAdded;
use Illuminate\Http\Request;

use Mail;
use Log;
use App\User;
use App\Game;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use harshpatel991\Commentable\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreCommentReplyRequest;

class CommentController extends Controller
{
    public function postAddComment($game, StoreCommentRequest $request)
    {
        Log::info('Request to store a comment: ' . print_R($request->all(), TRUE));

        $user = $request->user();

        //save the comment
        $comment = new Comment;
        $comment->user_id = $user->id;
        $comment->my_commentable_type = 'Game'; //so we know how to link the comment
        $comment->username = $user->username;
        $comment->body = trim($request->input('body')) !== '' ? $request->input('body') : null;
        $comment->positive = trim($request->input('positive')) !== '' ? $request->input('positive') : null;
        $comment->negative = trim($request->input('negative')) !== '' ? $request->input('negative') : null;
        $game->comments()->save($comment);

        //save the user points
        $user->addPointsAndSave(User::$COMMENT_POINTS);

        $gameOwner = $game->user()->first();
        if($game->user_id != $user->id && $gameOwner->mail_roasts == true) { //check the roaster is not the game owner and game owner wants emails
            $emailAddress = $gameOwner->email;
            \Illuminate\Support\Facades\Mail::to($emailAddress)
                ->bcc('roastmygame@gmail.com')
                ->queue(new CommentAdded($game, 'https://roastmygame.com/images/logo-dark.png'));

            Log::info('Your game has been roasted sent out to ' . $emailAddress);
        } else if ($gameOwner->mail_roasts != true) {
            Log::info('User is unsubscribed, no roast email sent out to' . $gameOwner->email);
        }

        return redirect()->back()->with('message', 'Comment added!');
    }

    public function postAddCommentReply($comment, StoreCommentReplyRequest $request)
    {
        Log::info('Request to store a reply: ' . print_R($request->all(), TRUE));

        $user = $request->user();

        $newComment = new Comment;
        $newComment->user_id = $user->id;
        $newComment->commentable_id = $comment->commentable_id; //child comments don't get commentable ids by default so add them in
        $newComment->my_commentable_type = 'Game'; //so we know how to link the comment
        $newComment->username = $user->username;
        $newComment->body = $request->input('body');
        $newComment->save();
        $newComment->makeChildOf($comment);

        //save the user points
        $user->addPointsAndSave(User::$COMMENT_POINTS);

        //send email to the roaster
        $game = Game::where('id', $comment->commentable_id)->first();
        $sendToUser = User::where('id', $comment->user_id)->first();
        if($comment->user_id != $user->id  && $sendToUser->mail_comments == true) { //the commenter is not replying to themself && user wants to recieve emails
            $sendTo = $sendToUser->email;
            \Illuminate\Support\Facades\Mail::to($sendTo)
                ->bcc('roastmygame@gmail.com')
                ->queue(new CommentReplyAdded($game, 'https://roastmygame.com/images/logo-dark.png'));

            Log::info('Someone replied to your comment sent out to '.$sendTo);
        }  else if ($sendToUser->mail_comments != true) {
            Log::info('User is unsubscribed, no replied email sent out to' . $sendToUser->email);
        }

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
