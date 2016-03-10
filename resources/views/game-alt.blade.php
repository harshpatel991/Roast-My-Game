@extends('app')

@section('page-title'){{$game->title}} - {{Config::get('app.name')}}@endsection

@section('page-description'){{ substr(clean($game->description), 0, 150) }}@endsection

@section('navbar')
    @include('partials/fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="content-background">

                    <div class="row">
                        <div class="col-md-12">
                            @include('partials.display-input-error')
                            
                            @if(Auth::check() && $game->user_id === Auth::user()->id)
                            <div class="alert alert-default">
                                <h6 style="margin-top: 0px;">Ask your followers to help roast your game</h6>
                                <div class="row">
                                    <div class="col-sm-10">
                                        <input class="form-control placeholder-dark" type="text" value="{{$helpMessage = Utils::random_roast_message($game)}}" readonly="readonly">
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="https://twitter.com/intent/tweet?text={{urlencode($helpMessage)}}" class="btn btn-info btn-block" target="_blank"><span class="icon-twitter"></span> Tweet</a>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if(!Auth::check() && $isFirstTimeUser)
                                <div class="alert alert-default alert-dismissible hidden-xs" style="color: #5F697C;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h3 class="text-center" style="margin-top: 0px;">OH HEY THERE!</h3>
                                    <div class="text-center" style="font-size: 20px; font-weight: 100;">
                                        Roast My Game is a site for game devs to give and get feedback. After you're done looking around, create an account and join in!
                                    </div>
                                </div>
                            @endif

                            <div class="row"> {{--hero row--}}
                                <div class="col-sm-10"> {{--Hero left--}}
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <div class="embed-responsive-item">
                                            <img class="full-width-constrain-proportions center-block" id="mainImage" src="{{Utils::get_image_url($game->slug.'/'.$currentVersion->image1)}}"/>

                                            @if(!empty($video_thumbnail))
                                                <iframe id="ytplayer" type="text/html"
                                                        src="https://www.youtube.com/embed/{{$video_thumbnail}}?modestbranding=1&rel=0&showinfo=0&color=white"
                                                        frameborder="0"></iframe>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-xs-12">{{--Hero right--}}
                                    <div class="row">

                                        @if(!empty($video_thumbnail))
                                            <div class="col-sm-12 col-xs-2" style="margin-bottom: 6px; padding-right:1px;">
                                                <div class="embed-responsive embed-responsive-16by9 position-relative">
                                                    <img class="embed-responsive-item" src="https://img.youtube.com/vi/{{$video_thumbnail}}/mqdefault.jpg"/>
                                                    <div class="overlay-thumbnail"></div>
                                                    <div class="overlay-play" onclick="selectVideo()"></div>
                                                </div>
                                            </div>
                                        @endif

                                        @foreach($images as $image)
                                                <div class="col-sm-12 col-xs-2" style="margin-bottom: 5px; padding-right:1px;">
                                                    <div class="embed-responsive embed-responsive-16by9 position-relative card-imager-wrapper">
{{--                                                        <img class="embed-responsive-item" src="{{Utils::get_image_url($game->slug.'/'.$image)}}" />--}}
                                                        <div class="embed-responsive-item card-image-contain" style="background-image: url('{{Utils::get_image_url($game->slug.'/'.$image)}}');"> </div>
                                                        <div class="overlay-thumbnail" onclick="selectImage('{{Utils::get_image_url($game->slug.'/'.$image)}}')"></div>
                                                    </div>
                                                </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row"> {{--Info bar--}}
                        <div class="col-sm-6">
                            <div class="text-content-padding">

                                <a href="{{ secure_url('/games/'.$game->genre) }}" class="label label-default">{{strtoupper($game->genre)}}</a>
                                @if($currentVersion->beta)
                                    <div class="label label-default">BETA</div>
                                @endif

                                <div class="label label-default"><span class="icon-eye"></span>{{$game->views}} </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="text-content-padding">
                                <div class="btn-group pull-right" style="padding-left: 10px;">
                                    <button type="button" class="btn btn-transparent-silver dropdown-toggle" data-toggle="dropdown" id="version-dropdown">Version {{$currentVersion->version}}<span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        @foreach($versions as $version)
                                            <li><a href="{{ secure_url('/game/'.$game->slug.'/'.$version->slug) }}" id="version-{{$version->slug}}">Version {{$version->version}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="btn-favorite-container pull-right">
                                    @if($isLiked)
                                        <div class="btn btn-success"><span class="icon-heart"></span> {{$game->likes}} </div>
                                    @else
                                        <div class="btn btn-favorite"><span class="icon-heart"></span> {{$game->likes}} </div>
                                        <div id="btn-favorite-background" class="btn btn-favorite btn-favorite-background"><span class="icon-heart"></span> {{$game->likes}} </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-9">
                            <h3 class="game-title">{{$game->title}}</h3>
                            <p class="small subheading-color text-uppercase" style="margin-bottom: 0px"><span class="fui-time"></span> {{$game->created_at->diffForHumans()}} by <a href="{{ secure_url('/profile/'.$game->user->username) }}">{{$game->user->username}}</a></p>
                        </div>
                        <div class="col-sm-3">
                            @if(count($platform_Icon_Name_Link) > 0)
                                <div class="text-content-padding">
                                    <div class="btn-group btn-block">
                                        <button type="button" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown" id="download-dropdown">Download <span class="caret"></span></button>
                                        <ul class="dropdown-menu btn-block">
                                            @foreach($platform_Icon_Name_Link as $platform)
                                                <li>
                                                    <a href="{{$platform[2]}}" target="_blank" rel="nofollow">
                                                        <span class="{{$platform[0]}}"></span>
                                                        <span>{{$platform[1]}}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row"> {{--Main content row--}}
                        <div class="col-sm-9"> {{--Left content--}}
                            <div class="text-content-padding">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active small "><a href="#tab-description" class="bold-uppercase" role="tab" data-toggle="tab"><span class="icon-info-circled visible-xs-block"></span><span class="hidden-xs">Description</span></a></li>
                                    @if(strlen($currentVersion->changes) > 0) <li role="presentation" class="small"><a href="#tab-changes" class="bold-uppercase" role="tab" data-toggle="tab" id="link-tab-changes"><span class="icon-exchange visible-xs-block"></span><span class="hidden-xs">Changes</span></a></li> @endif
                                    @if(strlen($currentVersion->upcoming_features) > 0) <li role="presentation" class="small"><a href="#tab-upcoming_features" class="bold-uppercase" role="tab" data-toggle="tab" id="link-tab-upcoming_features"><span class="icon-arrows-cw visible-xs-block"></span><span class="hidden-xs">Upcoming Features</span></a></li> @endif
                                </ul>
                                <div class="small-grey-box" style="margin-top: 0px;">
                                    <!-- Tab panes -->
                                    <div class="tab-content" style="padding: 10px 0">
                                        <div role="tabpanel" class="tab-pane active fade in" id="tab-description">
                                            @if(strlen($game->description) > 0)
                                                <p>{!! clean($game->description) !!}</p>
                                            @endif
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="tab-changes">
                                            @if(strlen($currentVersion->changes) > 0)
                                                <p>{!! clean($currentVersion->changes) !!}</p>
                                            @endif
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="tab-upcoming_features">
                                            @if(strlen($currentVersion->upcoming_features) > 0)
                                                <p> {!! clean($currentVersion->upcoming_features) !!}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <h6 class="subheading subheading-color">Comments</h6>
                                @if($game->comments()->count() > 0)
                                    @foreach($game->comments as $comment)
                                        @include('partials.comment_view', ['comment' => $comment, 'submitReplyPath' => '/add-comment-reply'])
                                    @endforeach
                                @else
                                    @if(Auth::check() && $game->user_id === Auth::user()->id)
                                        <p>No roasts here!</p>
                                        <p><b>Roasting other games is a great way to get other devs to roast your game.</b></p>
                                    @else
                                        <p>Nobody's roasted yet, be the first!</p>
                                    @endif
                                @endif

                                <h6 class="subheading subheading-color">Roast Em</h6>
                                @include('partials.comment_form', ['action' => secure_url('/add-comment/'.$game->slug)])

                            </div>
                        </div>

                        <div class="col-sm-3"> {{--Right content--}}
                            <div class="">
                                @if(count($linkIcons) > 0)
                                    <div class="small-grey-box">
                                        <div class="small subheading-color" style="font-weight: bold;">LINKS</div>
                                        <hr>
                                        @foreach($linkIcons as $link_id => $linkIcon)
                                            <div style="margin-bottom: 5px;">
                                                <span class="{{$linkIcon}}"></span>
                                                {{$linkTexts[$link_id]}}
                                                <a href="{{$socialLinks[$link_id]}}" target="_blank" rel="nofollow">
                                                    <span class="icon-link-ext-alt small"></span>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="small-grey-box">
                                    <div class="small subheading-color" style="font-weight: bold;">SHARE THIS ROAST</div>
                                    <hr>
                                    <div style="margin-bottom: 5px;">
                                        <a href="https://twitter.com/intent/tweet?url={{Request::url()}}&text=Roast my game"><img src="/images/twitter.png" class="social-media-icons"></a>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{Request::url()}}"><img src="/images/facebook.png" class="social-media-icons"></a>
                                        <a href="https://plus.google.com/share?url={{Request::url()}}"><img src="/images/google-plus.png" class="social-media-icons"></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row"> {{--Related games row--}}
                        @if($relatedGames->count() > 0)
                            <h6 class="subheading subheading-color">Related Games</h6>
                            @foreach($relatedGames as $relatedGame)
                                @include('partials/card', ['game' => $relatedGame])
                            @endforeach
                        @endif
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
        var mainImage = $('#mainImage');
        var youtubePlayer = $('#ytplayer');

        function selectVideo() {
            mainImage.fadeTo( "fast", .8, function() {
                youtubePlayer.fadeTo( 0, 1);
            });
        }

        function selectImage(newImage) {


            mainImage.fadeTo( "fast", .8, function() {
                youtubePlayer.hide();
                mainImage.attr('src', newImage);
                mainImage.fadeTo( "fast", 1);
            });
        }
    </script>

    <script>
        $('.btn-favorite-background').on('click', function() {

            $('.btn-favorite-background').addClass('btn-favorite-background-animate');

            $.ajax({
                type: "POST",
                url: '/like/{{$game->slug}}',
                beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');},
                success: function(data) {
                    console.log(data);
                    $('.btn-favorite').html('<span class="icon-heart"></span> '+ data);
                    $('.btn-favorite').addClass('btn-success').removeClass('btn-favorite');
                }
            }).fail(function(data) {
                console.log(data);
                if(data.status == 401) {
                    window.location.href = "/auth/login";
                }
                $('.btn-favorite').html('<span class="icon-cancel"></span> Error');
                $('.btn-favorite').addClass('btn-danger').removeClass('btn-favorite');
            });

            setTimeout(function(){
                $('.btn-favorite-background').remove();
            },400);
        });
    </script>

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