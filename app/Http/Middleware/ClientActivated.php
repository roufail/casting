<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClientActivated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!auth("client-api")->check()){
            return response()->json(['error' => 'Unauthorized.'], 401);
        }elseif(!auth("client-api")->user()->active){
            return response()->json(['error' => 'account not activated.'], 422);
        }
        return $next($request);
    }
}
