@extends('app')

@section('page-title')
    {{Config::get('app.name')}}
@endsection

@section('navbar')
    @include('partials/fixedNav')
@endsection

@section('content')
    <div class="container-fluid" style="background-color: #f6f6f6;">

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="content-background">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="row"> {{--hero row--}}
                                <div class="col-sm-10"> {{--Hero left--}}
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <img class="embed-responsive-item full-width-constrain-proportions center-block" id="mainImage" src="{{Utils::get_image_url($currentVersion->image1)}}"/>

                                        @if(!empty($video_thumbnail))
                                            <iframe id="ytplayer" type="text/html"
                                                    src="http://www.youtube.com/embed/{{$video_thumbnail}}?modestbranding=1&rel=0&showinfo=0&color=white"
                                                    frameborder="0"></iframe>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-2 col-xs-12">{{--Hero right--}}
                                    <div class="row">

                                        @if(!empty($video_thumbnail))
                                            <div class="col-sm-12 col-xs-2" style="margin-bottom: 6px;">
                                                <div class="embed-responsive embed-responsive-16by9 position-relative">
                                                    <img class="embed-responsive-item" src="http://img.youtube.com/vi/{{$video_thumbnail}}/mqdefault.jpg"/>
                                                    <div class="overlay-thumbnail"></div>
                                                    <div class="overlay-play" onclick="selectVideo()"></div>
                                                </div>
                                            </div>
                                        @endif

                                        @foreach($images as $image)
                                                <div class="col-sm-12 col-xs-2" style="margin-bottom: 5px;">
                                                    <div class="embed-responsive embed-responsive-16by9 position-relative">
                                                        <img class="embed-responsive-item" src="{{Utils::get_image_url($image)}}" />
                                                        <div class="overlay-thumbnail" onclick="selectImage('{{Utils::get_image_url($image)}}')"></div>
                                                    </div>
                                                </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row"> {{--Info bar--}}
                        <div class="col-md-12">

                            <div class="text-content-padding">

                                <div class="label label-default">{{strtoupper($game->genre)}}</div>
                                @if($currentVersion->beta)
                                    <div class="label label-default">BETA</div>
                                @endif

                                <div class="label label-default"> <span class="fui-eye"></span> {{$game->views}} </div>

                                <div class="btn-group pull-right" style="padding-left: 10px;">
                                    <button type="button" class="btn btn-transparent-silver dropdown-toggle" data-toggle="dropdown">VERSION {{$currentVersion->version}}<span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        @foreach($versions as $version)
                                            <li><a href="/game/{{$game->slug}}/{{$version->slug}}">{{$version->version}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="btn-favorite-container pull-right">
                                    @if($isLiked)
                                        <div class="btn btn-success"><span class="fui-heart"></span> {{$game->likes}} </div>
                                    @else
                                        <div class="btn btn-favorite"><span class="fui-heart"></span> {{$game->likes}} </div>
                                        <div id="btn-favorite-background" class="btn btn-favorite btn-favorite-background"><span class="fui-heart"></span> {{$game->likes}} </div>
                                    @endif
                                </div>




                            </div>


                        </div>
                    </div>

                    <div class="row"> {{--Main content row--}}
                        <div class="col-sm-9"> {{--Left content--}}
                            <div class="text-content-padding">
                                <h3 style="margin-bottom: 0px; margin-top: 0px;">{{$game->title}}</h3>

                                <p class="small" style="color:#bfbfbf;"><span class="fui-time"></span> {{strtoupper($game->created_at->diffForHumans())}} BY {{strtoupper($game->user()->first()->username)}}  </p>

                                <p style="font-weight: bold;">DESCRIPTION</p>
                                <p>{{$game->description}}</p>

                                <p style="font-weight: bold;">CHANGES THIS VERSION</p>
                                <p>{{$currentVersion->changes}}</p>

                                <p style="font-weight: bold;">UPCOMING FEATURES</p>
                                <p> {{$currentVersion->upcoming_features}}</p>

                            </div>
                        </div>

                        <div class="col-sm-3"> {{--Right content--}}

                            <div class="text-content-padding">
                                <div class="small-grey-box">
                                    <div class="small text-center" style="font-weight: bold;">FOLLOW</div>
                                    <hr>
                                    @foreach($linkIcons as $link_id => $linkIcon)
                                        <div style="background-color: #F1F1F1; margin-bottom: 5px;">
                                            <a class="small" href="{{$links[$link_id]}}" style="color: #5d5d5d;"><i class="demo-icon {{$linkIcon}}"></i>{{$linkTexts[$link_id]}}</a>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="small-grey-box">
                                    <div class="small text-center" style="font-weight: bold;">PLATFORMS</div>
                                    <hr>
                                    @foreach($platformIconsToNames as $platform => $platformName)
                                        <div class="small" style="color: #5d5d5d; background-color: #F1F1F1; margin-bottom: 5px;">
                                            <i class="demo-icon {{$platform}}"></i>{{$platformName}}
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="text-content-padding">
                                    <div id="disqus_thread"></div>
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
                url: '/favorite/{{$game->slug}}',
                beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');},
                success: function(data) {
                    console.log(data);
                    $('.btn-favorite').html('<span class="fui-heart"></span> '+ data);
                    $('.btn-favorite').addClass('btn-success').removeClass('btn-favorite');
                }
            }).fail(function(data) {
                $('.btn-favorite').html('<span class="fui-cross"></span> Error');
                $('.btn-favorite').addClass('btn-danger').removeClass('btn-favorite');
            });

            setTimeout(function(){
                $('.btn-favorite-background').remove();
            },400);
        });
    </script>

    <script>
        /**
         * RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
         * LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
         */
        /*
         var disqus_config = function () {
         this.page.url = PAGE_URL; // Replace PAGE_URL with your page's canonical URL variable
         this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
         };
         */
        (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');

            s.src = '//unityclickr.disqus.com/embed.js';

            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>

@endsection