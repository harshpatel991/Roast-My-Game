<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="canonical" href="{{ secure_url(Request::path()) }}" />
    <link rel="icon" type="image/png" href="https://roastmygame.com/images/favicon.png" />
    <title>@yield('page-title')</title>
    <meta name="description" content="@yield('page-description')">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="/css/app.css" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

</head>
<body class="background">
    @yield('navbar')

    @yield('content')

    <div class="container-fluid footer-wrapper">
        <div class="row">
            @yield('footer')
        </div>
    </div>

    <script src="/js/jquery-2.1.4.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

    @yield('scripts')
    @include('partials.googleAnalytics')
    @include('partials.lazyLoadIcons')

</body>
</html>
