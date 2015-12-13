@extends('app')

@section('page-title')
    {{Config::get('app.name')}}
@endsection

@section('navbar')
    @include('partials/fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-background">
                    <h1 class="form-title">{{$user->username}}'s Profile</h1>

                    @include('partials.display-input-error')

                    <h6>My Games</h6>
                    @if(count($games) > 0)
                        @foreach($games as $game)

                            <div class="media small-grey-box">
                                <div class="media-left">
                                    <a href="/game/{{$game->slug}}">
                                        <img class="media-object" width="150" height="100" src="{{Utils::get_image_url($game->latestScreenshot()->image1)}}"/>
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading"><a href="/game/{{$game->slug}}" style="color: #535353;">{{$game->title}}</a></h4>
                                    <p> <b>Views: </b>{{$game->views}} <b>Likes: </b>{{$game->likes}}</p>
                                </div>
                                <div class="media-right">
                                    <a class="btn btn-default" href="/add-version/{{$game->slug}}">Add Progress</a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <br>
                        <h4 class="text-center"><div class="font-light-gray">No games here!</div></h4>

                    @endif
                    <p class="text-center">
                        <a href="/add-game" class="btn btn-primary navbar-btn btn-lg">Add a Game</a>
                    </p>


                    <h6>My Comments</h6>
                    @if(count($comments) > 0)
                        @foreach($comments as $comment)
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <p>{{ $comment->body }}</p>
                                    <small>{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <br>
                        <h4 class="text-center"><div class="font-light-gray">No comments here!</div></h4>
                        <br>
                    @endif
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

@section('scripts')

@endsection

