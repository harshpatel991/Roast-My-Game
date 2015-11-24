@extends('app')

@section('page-title')
    {{Config::get('app.name')}}
@endsection

@section('navbar')
    @include('partials/fixedNav')
@endsection

@section('content')
    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-7 col-md-offset-1 col-sm-8">
                <div class="content-background">

                    {{--Main image row--}}
                    <div class="embed-responsive embed-responsive-16by9">
                        <img class="embed-responsive-item full-width-constrain-proportions center-block" id="mainImage" src="{{Utils::get_image_url($currentVersion->image1)}}"/>
                    </div>

                    <div class="row" style="margin-top: 10px;"> {{--Thumbnail row--}}

                        @foreach($images as $image)
                        <div class="col-xs-3">
                            <div class="embed-responsive embed-responsive-16by9">
                                <img class="embed-responsive-item" src="{{Utils::get_image_url($image)}}" onclick="selectImage('{{Utils::get_image_url($image)}}')"/>
                            </div>
                        </div>
                        @endforeach

                    </div>


                    <div class="text-content-padding">


                        <div class="btn-favorite-container pull-right">

                            @if($isLiked)
                                <div class="btn btn-success"><span class="fui-heart"></span> {{$game->likes}} </div>
                            @else
                                <div class="btn btn-favorite"><span class="fui-heart"></span> {{$game->likes}} </div>
                                <div id="btn-favorite-background" class="btn btn-favorite btn-favorite-background"><span class="fui-heart"></span> {{$game->likes}} </div>
                            @endif
                        </div>



                        <div class="btn btn-default pull-right" style="background-color: #F1F1F1; color: #9D9797; margin-right: 10px;"> <span class="fui-eye"></span> {{$game->views}} </div>
                        <div class="label label-primary">{{strtoupper($game->genre)}}</div>

                        @if($currentVersion->beta)
                            <div class="label label-default">BETA</div>
                        @endif

                        <h3>{{$game->title}}</h3>

                        <span class="h4 small">DESCRIPTION</span>
                        <p>{{$game->description}}</p>

                        <span class="h4 small">UPCOMING FEATURES</span>
                        <p> {{$currentVersion->upcoming_features}}</p>

                        <div id="disqus_thread"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-4"> {{--Right sidebar--}}
                <div class="content-background">
                    <div class="embed-responsive embed-responsive-16by9">
                        <img class="embed-responsive-item"  src="{{Utils::get_image_url($game->thumbnail)}}"/>
                    </div>

                    <div class="text-content-padding">
                        <div class="btn-group btn-group-sm" style="margin-top: 10px;">
                            <button type="button" class="btn btn-default">VERSION {{$currentVersion->version}}</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                @foreach($versions as $version)
                                <li><a href="/game/{{$game->slug}}/{{$version->version}}">{{$version->version}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <br>
                        <span class="h4 small">POSTED</span>  {{$game->created_at->diffForHumans()}} <br>
                        <span class="h4 small">DEVELOPER</span> {{$game->developer}}
                        <span class="h4 small"></span>
                        <hr>
                        <h4 class="small">PLATFORMS</h4>

                        @foreach($platforms as $platform)
                            <i class="demo-icon {{$platform}}"></i>
                        @endforeach

                        <hr>
                        <h4 class="small">FOLLOW</h4>
                        @foreach($links as $linkIcon => $link)
                            <a href="{{$link}}" style="color: #5d5d5d;""><i class="demo-icon {{$linkIcon}}"></i></a>
                        @endforeach

                    </div>

                </div>
            </div>

        </div>
    </div>



@endsection

@section('scripts')
    <script>
        var mainImage = $('#mainImage');

        function selectImage(newImage) {
            mainImage.fadeTo( "fast", .8, function() {
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