@extends('app')

@section('page-title')General Discussion @endsection

@section('page-description') General discussion page for users @endsection

@section('navbar')
    @include('partials/fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">

        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div class="content-background">
                    @include('partials.display-input-error')
                    <div class="row"> {{--Main content row--}}
                        <div class="col-sm-10 col-xs-6">
                            <div class="text-content-padding">
                                <h4 class="game-title">Forum</h4>
                            </div>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                            <a class="btn btn-info" href="/add-discussion">Add Forum Post</a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">

                            @foreach($discussions as $discussion)
                                <tr>
                                    <td>
                                        <a href="{{ secure_url('/forum/' . $discussion->slug) }}" @if (!session($discussion->slug))style="font-weight: bold;"@endif>{{$discussion->title}}</a>
                                    </td>
                                    <td>by {{$discussion->user()->first()->username}}</td>
                                    {{--<td>{{$discussion->comments()->orderBy('created_at', 'desc')->take(1)->first()->created_at->diffForHumans()}}</td>--}}
                                    <td>{{$discussion->created_at->diffForHumans()}}</td>
                                    <td><div class="label label-default"><span class="icon-eye"></span>{{$discussion->views}} </div></td>
                                    <td><div class="label label-default text-uppercase">{{\App\Discussion::$categories[$discussion->category]}}</div></td>

                                </tr>
                            @endforeach

                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection

@section('footer')
    <div class="col-md-10 col-md-offset-1">
        @include('partials/footer')
    </div>
@endsection