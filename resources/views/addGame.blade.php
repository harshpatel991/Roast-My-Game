@extends('app')

@section('page-title')Add Game - {{Config::get('app.name')}}@endsection

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

                    {!! Form::open(array('route' => 'add-game', 'class'=>'form-horizontal', 'files'=>true, 'id' => 'add-game-form')) !!}

                        @include('partials.game-form')

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
    @include('partials/game-script-init')
    @include('partials/version-script-init')

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\StoreGameRequest', '#add-game-form') !!}

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

        $("#thumbnail").change(function(){
            readURL(this, $('#thumbnail-preview'));
        });

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

