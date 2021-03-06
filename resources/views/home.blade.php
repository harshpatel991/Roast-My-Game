@extends('app')

@section('page-title'){{Config::get('app.name')}}@endsection

@section('page-description')Roast My Game is a site for indie game developers to get honest feedback, find inspriation and for gamers to influence games they want to play.@endsection

@section('navbar')
    @include('partials/fixedNav')
@endsection

@section('content')

    <div class="container-fluid white-background">

        <div class="row">
            <div class="banner-background-overlay">
                <h1 class="home-h1">UP YOUR GAME</h1>
                <h3 class="home-h3">Get feedback, find inspiration, and promote your game</h3>
                <br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-offset-1 col-md-10 col-sm-12">

                @include('partials.display-input-error')

                <div class="row" style="margin-top: -150px;">
                    <div class="col-sm-6">
                        <h6 class="small" style="padding: 5px; margin-bottom: 0px; color: #fff;">TRENDING NOW</h6>
                    </div>
                </div>

                <div class="row">
                    @include('partials/card', ['game' => $popularGames->get(0)])
                    @include('partials/card', ['game' => $popularGames->get(1)])
                    @include('partials/card', ['game' => $popularGames->get(2)])
                    @include('partials/card', ['game' => $popularGames->get(3)])
                </div>

                <div class="row">
                    @include('partials/card', ['game' => $popularGames->get(4)])
                    @include('partials/card', ['game' => $popularGames->get(5)])
                    @include('partials/card', ['game' => $popularGames->get(6)])
                    @include('partials/card', ['game' => $popularGames->get(7)])
                </div>

            </div>
        </div>

        <div class="row grey-background hidden-xs">
            <div class="col-md-offset-1 col-md-10">
                <h6 class="small" style="padding: 5px; margin-bottom: 0px;">RECENT ROASTS</h6>
                <div class="row">
                    <div class="col-sm-4">
                        @include('partials.recent-roast', ['comment' => $recentRoasts->get(0), 'game' => $recentRoasts->get(0)->commentable])
                    </div>
                    <div class="col-sm-4">
                        @include('partials.recent-roast', ['comment' => $recentRoasts->get(1), 'game' => $recentRoasts->get(1)->commentable])
                    </div>
                    <div class="col-sm-4">
                        @include('partials.recent-roast', ['comment' => $recentRoasts->get(2), 'game' => $recentRoasts->get(2)->commentable])
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-offset-1 col-md-10 col-sm-12">

                <div class="row">
                    <div class="col-sm-6">
                        <h6 class="small" style="padding: 5px; margin-bottom: 0px;">RECENTLY ADDED AND UPDATED</h6>
                    </div>
                    <div class="col-md-3 col-md-offset-3 col-sm-3 col-sm-offset-3">
                        <a href="{{ secure_url('/games?query=&genre=&platform=&order=created_at') }}" class="btn btn-sm btn-info pull-right hidden-xs" style="margin-top: 20px;">More Recent Games<span class="icon-right-circled"></span></a>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-offset-1 col-md-8 col-sm-12">
                <div class="row">
                    @include('partials/card', ['game' => $games->get(0), 'showDate' => true])
                    @include('partials/card', ['game' => $games->get(1), 'showDate' => true])
                    @include('partials/card', ['game' => $games->get(2), 'showDate' => true])
                    @include('partials/card', ['game' => $games->get(3), 'showDate' => true])
                </div>
                <div class="row">
                    @include('partials/card', ['game' => $games->get(4), 'showDate' => true])
                    @include('partials/card', ['game' => $games->get(5), 'showDate' => true])
                    @include('partials/card', ['game' => $games->get(6), 'showDate' => true])
                    @include('partials/card', ['game' => $games->get(7), 'showDate' => true])
                </div>
                <div class="row">
                    @include('partials/card', ['game' => $games->get(8), 'showDate' => true])
                    @include('partials/card', ['game' => $games->get(9), 'showDate' => true])
                    @include('partials/card', ['game' => $games->get(10), 'showDate' => true])
                    @include('partials/card', ['game' => $games->get(11), 'showDate' => true])
                </div>
            </div>

            <div class="col-md-2">
                <h6>Recent Activity</h6>
                @foreach($recentList as $recentListItem)

                    <div class="media">
                        <div class="media-left">
                            <a href="{{ secure_url('/profile/'.$recentListItem->user->username) }}">
                                {!! $recentListItem->user->getProfileImage('30px', 'user-profile-default-font-micro') !!}
                            </a>
                        </div>
                        <div class="media-body">
                            <p class="small" style="margin-bottom: 5px; line-height: 1.1"><a href="{{ secure_url('/profile/'.$recentListItem->user->username) }}">{{$recentListItem->user->username}}</a>{{$recentListItem->action}}<a href="{{ secure_url('/game/'.$recentListItem->game->slug) }}">{{$recentListItem->game->title}}</a></p>

                        </div>
                    </div>
                @endforeach

                @include('partials.ads')
            </div>
        </div>

        <div class= "row">
            <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4">
                <a href="{{ secure_url('/games') }}" class="btn btn-sm btn-info btn-block" style="margin-top: 20px;">See All Games <span class="icon-right-circled"></span></a>
            </div>
        </div>


        <div class="row">
            <hr>
            <div class="col-md-10 col-md-offset-1 small">
                <div class="pull-right">
                    <a href="{{ secure_url('/about') }}">About</a> · <a href="{{ secure_url('/contact-us') }}">Contact</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1 small">
                <div class="pull-right">
                    <a href="https://roastmygame.blogspot.com">Dev Blog</a> · <a href="https://twitter.com/RoastMyGame">Twitter</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1 small">
                <div class="pull-right">
                    <a href="{{ secure_url('/privacy-policy') }}">Privacy Policy</a> · <a href="{{ secure_url('/terms-conditions') }}">Terms and Conditions</a>
                </div>
            </div>
        </div>

    </div>
@endsection

