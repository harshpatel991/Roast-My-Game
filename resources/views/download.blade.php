@extends('app')

@section('page-title')Download - {{Config::get('app.name')}}@endsection

@section('navbar')
    @include('partials/fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-background">
                    @include('partials.display-input-error')
                    <h1 class="form-title">Download {{$game->title}}</h1>

                    <div class="row">
                        <div class="col-md-4">
                            <img width="100%" height="100%" src="{{Utils::get_image_url($game->slug.'/'.$game->thumbnail)}}">
                        </div>
                        <div class="col-md-8">
                            Thanks for trying out {{$game->title}}. Click on the button below to download.
                            <br>
                            <br>
                            Be sure to leave a roast once you've played the game.
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <a id="download-btn" class="btn btn-success center-block" href="{{$downloadLink}}">Download</a>
                        </div>
                    </div>
                    <hr>

                    <div class="row"> {{--Related games row--}}
                        @if($relatedGames->count() > 0)
                            <h6 class="subheading subheading-color">Related Games</h6>
                            @foreach($relatedGames as $relatedGame)
                                @include('partials/card', ['game' => $relatedGame])
                            @endforeach
                        @endif
                    </div>

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