@if(isset($game))
    <div class="col-sm-3">
        <div class="white-background-box">
            <a href="/game/{{$game->slug}}">
                <div class="embed-responsive embed-responsive-16by9" >
                    <div class="embed-responsive-item card-image-cover" style="background-image: url('{{Utils::get_image_url($game->slug.'/'.$game->latestScreenshot()->image1)}}');"> </div>
                </div>
            </a>
            <a href="/game/{{$game->slug}}"><h6 class="card-title">{{$game->title}}</h6></a>
            <p class="small card-date"><span class="icon-clock"></span> {{$game->created_at->diffForHumans()}} </p>
            <p class="small card-description">{{clean($game->description, 'noneAllowed')}}</p>

            <a class="btn btn-info btn-block" href="/game/{{$game->slug}}">View</a>
        </div>
    </div>
@endif