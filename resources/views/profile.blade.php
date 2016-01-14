@extends('app')

@section('page-title'){{$user->username}}'s Profile - {{Config::get('app.name')}}@endsection

@section('page-description')View {{$user->username}}'s Profile on Roast My Game.@endsection

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

                    <h6 class="subheading subheading-color">Games</h6>
                    @if(count($games) > 0)
                        @foreach($games as $game)

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <a href="/game/{{$game->slug}}">
                                            <img class="embed-responsive-item" src="{{Utils::get_image_url($game->slug.'/'.$game->latestScreenshot()->image1)}}"/>
                                        </a>
                                    </div>
                                </div>

                                <div class="@if($isTheLoggedInUser) col-sm-6 @else col-sm-9 @endif">
                                    <a href="/game/{{$game->slug}}"><h6 class="list-group-item-heading card-title">{{$game->title}}</h6></a>

                                    <div class="label label-default" style="margin-right: 5px;"><span class="icon-eye"></span> {{$game->views}} </div>
                                    <div class="label label-default"><span class="icon-heart"></span> {{$game->likes}} </div>
                                    <p class="list-group-item-text card-description">{{clean($game->description, 'noneAllowed')}}</p>
                                </div>

                                @if($isTheLoggedInUser)
                                    <div class="col-sm-3">
                                        <a class="btn btn-info btn-block" href="/add-version/{{$game->slug}}">Add Progress</a>
                                    </div>
                                @endif

                            </div>
                            <hr>
                        @endforeach
                    @else
                        <h4 class="text-center"><div class="font-light-gray">No games here</div></h4>
                        <br>
                    @endif

                    <h6 class="subheading subheading-color">Roasts</h6>
                    @if(count($comments) > 0)
                        @foreach($comments as $comment)
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    @if(isset($comment->positive))
                                        <i class="icon-thumbs-up-alt font-light-gray"></i> {{ App\Feedback::$feedbackCategories[$comment->positive] }}  @endif

                                    @if(isset($comment->negative)) <b><i class="icon-thumbs-down-alt font-light-gray"></i></b> {{ App\Feedback::$feedbackCategories[$comment->negative] }}  @endif

                                    <p>{!! str_replace( "\n", '<br />', clean($comment->body)) !!}</p>
                                    <small><span class="icon-clock"></span> {{ $comment->created_at->diffForHumans() }}
                                        <a href="/game/{{App\Game::where('id', $comment->commentable_id)->first()->slug}}"><span class="icon-link-ext-alt small"></span></a>
                                    </small>

                                </div>
                            </div>
                        @endforeach
                    @else
                        <h4 class="text-center"><div class="font-light-gray">No comments here</div></h4>
                        <br>
                    @endif

                    <h6 class="subheading subheading-color">Liked</h6>
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