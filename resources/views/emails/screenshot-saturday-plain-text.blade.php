Happy Screenshot Saturday!

Hey there! We saw that {{$game->title}}'s page hasn't been updated in awhile. Why not show the community your progress this Screenshot Saturday. Updating your game also gets your game back on the homepage so you can get more exposure!
<br><br>
While you're there, roast a few games by other devs, the system only works if everyone is willing to share their feedback.

{{ secure_url('/add-version/'. $game->slug . '?utm_source=game&utm_medium=email&utm_campaign=screen_shot_saturday') }}

<br><br>
-{{Config::get('app.name')}}
<br>
{{ secure_url('/') }}