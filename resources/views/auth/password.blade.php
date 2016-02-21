@extends('app')

@section('page-title')
    Forgot Your Password - {{Config::get('app.name')}}
@endsection

@section('navbar')
    @include('partials.fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-background">
                    <h1 class="form-title">Reset Password</h1>

                    @include('partials.display-input-error')

                    <p>Enter your email below. A link allowing you to reset your password will be emailed to you.</p>

                    {!! Form::open(array('url' => '/password/email', 'class'=>'form-horizontal')) !!}
                        <div class="form-group">
                            {!! Form::label('email', 'Email', ['class' => 'col-sm-3 control-label form-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-offset-4 col-sm-4">
                                <button type="submit" id="send-reset-link" class="btn btn-primary btn-block">Send Reset Link</button>
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
        @include('partials.footer')
    </div>
@endsection