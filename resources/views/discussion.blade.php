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
                        <div class="col-sm-10"> {{--Left content--}}
                            <div class="text-content-padding">
                                <a href="{{secure_url('/forum')}}">← Back</a>
                                <h4 class="game-title">{{$discussion->title}}</h4>
                                <p class="small subheading-color text-uppercase" style="margin-bottom: 0px"><span class="fui-time"></span> {{$discussion->created_at->diffForHumans()}} by <a href="{{ secure_url('/profile/'.$discussion->user->username) }}">{{$discussion->user->username}}</a></p>
                                <p class="small-grey-box">{{$discussion->content}}</p>
                                <div class="label label-default"><span class="icon-eye"></span>{{$discussion->views}}</div>
                                <div class="label label-default text-uppercase">{{\App\Discussion::$categories[$discussion->category]}}</div>
                                @foreach($comments as $comment)
                                    @include('partials.comment_view', ['comment' => $comment, 'submitReplyPath' => '/forum-add-comment-reply'])
                                @endforeach
                                <hr>
                                @include('partials.forum_comment_form', ['action' => secure_url('/forum-add-comment/'.$discussion->slug)])
                            </div>
                        </div>

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

@section('scripts')

    <script>
        //display loader once button has been hit
        $('#main-reply-button').click(function() {
            $(this).html('Loading...' );
            $(this).removeClass('btn-primary');
            $(this).addClass('btn-default');
        });

        $(document).ready(function() {
            $('.reply-link').click(createForm);
            function createForm(e)
            {
                e.preventDefault();
                $(this).replaceWith('@include('partials/comment_child_form')');

                $("button[name='child-reply-button']").click(function() {
                    $(this).html('Loading...' );
                    $(this).removeClass('btn-primary');
                    $(this).addClass('btn-default');
                });
            }
        });
    </script>
@endsection