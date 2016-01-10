@extends('app')

@section('page-title')
    {{Config::get('app.name')}}
@endsection

@section('navbar-color')
    style="background-color: rgba(56, 56, 56, 0.51);"
@endsection

@section('navbar')
    @include('partials/fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">

        <div class="row">
            <div class="banner-background-overlay">
                <h1 class="home-h1">SHARE YOUR <span class="left-bracket">[</span>WIP]</h1>
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
                        <h6 class="small" style="padding: 5px;">RECENTLY UPDATED GAMES</h6>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3"> {{--Add your game card--}}
                        <div class="white-background-box">
                            <div class="embed-responsive embed-responsive-16by9">
                                <img class="embed-responsive-item" src="/images/placeholder.jpg"/>
                            </div>
                            <h6>Your Game Here</h6>
                            <p class="small card-date"> </p>
                            <p class="small"> </p>
                            <a class="btn btn-primary btn-block" href="/add-game">Add Your Game</a>
                        </div>
                    </div>

                    @include('partials/card', ['game' => $games->get(10)])
                    @include('partials/card', ['game' => $games->get(9)])
                    @include('partials/card', ['game' => $games->get(8)])
                </div>

                <div class="row">
                    @include('partials/card', ['game' => $games->get(7)])
                    @include('partials/card', ['game' => $games->get(6)])
                    @include('partials/card', ['game' => $games->get(5)])
                    @include('partials/card', ['game' => $games->get(4)])
                </div>

                <div class="row">
                    @include('partials/card', ['game' => $games->get(3)])
                    @include('partials/card', ['game' => $games->get(2)])
                    @include('partials/card', ['game' => $games->get(1)])
                    @include('partials/card', ['game' => $games->get(0)])
                </div>

                <div class= "row">
                    <div class="col-md-2 col-md-offset-5 col-sm-4 col-sm-offset-4">
                        <a href="/games" class="btn btn-sm btn-default btn-block" style="margin-top: 20px;">More Games<span class="icon-right-circled"></span></a>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1 small" style="margin-top: 30px;"><a href="/privacy-policy">
                    Privacy Policy</a> · <a href="/terms-conditions">Terms and Conditions</a>
                <span class="pull-right">2016 · {{Config::get('app.name')}} · <a href="/about">About</a> · <a href="/contact-us">Contact</a></span>
            </div>
        </div>

    </div>
@endsection

