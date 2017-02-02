<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class getLeaderBoard extends Controller
{
    public function getTop10 (){
        $top10=DB::select("SELECT m.name , m.memberID , COUNT(*) AS gamesPlayed , ROUND(AVG (gp.score),0) AS avgScore FROM gamePlayers AS gp
        JOIN member AS m ON gp.memberID = m.memberID
        GROUP BY memberID HAVING gamesPlayed >= 10 ORDER BY avgScore DESC LIMIT 10");
        
        return response()->json($top10);
    }
}