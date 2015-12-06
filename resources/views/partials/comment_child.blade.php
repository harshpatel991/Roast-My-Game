<div class="panel panel-default col-md-offset-{{ $comment->depth }}">
    <div class="panel-body">
        <p>{{ $comment->body }}</p>

        <small><b>{{ $comment->username }}</b> - {{ $comment->created_at->diffForHumans() }}</small>
    </div>
    <div class="panel-footer">
        <a class="btn btn-light-blue btn-sm reply-link" data-url="{{ url('add-comment-reply/'.$comment->id) }}">Reply</a>
    </div>
</div>

@if($comment->hasChildren())
    @foreach($comment->getChildren() as $child)
        @include('partials.comment_child', ['comment' => $child])
    @endforeach
@endif