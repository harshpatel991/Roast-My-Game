@extends('emails.base')

@section('heading')Hey there!@endsection

@section('body1')Thanks so much for joining Roast My Game! Verify your account by clicking the button below.@endsection

@section('button-link'){{ secure_url('verify/' . $confirmationCode) }}@endsection

@section('button-text') VERIFY ACCOUNT @endsection

@section('footer-text')Button not working? Try opening this link in your browser: @endsection

@section('footer-link'){{ secure_url('verify/' . $confirmationCode) }}@endsection

@section('footer-link-text'){{ secure_url('verify/' . $confirmationCode) }}@endsection