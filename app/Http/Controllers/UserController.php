<?php

namespace App\Http\Controllers;

use App\Mail\newPasswordMail;
use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Input;

class UserController extends Controller
{

    private $salt1 = "e9442f0a5d95dec266d792d57d6224a";
    private $salt2 = "7cf826aac3823474203d9e8e83dd24d";

    private $client_salt = "7c3d596ed03ab9116c547b0eb678b247";


    public function signUpUser(Request $request)
    {
        $email = $request->email;
        $user_name = $request->user_name;
        $password = $request->password;
        $password = Hash::make($password);
        $client_key = $request->client_key;
        $rand = $this->generateRandomString(4);
        $token_key = $rand . md5($user_name) ;
        $token = Crypt::encryptString($token_key);

        $user1 = User::where('email', '=', $email)->first();
        $user2 = User::where('user_name', '=', $user_name)->first();



        if ($user1 === null && $user2 === null) {
            $user = new User();
            $user->email = $email;
            $user->user_name = $user_name;
            $user->password = $password;
            $user->app_token = $token_key;
            $user->client_key = $client_key;

            $user->save();

            $result = ["success" => 1, "token" => $token];
            $result = json_encode($result);
            echo $result;


        } else {

            $result = ["success" => 0, "token" => ""];
            $result = json_encode($result);
            echo $result;

        }


    }


    public function loginUserWithUserName(Request $request)
    {
        $user_name = $request->user_name;
        $password = $request->password;
        $rand = $this->generateRandomString(4);
        $token_key = $rand . $user_name . $this->salt1;
        $token = Crypt::encryptString($token_key);

        $user = User::where('user_name', '=', $user_name)->first();

        if ($user === null) {

            $result = ["success" => 0, "token" => ""];
            $result = json_encode($result);
            echo $result;

        } else {

            if (Hash::check($password, $user->password)) {
                $user->app_token = $token_key;
                $user->save();
                $result = ["success" => 1, "token" => $token];
            } else {
                $result = ["success" => 0, "token" => ""];
            }

            $result = json_encode($result);
            echo $result;

        }

    }


    public function loginUserWithToken(Request $request)
    {
        $userName = $request->user_name;
        $token = $request->token;
        $client_key = $request->client_key;
        $token_key = Crypt::decryptString($token);
        $user = User::where('app_token', '=', $token_key)->first();

        if ($user === null) {

            $result = ["success" => 0];
            $result = json_encode($result);
            echo $result;

        } else {

            if ($user->user_name == $userName) {

                $user->client_key = $client_key;
                $user->save();

                $result = ["success" => 1];

            } else {

                $result = ["success" => 0];

            }

            $result = json_encode($result);
            echo $result;

        }

    }


    public function changePassword(Request $request)
    {
        $user_name = $request->user_name;
        $old_password = $request->old_password;
        $new_password = $request->new_password;

        $user = User::where('user_name', '=', $user_name)->first();

        if ($user === null) {

            $result = ["success" => 0, "token" => ""];
            $result = json_encode($result);
            echo $result;

        } else {

            if (Hash::check($old_password, $user->password) ) {
              $rand = $this->generateRandomString(4);
              $token_key = $rand . $user_name . $this->salt1;
              $token = Crypt::encryptString($token_key);
              $new_password = Hash::make($new_password);
              $user->app_token = $token_key;
              $user->password = $new_password;
              $user->save();
              $result = ["success" => 1, "token" => $token];
            } else {
                $result = ["success" => 0, "token" => ""];
            }

            $result = json_encode($result);
            echo $result;

        }


    }


    public function recoveryPassword(Request $request)
    {
        $email = $request->email;

        $user = User::where('email', '=', $email)->first();

        if ($user === null) {

            $result = ["success" => 0];
            $result = json_encode($result);
            echo $result;

        } else {
            $user_name = $user->user_name;

            $new_password_plain = $this->generateRandomString();
            $user->password = Hash::make($new_password_plain);
            $user->save();


            //send $new_password_plain to $email !!
            //$email
            Mail::to($email)->send(new newPasswordMail($new_password_plain));

            $result = ["success" => 1];
            $result = json_encode($result);
            echo $result;


        }


    }


    private function generateRandomString($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }







}
