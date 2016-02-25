Hey there!


Your game is now live and ready for roasting! You can visit your game page here:
{{ secure_url('game/' . $game->slug . '?utm_source=comment&utm_medium=email&utm_campaign=game_roasted') }}
<br>
The best way to get roasts for your game is to start roasting other games.
{{ secure_url('/games' . '?utm_source=comment&utm_medium=email&utm_campaign=game_roasted') }}


<br><br>
-{{Config::get('app.name')}}
<br>
{{ secure_url('/') }}