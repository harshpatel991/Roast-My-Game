@extends('app')

@section('page-title')
    Add Version - {{Config::get('app.name')}}
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

                    @include('partials.display-input-error')

                    {!! Form::open(array('url' => '/add-version/'.$game->slug, 'class'=>'form-horizontal', 'files'=>true)) !!}

                        @include('partials.version-form')

                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button id="add-game" class="btn btn-success">Add Progress!</button>
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

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\StoreVersionRequest') !!}

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

