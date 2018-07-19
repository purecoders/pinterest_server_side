<?php

namespace App\Http\Controllers;

use App\Mail\newPasswordMail;
use App\User;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Input;

class UserController extends Controller
{

    private $salt1 = "e9442f0a5d95dec266d792d57d6224a";
    private $salt2 = "7cf826aac3823474203d9e8e83dd24d";

    private $client_salt = "7c3d596ed03ab9116c547b0eb678b247";


    public function signUpUser()
    {

        $json = file_get_contents('php://input');
        $userInfo = json_decode($json);

        $email = $userInfo->email;
        $user_name = $userInfo->user_name;
        $password = $userInfo->password;
        $password = md5($this->salt1 . $user_name . $password . $this->salt2);
        $client_key = $userInfo->client_key;
        $token = md5($user_name . $password . $this->salt1);

        $user1 = User::where('email', '=', $email)->first();
        $user2 = User::where('user_name', '=', $user_name)->first();

        if ($user1 === null && $user2 === null) {

            $user = new User();
            $user->email = $email;
            $user->user_name = $user_name;
            $user->app_password = $password;
            $user->app_token = $token;
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


    public function loginUserWithUserName()
    {
        $json = file_get_contents('php://input');
        $userInfo = json_decode($json);

        $user_name = $userInfo->user_name;
        $password = $userInfo->password;
        $password = md5($this->salt1 . $user_name . $password . $this->salt2);
        $token = md5($user_name . $password . $this->salt1);

        $user = User::where('user_name', '=', $user_name)->first();

        if ($user === null) {

            $result = ["success" => 0, "token" => ""];
            $result = json_encode($result);
            echo $result;

        } else {

            if ($user->app_password == $password) {
                $user->app_token = $token;
                $user->save();
                $result = ["success" => 1, "token" => $token];
            } else {
                $result = ["success" => 0, "token" => ""];
            }

            $result = json_encode($result);
            echo $result;

        }

    }


    public function loginUserWithToken()
    {
        $json = file_get_contents('php://input');
        $userInfo = json_decode($json);

        $userName = $userInfo->user_name;
        $token = $userInfo->token;
        $client_key = $userInfo->client_key;
        $user = User::where('app_token', '=', $token)->first();

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


    public function changePassword()
    {
        $json = file_get_contents('php://input');
        $userInfo = json_decode($json);

        $user_name = $userInfo->user_name;
        $old_password = $userInfo->old_password;
        $old_password = md5($this->salt1 . $user_name . $old_password . $this->salt2);
        $new_password = $userInfo->new_password;

        $user = User::where('user_name', '=', $user_name)->first();

        if ($user === null) {

            $result = ["success" => 0, "token" => ""];
            $result = json_encode($result);
            echo $result;

        } else {

            if ($user->app_password == $old_password) {
                $token = md5($user_name . $new_password . $this->salt1);
                $new_password = md5($this->salt1 . $user_name . $new_password . $this->salt2);

                $user->app_token = $token;
                $user->app_password = $new_password;
                $user->save();

                $result = ["success" => 1, "token" => $token];
            } else {
                $result = ["success" => 0, "token" => ""];
            }

            $result = json_encode($result);
            echo $result;

        }


    }


    public function recoveryPassword()
    {
        $json = file_get_contents('php://input');
        $userInfo = json_decode($json);

        $email = $userInfo->email;

        $user = User::where('email', '=', $email)->first();

        if ($user === null) {

            $result = ["success" => 0];
            $result = json_encode($result);
            echo $result;

        } else {
            $user_name = $user->user_name;

            $new_password_plain = $this->generateRandomString();
            $new_password_client_hash = md5(md5($new_password_plain) . $this->client_salt);
            $new_password_server_hash = md5($this->salt1 . $user_name . $new_password_client_hash . $this->salt2);

            $user->app_password = $new_password_server_hash;
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
