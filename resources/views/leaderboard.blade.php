@extends('app')

@section('page-title')
    Leaderboard - {{Config::get('app.name')}}
@endsection

@section('navbar')
    @include('partials/fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-background">

                    @include('partials.display-input-error')
                    <h1 class="form-title">Leaderboards</h1>
                    <div class="row">
                        <div class="col-sm-6">

                            <h6 class="subheading-2 subheading-color">Most Roasting Users</h6>

                            @foreach($mostRoastingUsers as $index=>$commentUser)

                                <div class="row">
                                    <div class="col-xs-3">

                                        <img src="/images/user-profile-icon.jpg"/>

                                    </div>

                                    <div class="col-sm-9">
                                        <a href="#"><h6 class="list-group-item-heading card-title">{{($index+1)}}. {{$commentUser->user->username}}</h6></a>


                                    </div>
                                </div>
                                <hr>

                            @endforeach

                        </div>
                        <div class="col-sm-6">

                            <h6 class="subheading-2 subheading-color">Most Roasted Games</h6>

                            @foreach($mostRoastedGames as $index=>$game)

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <a href="/game/{{$game->slug}}">
                                                <img class="embed-responsive-item" src="{{Utils::get_image_url($game->slug.'/'.$game->latestScreenshot()->image1)}}"/>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-sm-9">
                                        <a href="/game/{{$game->slug}}"><h6 class="list-group-item-heading card-title">{{($index+1)}}. {{$game->title}}</h6></a>

                                        <p class="list-group-item-text card-description">{{clean($game->description, 'noneAllowed')}}</p>
                                    </div>
                                </div>
                                <hr>

                            @endforeach
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <div class="col-md-8 col-md-offset-2">
        @include('partials/footer')
    </div>
@endsection



