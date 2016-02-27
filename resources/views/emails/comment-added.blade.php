@extends('emails.base')

@section('heading')Hey there!@endsection

@section('body1')Someone has roasted {{$game->title}}. View it by clicking the button below. <br><br><b>Be sure to pay it forward by roasting another game.</b>@endsection

@section('body2')@endsection

@section('button-link'){{ secure_url('game/' . $game->slug . '?utm_source=comment&utm_medium=email&utm_campaign=game_roasted') }}@endsection

@section('button-text') VIEW ROAST @endsection

@section('footer-text')Button not working? Try opening this link in your browser: @endsection

@section('footer-link'){{ secure_url('game/' . $game->slug . '?utm_source=comment&utm_medium=email&utm_campaign=game_roasted') }}@endsection

@section('footer-link-text'){{ secure_url('game/' . $game->slug) }}@endsection
