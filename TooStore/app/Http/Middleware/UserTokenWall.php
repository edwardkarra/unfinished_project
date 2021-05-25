<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
class UserTokenWall
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
        //$response = $next($request);

        if($request->headers->has('api_token')){
            $sent_token = $request->headers->get('api_token');
            if(User::all()->pluck('api_token')->contains($sent_token)) {
                //$user = User::all()->where('api_token', $sent_token)->first;
                //$user_token = $user['api_token'];
                return $next($request);
            }
            else{
                return response([
                    'message' => 'bad token'
                ]);
            }
        }

        else{
            return response([
                'message' => 'provide token please'
            ]);
        }
    }
}
