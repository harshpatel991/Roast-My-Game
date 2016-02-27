@extends('emails.base')

@section('heading')Password Reset @endsection

@section('body1')Click this button to reset your password @endsection

@section('body2')@endsection

@section('button-link'){{ secure_url('password/reset/'.$token) }}@endsection

@section('button-text') RESET PASSWORD @endsection

@section('footer-text')Button not working? Try opening this link in your browser: @endsection

@section('footer-link'){{ secure_url('password/reset/'.$token) }}@endsection

@section('footer-link-text'){{ secure_url('password/reset/'.$token) }}@endsection