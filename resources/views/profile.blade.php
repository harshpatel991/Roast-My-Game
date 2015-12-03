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
                    <h3>{{$user->username}}'s Profile</h3>

                    <h5>My Games</h5>
                    @if(count($games) > 0)
                        @foreach($games as $game)

                            <div class="media small-grey-box">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object" width="150" height="100" src="{{Utils::get_image_url($latestImage)}}"/>
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">{{$game->title}}</h4>
                                    <p> <b>Views: </b>{{$game->views}} <b>Likes: </b>{{$game->likes}}</p>
                                </div>
                                <div class="media-right">
                                    <a class="btn btn-default" href="/add-version/{{$game->slug}}">Add Progress</a>
                                </div>
                            </div>
                        @endforeach

                        <a href="/add-game" class="btn btn-primary navbar-btn btn-lg pull-right">Add Game</a>
                    @else
                        <h3 class="text-center"><div class="font-light-gray">There's nothing here!</div>
                        <br>
                        <a href="/add-game" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Post</a> </h3>
                    @endif
                    <br>
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

