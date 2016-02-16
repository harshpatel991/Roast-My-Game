<?php

namespace App\Http\Controllers;

use Log;
use App\Discussion;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Slynova\Commentable\Models\Comment;

class ForumController extends Controller
{
    private static $validationRules =  ['body' => 'max: 5000|required|min: 5'];

    public function getDiscussion(Request $request)
    {
        $discussion = Discussion::take(1)
            ->with('user')
            ->first();

        if(!$request->session()->has($discussion->slug)) //Count a view
        {
            $request->session()->put($discussion->slug, true);
            $discussion->views = $discussion->views+1;
            $discussion->save();
        }

        $comments = $discussion->comments()->get();
        return view('discussion', compact('discussion', 'comments'));
    }

    public function postAddComment(Discussion $discussion, Request $request)
    {
        Log::info('Request to store a forum comment: ' . print_R($request->all(), TRUE));

        $this->validate($request, $this::$validationRules);

        $user = $request->user();

        $comment = new Comment;
        $comment->user_id = $user->id;
        $comment->my_commentable_type = 'Discussion'; //so we know how to link the comment
        $comment->username = $user->username;
        $comment->body = trim($request->input('body')) !== '' ? $request->input('body') : null;
        $discussion->comments()->save($comment);
        return redirect()->back()->with('message', 'Forum comment added!');
    }

    public function postAddCommentReply($comment, Request $request)
    {
        Log::info('Request to store a forum reply : ' . print_R($request->all(), TRUE));

        $this->validate($request, $this::$validationRules);

        $user = $request->user();

        $newComment = new Comment;
        $newComment->user_id = $user->id;
        $newComment->commentable_id = $comment->commentable_id; //child comments don't get commentable ids by default so add them in
        $newComment->my_commentable_type = 'Discussion'; //so we know how to link the comment
        $newComment->username = $user->username;
        $newComment->body = trim($request->input('body')) !== '' ? $request->input('body') : null;
        $newComment->save();
        $newComment->makeChildOf($comment);
        return redirect()->back()->with('message', 'Forum reply added!');
    }

    public function getAddComment(Discussion $discussion)
    {
        return redirect('forum/'.$discussion->slug);
    }

    public function getAddCommentReply($comment)
    {
        $discussion = Discussion::findOrFail($comment->commentable_id);
        return redirect('forum/'.$discussion->slug);
    }
}
