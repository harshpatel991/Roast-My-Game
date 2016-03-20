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

                <div class="row">
                    <div class="col-md-3">
                        <div class="white-background-box">
                            <a href="{{ secure_url('/games/') }}" class="btn btn-sm btn-block btn-info">All Games</a>
                            <hr>
                            <a href="{{ secure_url('/games?roasted=false') }}" class="btn btn-sm btn-block btn-info">Not Yet Roasted</a>
                            <hr>

                            {!! Form::open(array('url' => secure_url('/games'), 'class'=>'form-horizontal', 'id' => 'search-game-form', 'method' => 'GET')) !!}
                                <div class="small subheading-color" style="font-weight: bold;">SEARCH</div>
                                <div class="form-group">
                                    {!! Form::text('query', $oldQuery, ['class' => 'form-control', 'placeholder' => 'Search']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::select('genre', App\Game::$genres, $oldGenre, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::select('platform', App\Game::$platformDropDown, $oldPlatform, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::select('order', ['' => 'Select Ordering', 'views' => 'Popular', 'created_at' => 'Recent'], $oldOrder, ['class' => 'form-control']) !!}
                                </div>

                                <button class="btn btn-sm btn-block btn-primary" id="submit-search" type="submit">Search</button>
                            {!! Form::close() !!}
                        </div>
                    </div>

                    <div class="col-md-9">
                        @for ($rowIndex = 0; $rowIndex < ceil(count($games)/3); $rowIndex++)
                            <div class="row">
                                @for ($columnIndex = 0; $columnIndex < 4; $columnIndex++)
                                    @if(($rowIndex*4) + $columnIndex < count($games))
                                        @include('partials/card', ['game' => $games[($rowIndex*4) + $columnIndex]])
                                    @endif
                                @endfor
                            </div>
                        @endfor

                        <div class="text-center">
                            {!! $games->appends(['query' => $oldQuery, 'genre' => $oldGenre, 'platform' => $oldPlatform, 'order' => $oldOrder])->render() !!}
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <hr>
            <div class="col-md-10 col-md-offset-1 small">
                <div class="pull-right">
                    <a href="{{ secure_url('/about') }}">About</a> · <a href="{{ secure_url('/contact-us') }}">Contact</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1 small">
                <div class="pull-right">
                    <a href="https://roastmygame.blogspot.com">Dev Blog</a> · <a href="https://twitter.com/RoastMyGame">Twitter</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1 small">
                <div class="pull-right">
                    <a href="{{ secure_url('/privacy-policy') }}">Privacy Policy</a> · <a href="{{ secure_url('/terms-conditions') }}">Terms and Conditions</a>
                </div>
            </div>
        </div>


    </div>
@endsection

