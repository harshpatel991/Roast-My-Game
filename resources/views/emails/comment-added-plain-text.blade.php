Hey there!

Someone has roasted {{$game->title}}.
<br><br>
View it by clicking the link below. Be sure to pay it forward by roasting another game.
{{ URL::to('game/' . $game->slug) }}


<br><br>
-{{Config::get('app.name')}}
<br>
{{ URL::to('/') }}