<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">{{Config::get('app.name')}}</a>
        </div>

        <div class="collapse navbar-collapse text-center" id="bs-example-navbar-collapse-1">
            <a href="/add-game" class="btn btn-primary navbar-btn btn-sm pull-right">Add Game</a>
        </div>

    </div><!-- /.container-fluid -->
</nav>