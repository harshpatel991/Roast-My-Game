<div class="media col-sm-offset-{{ $comment->depth }}">
    <div class="media-left">
        <a href="/profile/{{$comment->username}}">
            {!! $comment->user->getProfileImage('40px', 'user-profile-default-font-small') !!}
        </a>
    </div>
    <div class="media-body">
        <p class="media-heading small" style="line-height: 1; "><b><a href="/profile/{{$comment->username}}">{{ $comment->username }}{!! $comment->user->getBadge() !!}</a></b> {{ $comment->created_at->diffForHumans() }}</p>
        {!! str_replace( "\n", '<br />', clean($comment->body)) !!}
        <br>
        <a class="reply-link" data-url="{{ $submitReplyPath.'/'.$comment->id}}" id="comment-child-reply-link-{{$comment->id}}">Reply</a> {{--Adds the reply box--}}
    </div>
</div>

@if($comment->hasChildren())
    @foreach($comment->getChildren() as $child)
        @include('partials.comment_child_view', ['comment' => $child, 'submitReplyPath' => $submitReplyPath])
    @endforeach
@endif