<div class="media">
    <div class="media-left">
        <a href="#">
            <img class="media-object" src="/images/user-profile-icon.jpg">
        </a>
    </div>
    <div class="media-body">
        <p class="media-heading small" style="line-height: 1; "><b>{{ $comment->username }}</b> - {{ $comment->created_at->diffForHumans() }}</p>

        @if(strlen($comment->body) > 0)
            {{ $comment->body }}
            <br>
        @endif

        <i class="icon-thumbs-up-alt"></i>{{ App\Feedback::$feedbackCategories[$comment->positive] }}
        <i class="icon-thumbs-down-alt"></i>{{ App\Feedback::$feedbackCategories[$comment->negative] }}
        <br>
        <a class="reply-link" data-url="{{ url('add-comment-reply/'.$comment->id) }}">Reply</a>
    </div>
</div>

@if($comment->hasChildren())
    @foreach($comment->getChildren() as $child)
        @include('partials.comment_child', ['comment' => $child])
    @endforeach
@endif