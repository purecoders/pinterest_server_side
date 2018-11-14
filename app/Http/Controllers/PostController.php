<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostInformations;
use App\SavedPost;
use App\Tag;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

//use Intervention\Image\ImageServiceProvider;
//use Intervention\Image\Facades\Image as Image;

class PostController extends Controller
{
  public function getAllPosts(Request $request){
//    $json = file_get_contents('php://input');
//    $info = json_decode($json);

    $id = $request->id;
    $count = $request->count;

    if($id == 0){
      $lastPost = Post::orderBy('id','desc')->first();
      $id = $lastPost->id + 1;
    }


    $posts = Post::where('id', '<', $id)->take($count)->orderBy('id','desc')->get();

    //$before = $info->id;

    //$posts = Post::orderBy('id','asc')->get();
    $compeltePost =array();
    foreach ($posts as $post){
      $compeltePost[] = $post . $post->tags . $post->information;
      $lastId = $post->id;
    }
    $result=["success"=>1,"last_id"=>$lastId,"posts"=>$posts];
    echo json_encode($result);




//    $media =  Media::where('active', 1) // don't need the "="
//    ->where('id', '>', $after)
//      ->take(10)
//      ->get();
  }





  public function uploadPost(Request $request){
//    $json = file_get_contents('php://input');
//    $info = json_decode($json);

    $token = $request->token;
    $client_key = $request->client_key;
    $image = $request->image;
    $image_low = $request->image_low;
    $description = $request->description;
    $name = $request->name;
    $tags_id = $request->tags_id;

//    $name = $json["name"];
//    $image = $json["image"];


    $user = User::where('app_token', '=', $token)->first();
    if($user === null){
      $result = ["success"=>0];
      $result = json_encode($result);
      echo $result;
      exit();

    }else {



      if ($user->client_key == $client_key) {
        $user_id = $user->id;


        date_default_timezone_set('Asia/Tehran');
        $date = date('Y_m_d__h_i_s__a', time());

        $image_name = $date .'_'. $name .'_'.$this->generateRandomString(5);
        $decodedImage = base64_decode("$image");
        $decodedImageLow = base64_decode("$image_low");
        $save = file_put_contents("uploads/images/". $image_name .".JPG", $decodedImage);
        $save_low = file_put_contents("uploads/images/". $image_name .'_low'.".JPG", $decodedImageLow);

        if($save !== false){
          $image_url = env('APP_URL') . "/uploads/images/".$image_name.".JPG";
          //$image_url_low = Image::make($image_url)->resize(300,200)->save("uploads/images/". $image_name ."_low".".JPG");
          $image_url_low = env('APP_URL') . "/uploads/images/". $image_name ."_low".".JPG";

          $post = new Post();
          $post->user_id = $user_id;
          $post->description = $description;
          $post->image_url = $image_url;
          $post->image_url_low = $image_url_low;
          $post->save();

          $lastPostId =$post->id;


          $postInfo = new PostInformations();
          $postInfo->post_id = $lastPostId;
          $postInfo->saved_count = 0;
          $postInfo->shared_count = 0;
          $postInfo->save();

          foreach ($tags_id as $tag_id){
            DB::insert("INSERT INTO post_tag (post_id,tag_id) VALUES (?,?)", [$lastPostId, $tag_id]);
          }

          $result =["success"=>1];
          echo json_encode($result);
          exit();



        }else{
          $result =["success"=>0];
          echo json_encode($result);
        }



        ///...


      } else {

        $result = ["success" => 0];
        echo json_encode($result);
      }


    }














  }






  public function getSpecialPostWithId(Request $request){
//    $json = file_get_contents('php://input');
//    $Info = json_decode($json);

    $id = $request->id;
    $post = Post::where('id', '=', $id)->first();

    if($post === null){
      $result = ["success"=>0,"user_name"=>"","post"=>""];
    }else{
      $post->tags;
      $post->information;
      $user = User::find($post->user_id);

      $result = ["success"=>1,"user_name"=>$user->user_name,"post"=>$post];
    }

    $result = json_encode($result);
    echo $result;

  }



  public function getSearchResult(Request $request){
//    $json = file_get_contents('php://input');
//    $tagJson = json_decode($json);

    $tagText = $request->text;

    if(strlen($tagText) < 2){
      $result = ["success"=>0,"posts"=>""];
      $result = json_encode($result);
      echo $result;
      exit();
    }



    $tags = DB::select("SELECT * FROM tags WHERE name LIKE '%".$tagText."%' ");

    if($tags == null){
      $result = ["success"=>0,"posts"=>""];
    }else{
      $postsIndex = array();
      $i = 1;
      foreach ($tags as $tag){
        $posts= Tag::find($tag->id)->posts;
        foreach ($posts as $post) {
          if (!in_array($post->id, $postsIndex)){
            $postsIndex[] = $post->id;
            $i++;
          }
          if($i >= 100)break;
        }
        if($i >= 100)break;
      }

      $posts = array();
      foreach ($postsIndex as $index){
        $post = Post::find($index);
        $post->tags;
        $post->information;
        $posts[] = $post;
      }


      $result = ["success"=>1,"posts"=>$posts];
    }


    $result = json_encode($result);
    echo $result;
  }



  public function getRelatedPosts(Request $request){
//    $json = file_get_contents('php://input');
//    $Info = json_decode($json);

    $id = $request->id;
    $post = Post::where('id', '=', $id)->first();

    if($post === null){
      $result = ["success"=>1,"posts"=>""];
      echo json_encode($result);
      exit;
    }

    $tags = $post->tags;

    $postsIndex = array();
    $i=1;
    foreach ($tags as $tag) {
      $posts = Tag::find($tag->id)->posts;
      foreach ($posts as $post) {
        if (!in_array($post->id, $postsIndex)  &&  $post->id != $id) {
          $postsIndex[] = $post->id;
          $i++;
        }
        if ($i>=100)break;
      }
      if ($i>=100)break;
    }


    $posts = array();
    foreach ($postsIndex as $index){
      $post = Post::find($index);
      $post->tags;
      $post->information;
      $posts[] = $post;

    }

    $result = ["success"=>1,"posts"=>$posts];
    echo json_encode($result);





  }


  public function getUserPosts(Request $request){
//    $json = file_get_contents('php://input');
//    $userInfo = json_decode($json);

    $client_key = $request->client_key;
    $token = $request->token;

    $user = User::where('app_token', '=', $token)->first();


    if($user === null){

      $result = ["success"=>0,"posts"=>""];
      $result = json_encode($result);
      echo $result;

    }else{

      if($user->client_key == $client_key){
        $posts = $user->posts;

        foreach ($posts as $post){
          $post->tags;
          $post->information;
        }

        $result = ["success"=>1,"posts"=>$posts];

      }else{

        $result = ["success"=>0,"posts"=>""];

      }

      $result = json_encode($result);
      echo $result;

    }
  }


  public function addPostSharedCount(Request $request){
//    $json = file_get_contents('php://input');
//    $userInfo = json_decode($json);

    $token = $request->token;
    $client_key = $request->client_key;
    $post_id = $request->post_id;


    $user = User::where('app_token', '=', $token)->first();


    if($user === null){

      $result = ["success"=>0];
      $result = json_encode($result);
      echo $result;

    }else{
      if($user->client_key == $client_key){

        $postInfo = PostInformations:: where('post_id', '=', $post_id)->first();
        $postInfo->shared_count = $postInfo->shared_count + 1;
        $postInfo->save();
        $result = ["success"=>1];

      }else{

        $result = ["success"=>0];

      }

      $result = json_encode($result);
      echo $result;
    }

    }


  public function removeFromUserPosts(Request $request){
//      $json = file_get_contents('php://input');
//      $user_post_Info = json_decode($json);


      $token = $request->token;
      $clientKey = $request->client_key;
      $post_id = $request->post_id;

      $user = User::where('app_token', '=', $token)->first();

      if($user->client_key != $clientKey){
        $result = ["success"=>0];
        echo json_encode($result);
        exit();

      }else {

        $user_id = $user->id;
        $post = Post::where('id', '=', $post_id)->first();
        if($post === null){
          $result = ["success"=>0];
        }else if($post->user_id == $user_id) {
          $post->delete();
          $savedPosts = SavedPost::where('post_id', '=', $post_id)->get();
          foreach ($savedPosts as $savedPost){
            $savedPost->delete();
          }

          $postInfo = PostInformations::where('post_id', '=', $post_id)->first();
          $postInfo->delete();

          DB::delete("DELETE FROM post_tag WHERE post_id = '$post_id' ");




          $result = ["success"=>1];
        }else{
          $result = ["success"=>0];
        }

        echo json_encode($result);

      }
    }




  private function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

}
