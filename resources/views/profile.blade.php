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
                    <h2>{{$user->username}}'s Profile</h2>

                    <h5>My Games</h5>
                    @if(count($games) > 0)
                        @foreach($games as $game)
                            <div class="embed-responsive embed-responsive-16by9">
                                <img class="embed-responsive-item" src="/images/{{$latestImage}}"/>
                            </div>

                            <h4>{{$game->title}}</h4>
                            <p>{{$game->views}}</p>
                            <p>{{$game->likes}}</p>
                        @endforeach
                    @else
                        <h3 class="text-center"><div class="font-light-gray">There's nothing here!</div>
                        <br>
                        <a href="/add-game" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Post</a> </h3>
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

