@extends('app')

@section('page-title')
    {{Config::get('app.name')}}
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>{{$game->title}}</h1>

                <p><b>Developer:</b> {{$game->developer_name}}</p>
                <p><b>File:</b> {{$game->game_file}}</p>
                <p><b>Version:</b> {{$game->version}}</p>
                <p><b>Beta:</b> {{$game->beta}}</p>
                <p><b>Genre:</b> {{$game->genre}}</p>

                <p><b>Description:</b> {{$game->description}}</p>
                <p><b>Controls:</b> {{$game->controls}}</p>
                <p><b>Likes:</b> {{$game->likes}}</p>
                <p><b>Dislikes:</b> {{$game->dislikes}}</p>
                <p><b>Views:</b> {{$game->views}}</p>
                <p><b>Email:</b> {{$game->email}}</p>

                <p><b>Posted On:</b> {{$game->created_at}}</p>

            </div>

        </div>
    </div>

@endsection