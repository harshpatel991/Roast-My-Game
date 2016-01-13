@extends('app')

@section('page-title')Register - {{Config::get('app.name')}}@endsection

@section('page-description')Register on Roast My Game to add your game and also comment and like other games.@endsection

@section('navbar')
    @include('partials.fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-background">
                    @include('partials.display-input-error')
                    <h1 class="form-title" style="margin-bottom: 0px;">Register</h1>

                    <p class="small">With an account you can add your game, roast games, and like games. <a href="/about">Learn more.</a></p>

                    {!! Form::open(array('url' => '/auth/register', 'class'=>'form-horizontal', 'files'=>true,)) !!}

                    <div class="form-group">
                        {!! Form::label('username', 'Username', ['class' => 'col-sm-3 control-label form-label']) !!}
                        <div class="col-sm-6">
                            {!! Form::text('username', old('username'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

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
                        {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'col-sm-3 control-label form-label']) !!}
                        <div class="col-sm-6">
                            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-offset-4 col-sm-4">
                            <button type="submit" id="register" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <br>
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <p class="small">Already have an account? <a href="/auth/login">Login</a></p>
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

@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! $validator !!}

@endsection