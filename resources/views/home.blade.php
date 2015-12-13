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
                <h3 class="home-h3">Motivate your self to finish and get inspiration from other game devs</h3>
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

                <div class="row" style="margin-top: 20px;">

                    @include('partials/card', ['game' => $games[0]])
                    @include('partials/card', ['game' => $games[1]])
                    @include('partials/card', ['game' => $games[2]])

                    <div class="col-sm-3"> {{--Add your game card--}}
                        <div class="white-background-box">
                            <div class="embed-responsive embed-responsive-16by9">
                                <img class="embed-responsive-item" src="/images/placeholder.jpg"/>
                            </div>
                            <h6>Your Game Here</h6>
                            <p class="small" style="color:#bfbfbf;"> .</p>
                            <a class="btn btn-primary btn-block" href="/add-game">Add Your Game</a>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 20px;">
                    @include('partials/card', ['game' => $games[3]])
                    @include('partials/card', ['game' => $games[4]])
                    @include('partials/card', ['game' => $games[5]])
                    @include('partials/card', ['game' => $games[6]])
                </div>

            </div>
        </div>


    </div>
@endsection

