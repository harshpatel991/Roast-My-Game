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
            <div class="col-md-offset-1 col-md-10 col-sm-12">

                @include('partials.display-input-error')

                <h6 class="small" style="padding: 60px 5px 5px 5px;text-transform: uppercase">{{$pageTitle}} Games</h6>

                <div class="row" style="padding: 5px;">
                    <div class="col-sm-12">
                        <a href="/games/not-yet-roasted" class="label label-warning">NOT YET ROASTED</a>
                        <a href="/games" class="label label-default">ALL</a>
                        @foreach(array_slice(App\Game::$genres, 1) as $genreKey => $genre)
                            <a href="/games/{{$genreKey}}" class="label label-default">{{strtoupper($genre)}}</a>
                        @endforeach
                    </div>
                </div>

                @for ($rowIndex = 0; $rowIndex < ceil(count($games)/3); $rowIndex++)
                    <div class="row">
                        @for ($columnIndex = 0; $columnIndex < 4; $columnIndex++)
                            @if(($rowIndex*4) + $columnIndex < count($games))
                                @include('partials/card', ['game' => $games[($rowIndex*4) + $columnIndex]])
                            @endif
                        @endfor
                    </div>
                @endfor

            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1 small" style="margin-top: 30px;"><a href="/privacy-policy">
                    Privacy Policy</a> · <a href="/terms-conditions">Terms and Conditions</a>
                <span class="pull-right">2016 · {{Config::get('app.name')}} · <a href="/about">About</a> · <a href="/contact-us">Contact</a></span>
            </div>
        </div>

    </div>
@endsection

