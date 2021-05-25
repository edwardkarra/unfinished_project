<?php

namespace App\Http\Middleware;
use Closure;
use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if($request->has('api_token')){
            $user = User::all()->where('api_token',$request['api_token'])->first;
            if($user['api_token']== $request['api_token']){
                return $next($request);
            }
        }

        if (! $request->expectsJson()) {
            dd("hellooo");
            return;
        }
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

    public function hanfdle($request,Closure $next,...$guards)
    {
        if($request->has('api_token')){
            $user = User::all()->where('api_token',$request['api_token'])->first;
            if($user['api_token']== $request['api_token']){
                return $next($request);
            }
        }

        if (! $request->expectsJson()) {
            dd("hellooo");
            return;
        }
    }
}
