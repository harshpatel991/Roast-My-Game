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
                    <p>One of the biggest problems that a game dev faces as they create a game is gaining a sort of "mothers love" for their game. This prevents them from being able to properly determine its flaws. Friends and family members tend to sugarcoat their feedback to avoid from being discouraging but this actually harms more than it helps.
                        <b>{{Config::get('app.name')}} is a site created to help game developers gather 'sugarfree' feedback on games they are working on and to inspire other game developers by sharing development progress.</b></p>

                    <h3 class="form-title">Who can post a game?</h3>
                    <p>Anyone is allowed to post their game. Current games and games that you have worked on in the past are allowed to be posted as long as you have full permission from all the developers to post the game.</p>

                    <h3 class="form-title">What kind of content is allowed in a roast?</h3>
                    <p>In popular culture, roasts are usually jokes used to point out someones flaws. Similarly, on Roast My Game, the goal is to find the flaws in games so that it can be improved. You are allowed to be 'rough' with your roast as long as it provides meaningful feedback to the dev on how and what to improve.</p>

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
                                <li>Promote your game in the forums</li>
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

                    <h3 class="form-title">Earning Points</h3>
                    <p>
                        <b>Add a game</b> - 100 points
                        <br><b>Add game progress</b> - 75 points
                        <br><b>Confirm your email</b> - 50 points
                        <br><b>Add a roast</b> - 25 points
                        <br><b>Like a game</b> - 5 points
                    </p>

                    <h3 class="form-title">Points Ranking</h3>

                    <table class="table">
                        <tr>
                            <th>Level</th>
                            <th>Points</th>
                            <th>Badge</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>0 - {{App\User::$LEVEL_1}}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>{{App\User::$LEVEL_1+1}} - {{App\User::$LEVEL_2}}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>{{App\User::$LEVEL_2+1}} - {{App\User::$LEVEL_3}}</td>
                            <td><span class="icon-circle trophy-badge-silver"></span></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>{{App\User::$LEVEL_3+1}} - {{App\User::$LEVEL_4}}</td>
                            <td><span class="icon-circle trophy-badge-silver"></span></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>{{App\User::$LEVEL_4+1}} - {{App\User::$LEVEL_5}}</td>
                            <td><span class="icon-circle trophy-badge-gold"></span></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>{{App\User::$LEVEL_5}} +</td>
                            <td><span class="icon-circle trophy-badge-gold"></span></td>
                        </tr>
                    </table>


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
