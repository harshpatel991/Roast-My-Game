@extends('app')

@section('page-title')
    {{Config::get('app.name')}}
@endsection

@section('navbar')
    @include('partials/normalNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <div class="content-background" style="margin: 10px 0px;">
                    <h1 class="form-title">Register</h1>

                    <div class="panel panel-default">
                        <div class="panel-body">

                            {!! Form::open(array('route' => 'add-game', 'class'=>'form-horizontal', 'files'=>true,)) !!}

                            <div class="form-group">
                                {!! Form::label('email', 'Email', ['class' => 'col-sm-3 control-label form-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
                                </div>
                            </div>


                            <div class="form-group">
                                {!! Form::label('password', 'Password', ['class' => 'col-sm-3 control-label form-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-2">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>




                            <div class="row">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button id="add-game" class="btn btn-primary">Login</button>
                                    <a class="pull-right" href="{{ url('/password/email') }}">Forgot Your Password?</a>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                    <p>Don't have an account? <a href="/auth/register">Register</a> or <a href="/how-it-works">Learn More</a></p>

                </div>
            </div>
        </div>
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

        $("#thumbnail").change(function(){
            readURL(this, $('#thumbnail_thumbnail'));
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