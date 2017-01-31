<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

class members extends Controller
{
    function get(Request $request){
        $success=true;
        if(!$request->has('memberID')){
            $success = false;
            $reultrs = array("success"=>$success);
        }
        if($success){
            $memberID = $request->input('memberID');
            $membershipData=DB::select("SELECT *  FROM member WHERE memberID = '$memberID'");
            if(count($membershipData)==0){
                $success = false;
                $reultrs = array("success"=>$success);
            }
        }
        if($success){
            $membershipData= $membershipData[0];
            
            @$wins=DB::select("SELECT COUNT(*) AS wins FROM (
            SELECT m.memberID, gp.gameID, gp.score FROM member AS m
            JOIN gamePlayers AS gp ON gp.memberID = m.memberID
            WHERE m.memberID='$memberID'
            ) AS you
            JOIN gamePlayers AS op ON op.memberID != you.memberID AND op.gameID = you.gameID
            WHERE you.score > op.score")[0];
            @$wins=$wins->wins;
            
            @$loss=DB::select("SELECT COUNT(*) AS loss FROM (
            SELECT m.memberID, gp.gameID, gp.score FROM member AS m
            JOIN gamePlayers AS gp ON gp.memberID = m.memberID
            WHERE m.memberID='$memberID'
            ) AS you
            JOIN gamePlayers AS op ON op.memberID != you.memberID AND op.gameID = you.gameID
            WHERE you.score < op.score")[0];
            @$loss=$loss->loss;
            
            @$avg=DB::select("SELECT AVG(score) as avgScore, COUNT(gp.memberID) AS gamesPlayed FROM member AS m
            LEFT JOIN gamePlayers AS gp ON gp.memberID = m.memberID
            WHERE m.memberID='$memberID'
            GROUP BY m.memberID")[0];
            @$gamesPlayed=$avg->gamesPlayed;
            @$avg=$avg->avgScore;
            
            @$bestGame=DB::select("SELECT bg.gameID, bg.score AS playerScore, op.name AS opName,gp.score AS opScore, g.location, g.time FROM (
            SELECT MAX(gp.score) as score, gp.gameID, m.memberID FROM member AS m
            JOIN gamePlayers AS gp ON gp.memberID = m.memberID
            WHERE m.memberID='$memberID'
            GROUP BY m.memberID
            ) AS bg
            JOIN gamePlayers AS gp ON bg.gameID = gp.gameID AND bg.memberID != gp.memberID
            JOIN member AS op ON gp.memberID = op.memberID
            JOIN game AS g on g.gameID = gp.gameID")[0];
            
            $reultrs = array("success"=>$success,"memberData"=>$membershipData,"gamesPlayed"=>$gamesPlayed, "wins"=>$wins, "loss"=>$loss, "avg"=>$avg, "bestGame"=> $bestGame);
        }
        return response()->json($reultrs);
    }
    
    function add(Request $request){
        if($request->has("name") && $request->has("adress1") && $request->has("adress2") && $request->has("postCode")){
            $id=DB::table("member")->insertGetId(
            ['name'=> $request->input('name'),
            'adress1'=> $request->input('adress1'),
            'adress2'=> $request->input('adress2'),
            'postCode'=> $request->input('postCode'),
            'joinDate'=>time()]
            );
            return response()->json(array("success"=>true, "memberID" => $id));
        }else{
            return response()->json(array("success"=>false));
        }
    }
    
    function edit(Request $request){
        if($request->has("name") && $request->has("adress1") && $request->has("adress2") && $request->has("postCode")&&$request->has("memberID")){
            $id=DB::table("member")->where(
            'memberID',$request->input('memberID')
            )
            ->update(
            ['name'=> $request->input('name'),
            'adress1'=> $request->input('adress1'),
            'adress2'=> $request->input('adress2'),
            'postCode'=> $request->input('postCode')
            ]);
            
            return response()->json(array("success"=>true, "memberID" => $request->input('memberID')));
        }else{
            return response()->json(array("success"=>false));
        }
    }
}