@extends('app')

@section('page-title'){{Config::get('app.name')}}@endsection

@section('page-description')Roast My Game is a site for indie game developers to get honest feedback, find inspriation and for gamers to influence games they want to play.@endsection

@section('navbar')
    @include('partials/fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">

        <div class="row">
            <div class="banner-background-overlay">
                <h1 class="home-h1">HONEST FEEDBACK</h1>
                <h3 class="home-h3">Get feedback and find inspiration from other game devs</h3>
                <br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                {{--<h3 class="home-h3">Watch the progress </h3>--}}
            </div>
        </div>

        <div class="row">
            <div class="col-md-offset-1 col-md-10 col-sm-12">

                @include('partials.display-input-error')

                <div class="row">
                    <div class="col-sm-6">
                        <h6 class="small" style="padding: 5px;">POPULAR GAMES</h6>
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

                <div class="row">
                    <div class="col-sm-6">
                        <h6 class="small" style="padding: 5px;">RECENTLY UPDATED GAMES</h6>
                    </div>

                    <div class="col-md-2 col-md-offset-4 col-sm-3 col-sm-offset-3">
                        <a href="/games" class="btn btn-sm btn-light-blue btn-block hidden-xs" style="margin-top: 20px;">More Games <span class="icon-right-circled"></span></a>
                    </div>
                </div>

                <div class="row">
                    @include('partials/card', ['game' => $games->get(0)])
                    @include('partials/card', ['game' => $games->get(1)])
                    @include('partials/card', ['game' => $games->get(2)])
                    @include('partials/card', ['game' => $games->get(3)])
                </div>

                <div class="row">
                    @include('partials/card', ['game' => $games->get(4)])
                    @include('partials/card', ['game' => $games->get(5)])
                    @include('partials/card', ['game' => $games->get(6)])
                    @include('partials/card', ['game' => $games->get(7)])
                </div>

                <div class= "row">
                    <div class="col-md-2 col-md-offset-5 col-sm-4 col-sm-offset-4">
                        <a href="/games" class="btn btn-sm btn-info btn-block visible-xs-block" style="margin-top: 20px;">More Games<span class="icon-right-circled"></span></a>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <hr>
            <div class="col-md-10 col-md-offset-1 small">
                <div class="pull-right">
                    <a href="/about">About</a> · <a href="/contact-us">Contact</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1 small">
                <div class="pull-right">
                    <a href="http://roastmygame.blogspot.com">Dev Blog</a> · <a href="https://twitter.com/RoastMyGame">Twitter</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1 small">
                <div class="pull-right">
                    <a href="/privacy-policy">Privacy Policy</a> · <a href="/terms-conditions">Terms and Conditions</a>
                </div>
            </div>
        </div>

    </div>
@endsection

