@extends('app')

@section('page-title')Screenshot Saturday - {{Config::get('app.name')}}@endsection

@section('page-description') @endsection

@section('navbar')
    @include('partials.fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-background">
                    <h1>Emails</h1>

                    <div class="table-responsive">
                        <table class="table table-striped">

                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Views</th>
                                <th>User</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>

                            @foreach($games as $game)
                                <tr>
                                    <td>{{$game->id}}</td>
                                    <td>{{$game->title}}</td>
                                    <td>{{$game->views}}</td>
                                    <td>{{$game->user_id}}</td>
                                    <td>{{$game->created_at}}</td>
                                    <td>{{$game->updated_at}}</td>
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
    <div class="col-md-8 col-md-offset-2">
        @include('partials.footer')
    </div>
@endsection