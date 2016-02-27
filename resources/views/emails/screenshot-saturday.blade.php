@extends('emails.base')

@section('heading')Happy Screenshot Saturday!@endsection

@section('body1')Hey there! We saw that {{$game->title}} hasn't been updated in awhile. Why not show the community your progress this Screenshot Saturday? Updating your game also gets your game back on the homepage so you can get more exposure!
@endsection

@section('body2')
    <br/>
    While you're there, roast a few games from other devs. The system only works if everyone is willing to share feedback.@endsection

@section('button-link'){{ secure_url('/add-version/'. $game->slug . '?utm_source=game&utm_medium=email&utm_campaign=screen_shot_saturday') }}@endsection

@section('button-text') ADD PROGRESS @endsection

@section('footer-text')Button not working? Try opening this link in your browser: @endsection

@section('footer-link'){{ secure_url('/add-version/'. $game->slug . '?utm_source=game&utm_medium=email&utm_campaign=screen_shot_saturday') }}@endsection

@section('footer-link-text'){{ secure_url('/add-version/'. $game->slug) }}@endsection
