@extends('app')

@section('page-title'){{$pageTitle}} Games - {{Config::get('app.name')}}@endsection

@section('page-description')Roast idle games, puzzle games, strategy games, Roast My Game is the best way to find indie developed games to voice your opinion.@endsection

@section('navbar')
    @include('partials/fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">

        <div class="row">
            <div class="col-md-offset-1 col-md-10 col-sm-12">

                @include('partials.display-input-error')

                <h6 style="padding: 60px 5px 5px 5px;text-transform: uppercase">{{$pageTitle}} Games</h6>

                <div class="white-background-box">

                    <a href="/games/" class="btn btn-sm {{\App\Http\Controllers\HomeController::buttonSelected($selectedButton, \App\Http\Controllers\HomeController::$RECENTLY_UPDATED)}}">All Games</a>
                    <a href="/games/not-yet-roasted" class="btn btn-sm {{\App\Http\Controllers\HomeController::buttonSelected($selectedButton, \App\Http\Controllers\HomeController::$NOT_YET_ROASTED)}}"><span class="icon-chat"></span> Not Yet Roasted</a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm {{\App\Http\Controllers\HomeController::buttonSelected($selectedButton, \App\Http\Controllers\HomeController::$GENRE)}} dropdown-toggle" id="genre-dropdown" data-toggle="dropdown">
                            @if(!isset($genre))Select Genre @else {{$pageTitle}} @endif <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @foreach(array_slice(App\Game::$genres, 1) as $genreKey => $genre)
                                <li><a href="/games/{{$genreKey}}">{{$genre}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm {{\App\Http\Controllers\HomeController::buttonSelected($selectedButton, \App\Http\Controllers\HomeController::$PLATFORM)}} dropdown-toggle" id="platform-dropdown" data-toggle="dropdown">
                            @if(!isset($platform))Select Platform @else {{$pageTitle}} @endif <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @foreach(App\Game::$platformDropDown as $platformLink => $platformName)
                                <li><a href="/games/by_platform/{{$platformLink}}"><span class="{{App\Game::$platformColumnToIcon['link_'.$platformLink]}}"></span> {{$platformName}}</a></li>
                            @endforeach
                        </ul>
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

