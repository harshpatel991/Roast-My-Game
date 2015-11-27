<nav class="navbar navbar-default navbar-fixed-top">
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
                    <a href="/add-game" class="btn-dark-blue btn navbar-btn btn-sm">Show Me Another!</a>
                    <a href="/login" class="btn btn-light-blue navbar-btn btn-sm pull-right" style="margin-left: 10px;"><span class="fui-user"></span></a>
                    <a href="/add-game" class="btn btn-primary navbar-btn btn-sm pull-right">Add Game</a>
                </div>
            </div>

        </div>

    </div><!-- /.container-fluid -->
</nav>