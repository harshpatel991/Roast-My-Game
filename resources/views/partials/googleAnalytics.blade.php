@if(!env('APP_DEBUG', false))
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-71872849-1', 'auto');
        ga('send', 'pageview');
        @if (Auth::check())ga('set', 'userId', '{{Auth::user()->id}}'); @endif

    </script>
@endif

<?php
    if(!env('APP_DEBUG', false)) {
        if (Request::session()->has('myga'))
            $my_ga = Request::session()->get('myga');
        else {
            $my_ga = uniqid();
            Request::session()->put('myga', $my_ga);
        }

        $gamp = GAMP::setClientId($my_ga)
            ->setDocumentPath(Request::path());

        if(isset($_SERVER['REMOTE_ADDR'])) {
            $gamp->setIpOverride($_SERVER['REMOTE_ADDR']);
        }

        if(isset($_SERVER["HTTP_REFERER"])){
            $gamp->setDocumentReferrer($_SERVER["HTTP_REFERER"]);
        }

        $gamp->sendPageview();
    }
?>