Hey there!

Someone has roasted {{$game->title}}.
<br><br>
View it by clicking the link below. Be sure to pay it forward by roasting another game.
{{ secure_url('game/' . $game->slug . '?utm_source=comment&utm_medium=email&utm_campaign=game_roasted') }}


<br><br>
-{{Config::get('app.name')}}
<br>
{{ secure_url('/') }}