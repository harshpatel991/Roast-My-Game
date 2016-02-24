@extends('app')

@section('page-title')Promote Game - {{Config::get('app.name')}}@endsection

@section('navbar')
    @include('partials/fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-background">

                    @include('partials.display-input-error')

                    <h4>Promote Game</h4>
                    <p>Here you will find the tools you can use to get the most out of your roast!</p>

                    <h6 class="subheading subheading-color">Tweet</h6>

                    <div class="row">
                        <div class="col-sm-10">
                            <input class="form-control placeholder-dark" type="text" value="{{$helpMessage = Utils::random_roast_message($game)}}" readonly="readonly">
                        </div>
                        <div class="col-sm-2">
                            <a href="https://twitter.com/intent/tweet?text={{urlencode($helpMessage)}}" class="btn btn-info-outline btn-block" target="_blank"><span class="icon-twitter"></span> Tweet</a>
                        </div>
                    </div>

                    <h6 class="subheading subheading-color">Website Embed</h6>

                    <p class="small">Copy this code into your websites HTML page to direct your users to roast your game.</p>
                    <a href="{{ secure_url('/game/'.$game->slug) }}"><img src="https://s3-us-west-2.amazonaws.com/rmg-upload/public/share_button.jpg" class="center-block play-button-text-content"></a>
                    <div class="row">
                        <div class="col-sm-10">
                            <input id="website-contents" class="form-control placeholder-dark" type="text" value="{{'<a href="'. secure_url('/game/'.$game->slug) .'"><img src="https://s3-us-west-2.amazonaws.com/rmg-upload/public/share_button.jpg"></a>'}}" readonly="readonly">
                        </div>
                        <div class="col-sm-2">
                            <button id="btn-copy-website" class="btn btn-success-outline btn-block" data-clipboard-target="#website-contents"><span class="icon-clipboard"></span> Copy</button>
                        </div>
                    </div>

                    <h6 class="subheading subheading-color">Forum Embed</h6>

                    <p class="small">Copy this code into your forum submission to direct your readers to roast your game.</p>
                    <a href="{{ secure_url('/game/'.$game->slug) }}"><img src="https://s3-us-west-2.amazonaws.com/rmg-upload/public/share_button.jpg" class="center-block play-button-text-content"></a>

                    <div class="row">
                        <div class="col-sm-10">
                            <input id="forum-contents" class="form-control placeholder-dark" type="text" value="{{"[URL='". secure_url('/game/'.$game->slug) ."'][IMG]https://s3-us-west-2.amazonaws.com/rmg-upload/public/share_button.jpg[/IMG] [/URL]"}}" readonly="readonly">
                        </div>
                        <div class="col-sm-2">
                            <button id="btn-copy-forum" class="btn btn-success-outline btn-block" data-clipboard-target="#forum-contents"><span class="icon-clipboard"></span> Copy</button>
                        </div>
                    </div>

                    <br>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/clipboard.min.js"></script>

    <script>
        new Clipboard('#btn-copy-forum');
        new Clipboard('#btn-copy-website');
    </script>
@endsection

@section('footer')
    <div class="col-md-8 col-md-offset-2">
        @include('partials/footer')
    </div>
@endsection