Hey there!

Thanks so much for joining {{Config::get('app.name')}}. Confirm your email by clicking the link below.
{{ secure_url('verify/' . $confirmationCode) }}

<br><br>
-{{Config::get('app.name')}}
<br>
{{ secure_url('/') }}