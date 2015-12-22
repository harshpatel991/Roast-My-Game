<div class="col-sm-3">

    <div class="white-background-box">
        <div class="embed-responsive embed-responsive-16by9">
            <a href="/game/{{$game->slug}}">
                <img class="embed-responsive-item" src="{{Utils::get_image_url($game->latestScreenshot()->image1)}}"/>
            </a>
        </div>
        <h6>{{$game->title}}</h6>
        <p class="small card-description">{{$game->description}}</p>
        <a class="btn btn-transparent-silver btn-block" href="/game/{{$game->slug}}">View</a>
    </div>
</div>