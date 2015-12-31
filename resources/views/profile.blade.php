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

                    @include('partials.display-input-error')

                    <div class="row">
                        <div class="col-lg-6 col-md-5">
                            <h4 class="">{{$user->username}}'s Profile</h4>
                        </div>
                        <div class="col-lg-6 col-md-7">
                            <div class="row">
                                <div class="col-xs-4">
                                    <h4 class="text-center" style="margin-bottom: 0px">{{$versionsCount}}</h4>
                                    <p class="small text-center">Progress Updates</p>
                                </div>
                                <div class="col-xs-4" style="border-style: solid;border-width: 0px 1px;border-color: #ddd;">
                                    <h4 class="text-center" style="margin-bottom: 0px">{{$comments->count()}}</h4>
                                    <p class="small text-center">Comments</p>
                                </div>
                                <div class="col-xs-4">
                                    <h4 class="text-center" style="margin-bottom: 0px">{{$likes->count()}}</h4>
                                    <p class="small text-center">Likes</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6>My Games</h6>
                    @if(count($games) > 0)
                        @foreach($games as $game)

                            <div class="row small-grey-box">
                                <div class="col-md-3 ">
                                    <a href="/game/{{$game->slug}}">
                                        <img width="100%" height="100%" style="padding: 5px 0px;" src="{{Utils::get_image_url($game->slug.'/'.$game->latestScreenshot()->image1)}}"/>
                                    </a>
                                </div>
                                <div class="col-sm-8 col-md-5">
                                    <h4 class="media-heading"><a href="/game/{{$game->slug}}" style="color: #535353;">{{$game->title}}</a></h4>
                                    <p> <b>Views: </b>{{$game->views}} <b>Likes: </b>{{$game->likes}}</p>
                                </div>
                                <div class="col-sm-4">
                                    <a class="btn btn-info pull-right" href="/add-version/{{$game->slug}}">Add Progress</a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h4 class="text-center"><div class="font-light-gray">No games here</div></h4>
                        <br>
                    @endif

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
                        <h4 class="text-center"><div class="font-light-gray">No comments here</div></h4>
                        <br>
                    @endif

                    <h6>Liked</h6>
                    @if(count($likes) > 0)
                        @foreach($likes as $like)
                            <p><a href="/game/{{$like->game()->first()->slug}}">{{ $like->game()->first()->title }}</a></p>
                        @endforeach
                    @else
                        <h4 class="text-center"><div class="font-light-gray">No likes here</div></h4>
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

