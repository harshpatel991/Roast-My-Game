@extends('app')

@section('page-title')
    Privacy Policy - {{Config::get('app.name')}}
@endsection

@section('navbar')
    @include('partials.fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-background">
                    <h1 class="form-title">About</h1>

                    <h3 class="form-title">What is {{Config::get('app.name')}}?</h3>
                    <p>{{Config::get('app.name')}} is a site created to help game developers gather feedback on games they are working on and to inspire other game developers through the sharing of development progress.</p>

                    <h3 class="form-title">Who is this site for?</h3>
                    <p>
                        <ul>
                            <li>Developers of unfinished games
                                <ul>
                                    <li>Keep track of progress</li>
                                    <li>Get feedback on how to improve your game</li>
                                    <li>Find inspiration from other games</li>
                                </ul>
                            </li>
                            <li>Developers of finished games
                                <ul>
                                    <li>Get feedback on how to improve your game</li>
                                </ul>
                            </li>
                            <li>Indie games enthusiasts
                                <ul>
                                    <li>Play games</li>
                                    <li>See game progress</li>
                                    <li>Engage with game creators and influence progress</li>
                                </ul>
                            </li>
                        </ul>
                    </p>

                    <h3 class="form-title">Who can post a game?</h3>
                    <p>Anyone is allowed to post their game. Current games and games that you have worked on in the past are allowed to be posted as long as you have full permission from all the developers to post the game.</p>

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
