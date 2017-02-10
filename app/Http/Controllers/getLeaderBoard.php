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
        }
        $return=$members->where("gamesPlayed",">=","10")->sortByDESC("avgScore")->take(10);
        return  array_values($return->toArray());
    }
}