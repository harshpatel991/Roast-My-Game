<div class="col-sm-3">

    <div class="white-background-box">
        <div class="embed-responsive embed-responsive-16by9">
            <a href="/game/{{$game->slug}}">
                <img class="embed-responsive-item" src="{{Utils::get_image_url($game->slug.'/'.$game->latestScreenshot()->image1)}}"/>
            </a>
        </div>
        <a href="/game/{{$game->slug}}"><h6 class="card-title">{{$game->title}}</h6></a>
        <p class="small card-date"><span class="icon-clock"></span> {{$game->created_at->diffForHumans()}} </p>
        <p class="small card-description">{{clean($game->description, 'noneAllowed')}}</p>

        <a class="btn btn-info btn-block" href="/game/{{$game->slug}}">View</a>
    </div>
</div>