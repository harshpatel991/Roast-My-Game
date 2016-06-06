<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDownloadsRequest;
use App\Http\Requests\StoreUploadFileRequest;
use App\Http\Utils;
use Log;

class DownloadController extends Controller
{
    public function getAddDownloads(Game $game, Request $request) {
        $oldDownloadValues = $this->createAddByJSOldDownloads($game);
        return view('addDownloadLinks', compact('game', 'oldDownloadValues'));
    }
    
    private function createAddByJSOldDownloads(Game $game) {
        $platformLinks = Utils::preg_grep_keys("/link_platform_.+/", $game->getAttributes()); //get currently saved game links

        $platformNamesByLinks = array(); //platformName => the value to show
        foreach($platformLinks as $platformColumnName => $platformLink) {
            $platformName = str_replace("link_", "", $platformColumnName);
            $primaryValue = old('link_input_' . $platformName);
            $secondaryValue = old('file_name_' . $platformName);
            $tertiaryValue = $platformLink; //the value from the db

            if ($primaryValue != '') {
                $platformNamesByLinks[$platformName] = $primaryValue;
            } else if ($secondaryValue != '') {
                $platformNamesByLinks[$platformName] = $secondaryValue;
            } else if ($tertiaryValue != null) {
                $platformNamesByLinks[$platformName] = $tertiaryValue;
            }
        }

        $returnString = '';
        foreach($platformNamesByLinks as $platformName => $platformLink) {
            if(strrpos($platformLink, secure_url('/'), -strlen($platformLink)) !== false) { //check if this starts with rmg.com -> it was uploaded
              $returnString .= "setFileInputValue('$platformName', '$platformLink');\n";
            } else {
                $returnString .= "setLinkInputValue('$platformName', '$platformLink');\n";
            }
        }

        return $returnString;
    }
    
    /**
     * Save a list of downloads
     */
    public function postAddDownloads(Game $game, StoreDownloadsRequest $request) {
        foreach(Game::$platforms as $platformName) {
            $game->fill(array('link_' . $platformName => $this::getPlatformLinkValue($request, $platformName)));
        }
        $game->save();

        return redirect('game/'.$game->slug)->with('message', 'Your game has been added! Roast other games to get feedback for your own.');
    }

    private static function getPlatformLinkValue(Request $request, $platform) {
        if($request->has('file_name_'.$platform)) {
            return $request->get('file_name_'.$platform);
        } else if($request->has('link_input_'.$platform)) {
            return $request->get('link_input_'.$platform);
        }
        return null;
    }

    public function getDownload(Game $game, $platform, $fileName, Request $request) {
        $downloadLink = Utils::get_download_url($game->slug, $platform);
        $relatedGames = Game::where('genre', $game->genre)
            ->where('slug', '<>', $game->slug)
            ->with(['versions' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->take(4)
            ->get();

        return view('download', compact('game', 'fileName', 'downloadLink', 'relatedGames'));
    }

    public function postUploadGameFile(Game $game, $platformName, StoreUploadFileRequest $request) {
        Log::info('Request to upload a game file: ' . print_R($request->all(), TRUE));

        $saveFileName = $game->slug . '-' . $platformName . '.zip';
        $s3containingFolder = $game->slug . '/game-files';

        return secure_url('download/' . $game->slug . '/' . $platformName . '/' . Utils::upload_game_file($request->file('file'), $saveFileName, $s3containingFolder));
    }
}
