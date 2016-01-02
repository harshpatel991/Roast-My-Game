Hey there!

Thanks so much for joining {{Config::get('app.name')}}. Confirm your email by clicking the link below.
{{ URL::to('verify/' . $confirmationCode) }}

<br><br>
-{{Config::get('app.name')}}
<br>
{{ URL::to('/') }}