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
                        <div class="col-lg-2 col-md-3 col-sm-2 col-xs-2">
                            <img width="100%" height="100%" class="media-object" src="{{$user->profile_image}}">
                        </div>
                        <div class="col-lg-7 col-md-5 col-sm-8 col-xs-10">
                            <h4>{{$user->username}}'s Profile</h4>
                            <p class="bold-uppercase subheading-color">Ranked #{{$user->getRank()}}</p>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-2 col-xs-12">
                            <div class="trophy-box" style="background-image: url('/images/{{$user->getTrophyImage()}}');">
                                <h5 class="text-center" style="margin-bottom: 0px" id="level">{{$user->getLevel()}}</h5>
                            </div>
                            <b><p class="text-center" style="margin-bottom: 0px">{{$user->points}} Points{!! $user->getBadge() !!}</p></b>
                        </div>
                    </div>



                    <h6 class="subheading subheading-color">Games</h6>
                    @if(count($games) > 0)
                        @foreach($games as $game)

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <a href="/game/{{$game->slug}}">
                                            <div class="embed-responsive-item card-image-cover" style="background-image: url('{{Utils::get_image_url($game->slug.'/'.$game->thumbnail)}}');"> </div>
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
                                        <a class="btn btn-info pull-right btn-block" href="/add-version/{{$game->slug}}">Add Progress</a>
                                        <a class="btn btn-info pull-right btn-block" href="/edit-game/{{$game->slug}}/{{$game->versions->first()->slug}}" id="edit-{{$game->slug}}">Edit Game</a>
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
                            <p><a href="/game/{{$like->game->slug}}">{{ $like->game->title }}</a></p>
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