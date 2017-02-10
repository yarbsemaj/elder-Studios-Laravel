<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Game;
use App\GameMember;
use App\Member;

class gameControler extends Controller
{
    function add($location,$player1ID,$player1Score,$player2ID,$player2Score){
        $game = new Game;
        $game->location=$location;
        $game->save();
        $gameID = $game->gameID;
        $this->addGameMember($gameID,$player1ID, $player1Score);
        $this->addGameMember($gameID,$player2ID, $player2Score);
    }

    function addGameMember($gameID, $memberID, $score){
        $gameMember = new GameMember;
        $gameMember->gameID = $gameID;
        $gameMember->memberID = $memberID;
        $gameMember->score=$score;
        $gameMember->save();
    }
    
    function random($number){
        for( $i = 0; $i < $number; $i++){
            $members = Member::inRandomOrder()->get();

            $player1ID = $members->get(0)["memberID"];
            $player2ID = $members->get(1)["memberID"];
            
            $locations = array("Wakefield","Huddersfield","Leeds","Manchester","Castleford");

            $rand_keys = array_rand($locations);
            $location = $locations[$rand_keys];
            $player1Score = rand(150,700);
            $player2Score = rand(150,700);

            $this->add($location,$player1ID,$player1Score,$player2ID,$player2Score);

        }
    }
}