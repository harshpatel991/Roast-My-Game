@extends('emails.base')

@section('heading')Hey there!@endsection

@section('body1')Someone has replied to your comment. View it by clicking the button below.@endsection

@section('body2')@endsection

@section('button-link'){{ secure_url('game/' . $game->slug . '?utm_source=comment&utm_medium=email&utm_campaign=game_commented') }}@endsection

@section('button-text') VIEW COMMENT @endsection

@section('footer-text')Button not working? Try opening this link in your browser: @endsection

@section('footer-link'){{ secure_url('game/' . $game->slug . '?utm_source=comment&utm_medium=email&utm_campaign=game_commented') }}@endsection

@section('footer-link-text'){{ secure_url('game/' . $game->slug) }}@endsection