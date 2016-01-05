<div class="media">
    <div class="media-left">
        <a href="#">
            <img width="50px" class="media-object" src="/images/user-profile-icon.jpg">
        </a>
    </div>

    <div class="media-body">
        <p class="media-heading small" style="line-height: 1;"><b>{{ $comment->username }}</b> {{ $comment->created_at->diffForHumans() }}</p>

        @if(isset($comment->positive))
        <i class="icon-thumbs-up-alt font-light-gray"></i> {{ App\Feedback::$feedbackCategories[$comment->positive] }}  @endif

        @if(isset($comment->negative)) <b><i class="icon-thumbs-down-alt font-light-gray"></i></b> {{ App\Feedback::$feedbackCategories[$comment->negative] }}  @endif

        @if(isset($comment->body))
            <div>{!! str_replace( "\n", '<br />', clean($comment->body)) !!}</div>
        @endif

        <a class="reply-link" data-url="{{ url('add-comment-reply/'.$comment->id) }}">Reply</a>

    </div>
</div>

@if($comment->hasChildren())
    @foreach($comment->getChildren() as $child)
        @include('partials.comment_child', ['comment' => $child])
    @endforeach
@endif