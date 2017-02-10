<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use App\Member;

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
        $memberID = $request->memberID;
        $member = Member::find($request->memberID);
        if($member==null)
        {
            return array("success"=>false);
        }
        return $next($request);
    }
}