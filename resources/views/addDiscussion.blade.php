@extends('app')

@section('page-title')Add Forum Post - {{Config::get('app.name')}}@endsection

@section('navbar')
    @include('partials/fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-background">
                    <h1 class="form-title" style="margin-bottom: 0px;">Add Forum Post</h1>
                    <h5 class="small" style=" margin-top: 0px; color: #c7c7c7;">Create a page for discussion or get to answers from the community.</h5>

                    @include('partials.display-input-error')

                    {!! Form::open(array('url' => secure_url('/add-discussion'), 'class'=>'form-horizontal', 'files'=>true, 'id' => 'add-discussion-form')) !!}

                    <div class="form-group">
                        {!! Form::label('title', 'Title*', ['class' => 'col-sm-2 control-label form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('title', old('title'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('category', 'Category*', ['class' => 'col-sm-2 control-label form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('category', App\Discussion::$categories, old('category'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('content', 'Content*', ['class' => 'col-sm-2 control-label form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => 6]) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button id="add-discussion" class="btn btn-success">Add Forum Post</button>
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
    <script type="text/javascript" src="vendor/jsvalidation/js/jsvalidation.js"></script>
    {!! JsValidator::formRequest('App\Http\Requests\StoreDiscussionRequest', '#add-discussion-form') !!}
@endsection

