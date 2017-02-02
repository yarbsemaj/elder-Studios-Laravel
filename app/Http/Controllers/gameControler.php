<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class gameControler extends Controller
{
    function add($location,$player1ID,$player1Score,$player2ID,$player2Score){
        $gameID=DB::table("game")->insertGetId(
        ['location'=> $location,
        'time'=>time()]
        );
        
        $id=DB::table("gamePlayers")->insertGetId(
        ['memberID'=> $player1ID,
        'gameID'=>$gameID,
        'score'=>$player1Score]
        );
        
        $id=DB::table("gamePlayers")->insertGetId(
        ['memberID'=> $player2ID,
        'gameID'=>$gameID,
        'score'=>$player2Score]
        );
        return response("Game ID: ".$gameID."Created");
    }
    
    function random($number){
        for( $i = 0; $i < $number; $i++){
            $randMembers=DB::select("SELECT *
            FROM member
            ORDER BY RAND()
            LIMIT 2");
            $player1ID=$randMembers[0]->memberID;
            $player2ID=$randMembers[1]->memberID;
            
            $locations=array("Wakefield","Huddersfield","Leeds","Manchester","Castleford");

            $rand_keys = array_rand($locations);
            $location=$locations[$rand_keys];
            $player1Score=rand(150,700);
            $player2Score=rand(150,700);

            $this->add($location,$player1ID,$player1Score,$player2ID,$player2Score);

        }
    }
}