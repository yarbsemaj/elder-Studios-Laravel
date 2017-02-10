<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use App\Member;
use App\Game;
use App\GameMember;

class members extends Controller
{
    function get(Request $request){
        
        $memberID = $request->memberID;
        $membershipData=Member::find($memberID);
        
        $wins=0;
        $loss=0;
        
        $gameMembers= GameMember::all();
        $games = Game::all();
        
        $yourScores = $gameMembers->where("memberID",$memberID);
        foreach ($yourScores as $yourScore){
            $yourGameScore=$yourScore["score"];
            $theirGameScore=$yourScore->opponentGame()["score"];
            if($yourGameScore>$theirGameScore)$wins++;
            if($yourGameScore<$theirGameScore)$loss++;
        }
        $avg=$yourScores->avg('score');
        $gamesPlayed=$yourScores->count();
        $best=null;
        if($gamesPlayed!=0){
            $bestScore=$yourScores->sortbyDesc('score')->first();
            $opponentGame=$bestScore->opponentGame();
            $bestGame=$opponentGame->game();
            $bestMember=$opponentGame->member();
            
            $best=array("gameID"=>$bestScore->gameID,
            "playerScore"=> $bestScore->score,
            "opName"=>$bestMember->name,
            "opScore"=>$opponentGame->score,
            "location"=>$bestGame->location,
            "time"=>$bestGame->time);
        }
        
        
        return array("success"=>true,"memberData"=>$membershipData,"gamesPlayed"=>$gamesPlayed, "wins"=>$wins, "loss"=>$loss, "avg"=>$avg, "bestGame"=>  $best);
        
        
    }
    
    function add(Request $request){
        $member=new Member;
        
        $member->name = $request->name;
        $member->adress1 = $request->adress1;
        $member->adress2 = $request->adress2;
        $member->postCode = $request->postCode;
        
        $member->save();
        
        return array("success"=>true,"memberID" => $member->memberID);
    }
    
    function edit(Request $request){
        $member = Member::find($request->memberID);
        $member->name = $request->name;
        $member->adress1 = $request->adress1;
        $member->adress2 = $request->adress2;
        $member->postCode = $request->postCode;
        
        $member->save();
        
        return array("success"=>true, "memberID" => $request->memberID);
    }
}