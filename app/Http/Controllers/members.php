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
        
        $yourScores = $membershipData->memberScores;
        $avg=$membershipData->avgScore;
        $gamesPlayed=$membershipData->gamesPlayed;

        $best=null;
        if($gamesPlayed!=0){
            $bestScore=$yourScores->sortbyDesc('score')->first();
            $opponentGame=$bestScore->opponentGame();
            $bestGame=$opponentGame->game();
            $bestMember=$opponentGame->member();

            $membershipData->wins=$membershipData->wins();
            $membershipData->loss=$membershipData->loss();
            
            $best=array("gameID"=>$bestScore->gameID,
            "playerScore"=> $bestScore->score,
            "opName"=>$bestMember->name,
            "opScore"=>$opponentGame->score,
            "location"=>$bestGame->location,
            "time"=>$bestGame->time);
        }
        
        return array("success"=>true,"memberData"=>$membershipData, "bestGame"=>  $best);
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