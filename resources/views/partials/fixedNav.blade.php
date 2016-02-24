<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="icon-menu"></span>
                    </button>
                    <a class="navbar-brand" href="{{ secure_url('/') }}" style="padding-left:5px;">

                        <img alt="{{Config::get('app.name')}}" src="/images/logo.png" height="100%">
                        {{--{{Config::get('app.name')}}--}}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    {{--@if(isset($nextGame))--}}
                    {{--<a href="/game/{{$nextGame}}" class="btn btn-info navbar-btn btn-sm"  role="button" id="next_game">Roast Another</a>--}}
                    {{--@endif--}}

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <form action="{{ secure_url('/forum/general-discussion') }}" style="margin-left: 10px;">
                                <button class="btn btn-light-blue navbar-btn btn-sm btn-block"><span class="icon-chat-1"></span></button>
                            </form>
                        </li>

                        <li>
                            <form action="{{ secure_url('/leaderboards') }}" style="margin-left: 10px;">
                                <button class="btn btn-light-blue navbar-btn btn-sm btn-block"><span class="icon-award"></span></button>
                            </form>
                        </li>

                        @if (Auth::guest())
                            <li>
                                <form action="{{ secure_url('/auth/register') }}" style="margin-left: 10px;">
                                    <button class="btn btn-light-blue navbar-btn btn-sm btn-block">Register</button>
                                </form>
                            </li>
                            <li>
                                <form action="{{ secure_url('/auth/login') }}" style="margin-left: 10px;">
                                    <button class="btn btn-light-blue navbar-btn btn-sm btn-block">Login</button>
                                </form>
                            </li>
                        @else

                            <li class="dropdown text-center" style="margin-left: 10px;">
                                <button id="profile-dropdown" class="btn btn-light-blue navbar-btn btn-sm btn-block dropdown-toggle" data-toggle="dropdown" role="button">{{ Auth::user()->username }} ({{Auth::user()->points}})<span class="caret"></span></button>
                                <ul class="dropdown-menu" style="margin-top:0px;">
                                    <li><a href="{{ secure_url('/profile/'.Auth::user()->username) }}" id="profile-button"><span class="icon-user">Profile</span></a></li>
                                    <li><a href="{{ secure_url('/settings') }}" class="category" id="settings-button"><span class="icon-cog"></span>Settings</a></li>
                                    <li><a href="{{ secure_url('/auth/logout') }}" class="category" id="logout-button"><span class="icon-logout"></span>Logout</a></li>
                                </ul>
                            </li>

                        @endif

                        <li>
                            <form action="{{ secure_url('/add-game') }}" style="margin-left: 10px;">
                                <button id="btn-add-game" class="btn btn-primary navbar-btn btn-sm btn-block">Add Game</button>
                            </form>
                        </li>

                    </ul>
                </div>

            </div>

        </div>

    </div><!-- /.container-fluid -->
</nav>