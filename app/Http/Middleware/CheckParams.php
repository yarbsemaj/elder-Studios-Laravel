<?php

namespace App\Http\Middleware;

use Closure;

class CheckParams
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
    public function handle($request, Closure $next, ...$params)
    {
        foreach ($params as $param){
            if(!$request->has($param))
            {
                return response()->json(array("success"=>false));
            }
        }
        return $next($request);
    }
}