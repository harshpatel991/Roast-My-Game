@extends('app')

@section('page-title')
    Register Success- {{Config::get('app.name')}}
@endsection

@section('navbar')
    @include('partials.fixedNav')
@endsection

@section('content')
    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-background">
                    <br>
                    <h3 class="text-center">You're almost there! Check your inbox</h3>
                    <b><p class="text-center">A verification link has been sent to {{$email}}.</p></b>
                    <img src="/images/email-icon.png" width="130" height="130" class="center-block">
                    <br>

                    <h6 class="text-center">
                        To give a chance for all games to get feedback, you must roast one game before adding your own game.
                    </h6>
                    <div class="row">
                        <div class="col-sm-offset-4 col-sm-4">
                            <a href="/games/not-yet-roasted" class="btn btn-info navbar-btn btn-lg btn-block" id="next_game">Not Yet Roasted Games <span class="icon-right-circled"></span></a>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <div class="col-md-8 col-md-offset-2">
        @include('partials.footer')
    </div>
@endsection