@extends('app')

@section('page-title')
    {{Config::get('app.name')}}
@endsection

@section('navbar')
    @include('partials/fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="content-background">
                    <h1 class="form-title">Add Your Game</h1>

                    {!! Form::open(array('route' => 'add-game', 'class'=>'form-horizontal', 'files'=>true,)) !!}

                        {!! Form::myInput('title', 'Title') !!}
                        {!! Form::myInput('developer', 'Developer') !!}

                        <div class="form-group">
                            {!! Form::label('genre', 'Genre', ['class' => 'col-sm-2 control-label form-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::select('genre', App\Game::$genres, old('genre'), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description', ['class' => 'col-sm-2 control-label form-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'rows' => 4]) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('platforms', 'Platforms', ['class' => 'col-sm-2 control-label form-label']) !!}
                            <div class="col-sm-2">
                                {!! Form::myCheckbox('platform-pc', 'PC') !!}
                            </div>
                            <div class="col-sm-2">
                                {!! Form::myCheckbox('platform-ios', 'iOS') !!}
                            </div>
                            <div class="col-sm-6">
                                {!! Form::myCheckbox('platform-unity', 'Unity') !!}
                            </div>
                            <div class="col-sm-2">
                                {!! Form::myCheckbox('platform-mac', 'Mac') !!}
                            </div>
                            <div class="col-sm-2">
                                {!! Form::myCheckbox('platform-android', 'Android') !!}
                            </div>
                            <div class="col-sm-2">
                                {!! Form::myCheckbox('platform-html5', 'HTML5') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <a class="btn btn-primary col-sm-offset-2" role="button" data-toggle="collapse" href="#collapseLinks">Add Links <span class="fui-triangle-down"></span></a>
                            <div class="collapse" id="collapseLinks" style="padding-top: 10px;">
                                {!! Form::myInput('link-website', 'Website', 'http://your-game.com') !!}
                                {!! Form::myInput('link-twitter', 'Twitter', 'http://twitter.com/your-handle') !!}
                                {!! Form::myInput('link-youtube', 'YouTube', 'http://youtube.com/user/your-channel') !!}
                                {!! Form::myInput('link-google-plus', 'Google+', 'http://plus.google.com/your-page') !!}
                                {!! Form::myInput('link-facebook', 'Facebook', 'http://facebook.com/your-page') !!}
                                {!! Form::myInput('link-google-play', 'Google Play', 'http://play.google.com/your-game') !!}
                                {!! Form::myInput('link-app-store', 'Apple App Store', 'http://itunes.apple.com/your-game') !!}
                                {!! Form::myInput('link-windows-store', 'Windows Store', 'http://microsoft.com/your-game') !!}
                                {!! Form::myInput('link-steam', 'Steam', 'http://store.steampowered.com/your-game') !!}
                            </div>
                        </div>

                        <hr>
                        <h4 class="small">CURRENT VERSION</h4>

                        <div class="form-group">
                            {!! Form::label('version', 'Version', ['class' => 'col-sm-2 control-label form-label']) !!}
                            <div class="col-sm-3">
                                {!! Form::text('version', old('version'), ['class' => 'form-control', 'placeholder' => '1.1.3']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('beta', 'In Beta', ['class' => 'col-sm-2 control-label form-label']) !!}
                            <div class="col-sm-3">
                                {!! Form::checkbox('beta', 'true', old("beta")) !!}
                            </div>
                        </div>

                        {!! Form::myInput('video_link', 'YouTube Link', 'https://www.youtube.com/watch?v=e-ORhEE9VVg') !!}


                        <div class="form-group">
                            {!! Form::label('image1', 'Images', ['class' => 'col-sm-2 control-label form-label']) !!}

                            {!! Form::myImageWithThumbnail('image1') !!}
                            {!! Form::myImageWithThumbnail('image2') !!}
                            <div class="col-sm-4">
                                <p class="small add-game-explanation">
                                    <b>Recommended:</b> 720px by 405px<br>
                                    <b>Accepted Types:</b> PNG, JPEG, GIF<br>
                                    <b>Max File Size:</b> 2 MB
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            {!! Form::myImageWithThumbnail('image3') !!}
                            {!! Form::myImageWithThumbnail('image4') !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('upcoming_features', 'Upcoming Features', ['class' => 'col-sm-2 control-label form-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::textarea('upcoming_features', old('upcoming_features'), ['class' => 'form-control', 'rows' => 4]) !!}
                            </div>
                        </div>

                        <hr>
                        <h5 class="small" style="margin-bottom: 0px; color: #cdcdcd;">One last thing...</h5>
                        <h4 class="small" style="margin-top: 0px;">CREATE AN ACCOUNT</h4>

                        {!! Form::myInput('email', 'Email') !!}

                        <div class="form-group">
                            {!! Form::label('password', 'Password', ['class' => 'col-sm-2 control-label form-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button id="add-game" class="btn btn-default">Add Game!</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <div class="col-md-8 col-md-offset-2">
        @include('partials/footer')
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\StoreGameRequest') !!}

    <script>
        function readURL(input, previewElem) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    previewElem.attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image1").change(function(){
            readURL(this, $('#image1-preview'));
        });

        $("#image2").change(function(){
            readURL(this, $('#image2-preview'));
        });

        $("#image3").change(function(){
            readURL(this, $('#image3-preview'));
        });

        $("#image4").change(function(){
            readURL(this, $('#image4-preview'));
        });
    </script>

@endsection

