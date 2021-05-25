<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Auth\TokenGuard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public static function register(Request $request){
        $params = $request->validate([
            'name' => 'required|max:15',
            'email' => 'required|max:30',
            'password' => 'required'
        ]);
        User::create([
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => bcrypt($params['password'])
        ]);
        return true;
    }

    public static function login(Request $request){
        $params = $request->validate([
            'email' => 'required|max:30',
            'password' => 'required'
        ]);

        $user = User::all()->where('email',$params['email'])->first();
        if($user->api_token) {
            return response([
                'message' => 'user already logged in',
                'api_token' => $user->api_token
            ]);
        }
        if(!$user){
            return response([
                'message'=>'user not found'
            ]);
        }
        elseif(!Hash::check($params['password'],$user->password)){
            return response([
                'message'=>'bad creds'
            ]);
        }
        else{
            $token = Str::random(60);
            $user->api_token = $token;
            $user->save();

            return response([
                'message'=>'user already logged in',
                'api_token' => $token
            ]);
        }
    }
    public static function logout(Request $request){
        $sent_token = $request->header('api_token');
        $user = findUserByToken($sent_token);
        $user->update(['api_token' => null]);
        return \response(['message' => 'logged out.']);
    }
    public function findUserByToken($token){
        $user = User::all()->where('api_token',$token)->first();
        return $user;
    }
}
