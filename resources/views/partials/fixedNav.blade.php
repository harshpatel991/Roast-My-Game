<nav class="navbar navbar-default navbar-fixed-top" @yield('navbar-color')>
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/" style="color: #fff;">{{Config::get('app.name')}}</a>
                </div>

                <div class="collapse navbar-collapse text-center" id="bs-example-navbar-collapse-1">

                    @if(isset($nextGame))
                        <a href="/game/{{$nextGame}}" class="btn-dark-blue btn navbar-btn btn-sm">Show Me Another!</a>
                    @endif

                    @if (Auth::guest())
                        <a href="/auth/login" class="btn btn-light-blue navbar-btn btn-sm pull-right" style="margin-left: 10px;"><span class="fui-user"></span> Login</a>
                        <a href="/auth/register" class="btn btn-light-blue navbar-btn btn-sm pull-right" style="margin-left: 10px;"><span class="glyphicon glyphicon-usd"></span> Register</a>
                    @else
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-light-blue navbar-btn btn-sm dropdown-toggle" style="margin-left: 10px;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->username }} <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="/profile"><span class="glyphicon glyphicon-user"></span> <span >Profile</span></a></li>

                                <li><a href="{{ url('/auth/logout') }}" class="category" id="logout-button"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                            </ul>
                        </div>
                    @endif

                    <a href="/add-game" class="btn btn-primary navbar-btn btn-sm pull-right">Add Game</a>
                </div>
            </div>

        </div>

    </div><!-- /.container-fluid -->
</nav>