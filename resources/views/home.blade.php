<!DOCTYPE html>
<html lang="en" class="_body_html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/images/favicon.png" />
    <title>{{Config::get('app.name')}}</title>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    {{--<script src="/js/jquery-2.1.4.min.js"></script>--}}
    {{--<script src="/js/bootstrap.min.js"></script>--}}

    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400' rel='stylesheet' type='text/css'>
    {{--<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>--}}
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
</head>

<body class="_body_html _body">

    <div class="home-background-overlay">

        <div class="container-fluid">
            <div class="row"> {{--header--}}
                <div class="col-md-10 col-md-offset-1">
                    <h1 class="logo">{{Config::get('app.name')}}</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h1 class="home-h1">SHARE YOUR [ WIP]</h1>
                    <h3 class="home-h3">Motivate your self to finish and get inspiration from other game devs</h3>
                    {{--<h3 class="home-h3">Watch the progress </h3>--}}
                </div>
            </div>

            <div class="row">
                <div class="col-md-offset-2 col-md-3">
                    <div class="">
                        <a href="/game/test-game" class="btn btn-clear btn-lg btn-block">Explore Games <span class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>
                </div>

                <div class="col-md-offset-1 col-md-4">
                    <div class="white-background-box">
                        Add your game.
                        <hr>
                        {!! Form::open(array('route' => '/', 'class'=>'form-horizontal', 'files'=>true,)) !!}
                        <div class="form-group">
                            <label for="title" class="control-label form-label">Title</label>
                            <input id="title" name="title" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="email"  class="control-label form-label">Your Email</label>
                            <input id="email" name="email" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Add Your Game</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
