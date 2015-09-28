@extends('app')

@section('page-title')
    {{Config::get('app.name')}}
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    <div class="col-md-4">
                        <a href="/add-game" class="btn btn-primary">Add Game</a>
                    </div>
                    <div class="col-md-4">
                        <a href="/game/test-game">Test Game</a>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection