<?php

namespace App\Http\Controllers;

use App\PostInformations;
use App\User;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\SavedPost;
use Illuminate\Support\Facades\Crypt;

class SavedPostController extends Controller
{

  public function getSavedPost(Request $request){
    $token = $request->token;
    $token = Crypt::decryptString($token);
    $clientKey = $request->client_key;
    $user = User::where('app_token', '=', $token)->first();


    if($user === null){
      $result = ["success"=>0,"posts"=>""];
    }else{
      $savedPosts = $user->savedPost;

      $completePosts = array();
      $posts = array();
      foreach ($savedPosts as $savedPost){
        $posts[] =  Post::find($savedPost->post_id);
//        $completePosts[] = $post . $post->tags . $post->information;
      }

      $compeltePost =array();
      foreach ($posts as $post){
        $compeltePost[] = $post . $post->tags . $post->information;
      }

      $result = ["success"=>1,"posts"=>$posts];
    }

    $result = json_encode($result);
    echo $result;



  }


  public function removeFromSavedPosts(Request $request){
    $token = $request->token;
    $token = Crypt::decryptString($token);
    $clientKey = $request->client_key;
    $post_id = $request->post_id;

    $user = User::where('app_token', '=', $token)->first();



    $savedPosts = $user->savedPost;

    foreach ($savedPosts as $savedPost){
      if($savedPost->post_id == $post_id){


        $postInfo = PostInformations:: where('post_id', '=', $post_id)->first();
        $postInfo->saved_count = $postInfo->saved_count - 1;
        $postInfo->save();

        $savedPost->delete();
        $result = ["success"=>1];
        echo json_encode($result);
        exit();
      }
    }

    $result = ["success"=>0];
    echo json_encode($result);
  }


  public function addToSavedPosts(Request $request){
    $token = $request->token;
    $token = Crypt::decryptString($token);
    $clientKey = $request->client_key;
    $post_id = $request->post_id;

    $user = User::where('app_token', '=', $token)->first();
    $post = Post::find($post_id);

    if($post === null){
      $result = ["success"=>0];
      echo json_encode($result);
      exit();
    }

    $savedPost = SavedPost::where('user_id', '=', $user->id)->where('post_id', '=', $post_id)->first();

    if($savedPost === null){
      $savedPost = new SavedPost();
      $savedPost->user_id = $user->id;
      $savedPost->post_id = $post->id;
      $savedPost->save();

      $postInfo = PostInformations:: where('post_id', '=', $post_id)->first();
      $postInfo->saved_count = $postInfo->saved_count + 1;
      $postInfo->save();


      $result = ["success"=>1];
      echo json_encode($result);

    }else{

      $result = ["success"=>0];
      echo json_encode($result);
    }





  }
}
