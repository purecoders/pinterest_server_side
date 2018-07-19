<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Validator;
use JWTFactory;
use JWTAuth;
use App\TestUser;
use Illuminate\Support\Facades\Auth;

class APILoginController extends Controller
{
    //
    //protected $guard = 'test_users';
    public function login(Request $request)
    {
        Config::set('jwt.user', 'App\TestUser');
        Config::set('auth.providers.users.model', \App\TestUser::class);
        Config::set('auth.providers.users.table', 'test_users');



        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $credentials = $request->only('email', 'password');
//        $token = JWTAuth::attempt($credentials);
       // return response()->json(['error' => $credentials], 401);
        //$credentials['password'] = bcrypt($credentials['password']);
       // return response()->json(['$credentials' => $credentials], 401);
       // return response()->json(['error' => $credentials], 401);
         $token =JWTAuth::parseToken()->authenticate();
//         $token = JWTAuth::attempt($credentials);
        try {
            if ($token) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }
}
