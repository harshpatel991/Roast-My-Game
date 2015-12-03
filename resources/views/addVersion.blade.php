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
                    <h1 class="form-title">Add Progress</h1>

                    {!! Form::open(array('url' => '/add-version/'.$game->slug, 'class'=>'form-horizontal', 'files'=>true,)) !!}

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

