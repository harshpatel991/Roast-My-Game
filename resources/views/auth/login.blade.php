@extends('app')

@section('page-title')Login - {{Config::get('app.name')}}@endsection

@section('page-description')Login to Roast My Game to add your game and also comment and like other games.@endsection

@section('navbar')
    @include('partials.fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-background">

                    @include('partials.display-input-error')

                    <h1 class="form-title">Login</h1>
                    {!! Form::open(array('url' => secure_url('/auth/login'), 'class'=>'form-horizontal', 'files'=>true)) !!}

                    <div class="form-group">
                        {!! Form::label('email', 'Email', ['class' => 'col-sm-3 control-label form-label']) !!}
                        <div class="col-sm-6">
                            {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('password', 'Password', ['class' => 'col-sm-3 control-label form-label']) !!}
                        <div class="col-sm-6">
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('remember', 'Remember Me', ['class' => 'col-sm-3 col-xs-4 control-label form-label']) !!}
                        <div class="col-xs-3">
                            {!! Form::checkbox('remember', 'true', old("remember")) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-offset-4 col-sm-4">
                            <button type="submit" id="login" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <br>
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <p class="small"><a href="{{ secure_url('/password/email') }}">Forgot Your Password?</a> Don't have an account? <a href="{{ secure_url('/auth/register') }}">Register</a></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <div class="col-md-8 col-md-offset-2">
        @include('partials.footer')
    </div>
@endsection