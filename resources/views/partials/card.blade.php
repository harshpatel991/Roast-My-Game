@if(isset($game))
    <div class="col-sm-3">
        <a href="{{ secure_url('/game/'.$game->slug) }}" class="card-wrapper-link">
            <div class="white-background-box">

                <div class="embed-responsive embed-responsive-16by9" >
                    <div class="embed-responsive-item card-image-cover" style="background-image: url('{{Utils::get_image_url($game->slug.'/'.$game->thumbnail)}}');"> </div>
                </div>

                <h6 class="card-title">{{$game->title}}</h6>
                <p class="small card-date"><span class="icon-clock"></span> {{$game->versions->first()->created_at->diffForHumans()}} </p>
                <p class="small card-description">{{clean($game->description, 'noneAllowed')}}</p>
            </div>
        </a>

    </div>
@endif