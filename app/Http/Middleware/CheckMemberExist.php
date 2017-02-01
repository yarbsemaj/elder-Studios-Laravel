<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class CheckMemberExist
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
    public function handle($request, Closure $next)
    {
        $memberID = $request->input('memberID');
        $membershipData=DB::select("SELECT *  FROM member WHERE memberID = '$memberID'");
        if(count($membershipData)==0)
        {
            return response()->json(array("success"=>false));
        }
        return $next($request);
    }
}