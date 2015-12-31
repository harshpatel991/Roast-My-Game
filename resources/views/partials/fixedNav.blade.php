<nav class="navbar navbar-default navbar-fixed-top" @yield('navbar-color')>
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="icon-menu"></span>
                    </button>
                    <a class="navbar-brand" href="/" style="color: #fff;font-weight: 400;padding-left:5px;">{{Config::get('app.name')}}</a>
                </div>

                <div class="collapse navbar-collapse text-center" id="bs-example-navbar-collapse-1">

                    @if(isset($nextGame))
                        <a href="/game/{{$nextGame}}" class="btn btn-info navbar-btn btn-sm"  role="button" id="next_game">Roast Another</a>
                    @endif

                    <ul class="nav navbar-nav navbar-right">


                        @if (Auth::guest())
                            <li>
                                <form action="/auth/register">
                                    <button class="btn btn-light-blue navbar-btn btn-sm" style="margin-left: 10px;">Register</button>
                                </form>
                            </li>
                            <li>
                                <form action="/auth/login">
                                    <button class="btn btn-light-blue navbar-btn btn-sm" style="margin-left: 10px;">Login</button>
                                </form>
                            </li>
                        @else

                            <li class="dropdown text-center">
                                <button href="#" id="profile-dropdown" class="btn btn-light-blue navbar-btn btn-sm dropdown-toggle" data-toggle="dropdown" role="button">{{ Auth::user()->username }} <span class="caret"></span></button>
                                <ul class="dropdown-menu" style="margin-top:0px;">
                                    <li><a href="/profile" id="profile-button"><span class="icon-user">Profile</span></a></li>
                                    <li><a href="{{ url('/auth/logout') }}" class="category" id="logout-button"><span class="icon-logout"></span>Logout</a></li>
                                </ul>
                            </li>

                        @endif

                        <a href="/add-game" id="btn-add-game" class="btn btn-primary navbar-btn btn-sm" style="margin-left: 10px;">Add Game</a>

                    </ul>
                </div>

            </div>

        </div>

    </div><!-- /.container-fluid -->
</nav>