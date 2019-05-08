<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_name', 'email', 'password', 'app_token', 'client_key'
    ];


    protected $hidden = [
        'password', 'remember_token', 'app_token', 'client_key'
    ];


    //copy salts
    private $salt1 = "e9442f0a5d95dec266d792d57d6224a";
    private $salt2 = "7cf826aac3823474203d9e8e83dd24d";


    public function posts(){
      return $this->hasMany('App\Post');
    }

    public function savedPost(){
      return $this->hasMany('App\SavedPost');
    }


}
