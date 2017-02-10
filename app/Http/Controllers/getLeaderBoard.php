<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Member;

class getLeaderBoard extends Controller
{
    public function getTop10 (){
        $members=Member::all();
        foreach($members as $member){
            $gameMember = $member->gameMember();
            $gamesPlayed = $gameMember->count();
            $avg = $gameMember->avg("score");
            $member->gamesPlayed=$gamesPlayed;
            $member->avgScore=$avg;
        }
        $return=$members->where("score","<=","10")->sortByDESC("avgScore")->take(10);
        return  array_values($return->toArray());
    }
}