<div class="media col-md-offset-{{ $comment->depth }}">
    <div class="media-left">
        <a href="#">
            <img class="media-object" src="/images/user-profile-icon.jpg">
        </a>
    </div>
    <div class="media-body">
        <p class="media-heading small"><b>{{ $comment->username }}</b> - {{ $comment->created_at->diffForHumans() }}</p>
        {{ $comment->body }}
        <br>
        <a class="reply-link" data-url="{{ url('add-comment-reply/'.$comment->id) }}">Reply</a> {{--Adds the reply box--}}
    </div>
</div>

@if($comment->hasChildren())
    @foreach($comment->getChildren() as $child)
        @include('partials.comment_child', ['comment' => $child])
    @endforeach
@endif