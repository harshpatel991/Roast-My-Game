<div class="media col-sm-offset-{{ $comment->depth }}">
    <div class="media-left">
        <a href="#">
            <img width="30px" class="media-object" src="/images/user-profile-icon.jpg">
        </a>
    </div>
    <div class="media-body">
        <p class="media-heading small" style="line-height: 1; "><b><a href="/profile/{{$comment->username}}">{{ $comment->username }}<span class="icon-circle {{ $comment->user->getBadge() }}"></span></a></b> {{ $comment->created_at->diffForHumans() }}</p>
        {!! str_replace( "\n", '<br />', clean($comment->body)) !!}
        <br>
        <a class="reply-link" data-url="{{ url('add-comment-reply/'.$comment->id) }}">Reply</a> {{--Adds the reply box--}}
    </div>
</div>

@if($comment->hasChildren())
    @foreach($comment->getChildren() as $child)
        @include('partials.comment_child', ['comment' => $child])
    @endforeach
@endif