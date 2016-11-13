<div class="well">
    <h6 class="small" style="margin-top: 0px;">
        {{$comment->username}} on
        <a href="{{ secure_url('/game/'.$game->slug) }}"> {{$game->title}}</a>
    </h6>
    <p class="limit-3-lines small" style="margin-bottom: 0px;">{{$comment->body}}</p>
</div>