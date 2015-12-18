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

                    @include('partials.display-input-error')

                    {!! Form::open(array('route' => 'add-game', 'class'=>'form-horizontal', 'files'=>true,)) !!}

                        {!! Form::myInput('title', 'Title*') !!}

                        <div class="form-group">
                            {!! Form::label('genre', 'Genre*', ['class' => 'col-sm-2 control-label form-label']) !!}
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
                                {!! Form::myCheckbox('platforms[]', 'PC', 'platform_pc') !!}
                            </div>
                            <div class="col-sm-2">
                                {!! Form::myCheckbox('platforms[]', 'iOS', 'platform_ios') !!}
                            </div>
                            <div class="col-sm-6">
                                {!! Form::myCheckbox('platforms[]', 'Unity Web', 'platform_unity') !!}
                            </div>
                            <div class="col-sm-2">
                                {!! Form::myCheckbox('platforms[]', 'Mac', 'platform_mac') !!}
                            </div>
                            <div class="col-sm-2">
                                {!! Form::myCheckbox('platforms[]', 'Android', 'platform_android') !!}
                            </div>
                            <div class="col-sm-3">
                                {!! Form::myCheckbox('platforms[]', 'Other Web', 'platform_other') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <a class="btn btn-primary col-sm-offset-2" role="button" data-toggle="collapse" href="#collapsePlatformLinks">Add Platform Links <span class="fui-triangle-down"></span></a>
                            <div class="collapse" id="collapsePlatformLinks" style="padding-top: 10px;">
                                <div class="col-sm-offset-2">
                                <p>If your game is avaiable to play, add links to download your game</p>
                                </div>
                                {!! Form::myInput('link_platform_pc', 'PC', '') !!}
                                {!! Form::myInput('link_platform_mac', 'Mac', '') !!}
                                {!! Form::myInput('link_platform_ios', 'iOS', '') !!}
                                {!! Form::myInput('link_platform_android', 'Android', '') !!}
                                {!! Form::myInput('link_platform_unity_web', 'Unity Web', '') !!}
                                {!! Form::myInput('link_platform_other', 'Other Web', '') !!}

                            </div>
                        </div>

                        <div class="form-group">
                            <a class="btn btn-primary col-sm-offset-2" role="button" data-toggle="collapse" href="#collapseSocialLinks">Add Social Links <span class="fui-triangle-down"></span></a>
                            <div class="collapse" id="collapseSocialLinks" style="padding-top: 10px;">
                                {!! Form::myInput('link_social_greenlight', 'Greenlight', '') !!}
                                {!! Form::myInput('link_social_website', 'Website', '') !!}
                                {!! Form::myInput('link_social_twitter', 'Twitter', '') !!}
                                {!! Form::myInput('link_social_youtube', 'YouTube', '') !!}
                                {!! Form::myInput('link_social_google_plus', 'Google+', '') !!}
                                {!! Form::myInput('link_social_facebook', 'Facebook', '') !!}
                            </div>
                        </div>

                        <hr>
                    <h5 class="small" style="margin-bottom: 0px; color: #c7c7c7;">You'll be able to add more progress after your game is added</h5>
                        <h4 class="small">CURRENT VERSION</h4>


                        @include('partials.version-form')

                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button id="add-game" class="btn btn-success">Add Game!</button>
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
    <script src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>

    <script>
    tinymce.init({
        selector: '#upcoming_features',
        menubar: '',
        toolbar: 'bold italic | link image | alignleft aligncenter alignright, | bullist numlist',
        plugins: [
            'advlist autolink link'
        ],
        statusbar: false,
        content_css: 'css/tinymce.css',
        editor_css: 'css/editor.css',
        skin: "custom"
      });
    </script>

    <script>
        tinymce.init({
            selector: '#changes',
            menubar: '',
            toolbar: 'bold italic | link image | alignleft aligncenter alignright, | bullist numlist',
            plugins: [
                'advlist autolink link'
            ],
            statusbar: false,
            content_css: 'css/tinymce.css',
            skin: "custom"
        });
    </script>

    <script>
        tinymce.init({
            selector: '#description',
            menubar: '',
            toolbar: 'bold italic | link image | alignleft aligncenter alignright, | bullist numlist',
            plugins: [
                'advlist autolink link'
            ],
            statusbar: false,
            content_css: 'css/tinymce.css',
            skin: "custom"
        });
    </script>

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
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

