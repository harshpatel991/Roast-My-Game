@extends('app')

@section('page-title')Leaderboard - {{Config::get('app.name')}}@endsection

@section('page-description')Top rated users and games on Roast My Game.@endsection

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
                            @foreach($mostRoastingUsers as $index=>$user)

                                <a href="/profile/{{$user->username}}" class="link-block">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <img width="100%" src="{{$user->profile_image}}"/>
                                        </div>
                                        <div class="col-sm-9">
                                            <h6 class="list-group-item-heading card-title">
                                                {{($index+1)}}. {{$user->username}} {!! $user->getBadge() !!}
                                            </h6>
                                            <p class="bold-uppercase subheading-color small">Points {{$user->points}}</p>
                                        </div>
                                    </div>
                                </a>

                                <hr>
                            @endforeach

                        </div>
                        <div class="col-sm-6">

                            <h6 class="subheading-2 subheading-color">Most Roasted Games</h6>

                            @foreach($mostRoastedGames as $index=>$game)

                                <a href="/game/{{$game->slug}}" class="link-block">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <img class="embed-responsive-item" src="{{Utils::get_image_url($game->slug.'/'.$game->thumbnail)}}"/>
                                            </div>
                                        </div>

                                        <div class="col-sm-9">
                                            <h6 class="list-group-item-heading card-title">{{($index+1)}}. {{$game->title}}</h6>
                                            <p class="list-group-item-text card-description">{{clean($game->description, 'noneAllowed')}}</p>
                                        </div>
                                    </div>
                                </a>
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



