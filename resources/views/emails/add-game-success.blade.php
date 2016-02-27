@extends('emails.base')

@section('heading')Ready for Roasting!@endsection

@section('body1')Your game is now live! See it here:
<a href="{{ secure_url('game/' . $game->slug . '?utm_source=comment&utm_medium=email&utm_campaign=game_roasted') }}">{{ secure_url('game/' . $game->slug) }}</a>
@endsection

@section('body2')
    <br/>
    The best way to get your game roasted is to start roasting other games. Users will notice your game and start roasting back!@endsection

@section('button-link'){{ secure_url('/games' . '?utm_source=game&utm_medium=email&utm_campaign=game_added') }}@endsection

@section('button-text') START ROASTING @endsection

@section('footer-text')Button not working? Try opening this link in your browser: @endsection

@section('footer-link'){{ secure_url('/games' . '?utm_source=game&utm_medium=email&utm_campaign=game_added') }}@endsection

@section('footer-link-text'){{ secure_url('/games') }}@endsection
