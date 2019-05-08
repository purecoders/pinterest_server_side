<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

  use SoftDeletes;
  protected $fillable = ['user_id', 'description', 'image_url', 'image_url_low'];
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
