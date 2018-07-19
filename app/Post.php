<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
//  public function photo(){
//    return $this->hasOne('App\Photo');
//  }

  public function user(){
    return $this->belongsTo('App\User');
  }

  public function tags(){
    return $this->belongsToMany('App\Tag');
  }

  public function information(){
    return $this->hasOne('App\PostInformations');
  }
}
