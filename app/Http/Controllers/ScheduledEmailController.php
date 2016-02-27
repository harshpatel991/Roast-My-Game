<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use App\User;
use App\Game;
use App\Version;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ScheduledEmailController extends Controller
{

    public function getScreenshotSaturdayEmails() {
        //find all games that have versions not created in 1 week

        $allGames = Game::all();
        $games = array();
        foreach($allGames as $game) {
            $lastVersionForGame = Version::where('game_id', $game->id)->orderBy('created_at', 'desc')->take(1)->first();

            if($lastVersionForGame->created_at <= Carbon::now()->subWeek()) {
                array_push($games, $game);
            }
        }

        return view('dashboard.emails', compact(['games']));
    }

    public function postScreenshotSaturdayEmails() {

        $allGames = Game::all();
        foreach($allGames as $game) {
            $lastVersionForGame = Version::where('game_id', $game->id)->orderBy('created_at', 'desc')->take(1)->first();

            if($lastVersionForGame->created_at <= Carbon::now()->subWeek()) {
                echo "sending for: ". $game->title . "<br>";
                $user = User::where('id', $game->user->id)->first();

                $shouldSend = $user->mail_progress_reminders == '1';

                if ($shouldSend) {
                    $emailAddress = $user->email;
                    echo "sending to: " . $emailAddress . "<br>";
                    Mail::queue(['emails.screenshot-saturday', 'emails.screenshot-saturday-plain-text'], ['game' => $game, 'logoPath' => 'https://roastmygame.com/images/logo-dark.png'], function ($message) use ($emailAddress) {
                        $message->to($emailAddress)
                        ->bcc('support@roastmygame.com', 'Support')
                            ->subject('Happy Screenshot Saturday!');
                    });

                    echo "finished sending <br>";
                }
                else {
                    echo "did not send <br>";
                }

            }
        }







    }
}
