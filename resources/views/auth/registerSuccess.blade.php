@extends('app')

@section('page-title')
    Register Success- {{Config::get('app.name')}}
@endsection

@section('navbar')
    @include('partials.fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-background">
                    <br>
                    <h3 class="text-center">You're almost there! Check your inbox</h3>
                    <br>
                    <img src="/images/mail-sleeping.png" width="130" height="130" class="center-block">
                    <br>

                    <b><p class="text-center">A verification link has been sent to {{$email}}.</p></b>
                    <br>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('footer')
    <div class="col-md-8 col-md-offset-2">
        @include('partials.footer')
    </div>
@endsection