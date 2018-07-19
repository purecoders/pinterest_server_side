<?php

namespace App\Http\Controllers;

use App\TestUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class APIRegisterController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:test_users',
            'name' => 'required',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        TestUser::create([
            'email' => $request->get('email'),
            'name' => $request->get('name'),
            'password' =>$request->get('password'),
            //'password' => bcrypt($request->get('password')),
            //'password' => Hash::make($request->get('password')),
        ]);
        $user = TestUser::first();
        $token = JWTAuth::fromUser($user);

        return Response::json(compact('token'));
    }
}
