@extends('app')

@section('page-title')
    {{Config::get('app.name')}}
@endsection

@section('navbar')
    @include('partials.fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-background">
                    <h1 class="form-title">Register</h1>

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

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
                            <button id="add-game" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <br>
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <p class="small">Already have an account? <a href="/login">Login</a> or <a href="/how-it-works">Learn More</a></p>
                            <br>
                            <br>
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