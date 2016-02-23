@extends('app')

@section('page-title')Contact Us - {{Config::get('app.name')}}@endsection

@section('navbar')
    @include('partials/fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-background">
                    <h1 class="form-title">Contact Us</h1>

                    @include('partials.display-input-error')


                    <p>Questions, comments, concerns? Post 'em below, we'll get back to you as soon as we can.</p>

                    <div class="panel panel-default">
                        <div class="panel-body">

                            <form class="form-horizontal" role="form" method="POST" action="/contact-us">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    {!! Form::label('email', 'email', ['class' => 'col-md-3 control-label form-label']) !!}
                                    <div class="col-sm-7">
                                        {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('message', 'message', ['class' => 'col-md-3 control-label form-label']) !!}
                                    <div class="col-md-7">
                                        <textarea class="form-control" name="message" id="message" rows="10">{{ old('message') }}</textarea>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-md-7 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary" id="submit-contact-us">Submit</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                    <br>


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


