<div class="media">
    <div class="media-left">
        <a href="{{ secure_url('/profile/'.$comment->username) }}">
            {!! $comment->user->getProfileImage('60px', 'user-profile-default-font-large') !!}
        </a>
    </div>

    <div class="media-body">
        <p class="media-heading small" style="line-height: 1;"><b><a href="{{ secure_url('/profile/'.$comment->username) }}"> {{ $comment->username }}{!! $comment->user->getBadge() !!}</a></b> {{ $comment->created_at->diffForHumans() }}</p>

        @if(isset($comment->positive))
        <i class="icon-thumbs-up-alt font-light-gray"></i> {{ App\Feedback::$feedbackCategories[$comment->positive] }}  @endif

        @if(isset($comment->negative)) <b><i class="icon-thumbs-down-alt font-light-gray"></i></b> {{ App\Feedback::$feedbackCategories[$comment->negative] }}  @endif

        @if(isset($comment->body))
            <div>{!! str_replace( "\n", '<br />', clean($comment->body, 'forumPosts')) !!}</div>
        @endif

        <a class="reply-link" data-url="{{ secure_url($submitReplyPath.'/'.$comment->id) }}" id="comment-reply-link-{{$comment->id}}">Reply</a>

    </div>
</div>

@if($comment->hasChildren())
    @foreach($comment->getChildren() as $child)
        @include('partials.comment_child_view', ['comment' => $child, 'submitReplyPath' => $submitReplyPath])
    @endforeach
@endif