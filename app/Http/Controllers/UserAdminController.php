<?php

namespace App\Http\Controllers;

use App\PostInformations;
use App\SavedPost;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //
        $users = DB::table('users')->orderBy('created_at', 'desc')->where('deleted_at','=',null)->paginate(5);
        return View('users', ['users' => $users]);
    }
	//Block User With Soft Delete
    public function destroy($id){
        $user=User::findOrFail($id);
        $userId = $user->id;
        $posts = $user->posts;
        $user->delete();
        foreach ($posts as $post){
            $postInfo = PostInformations::where('post_id','=',$post->id)->first();
            $postInfo->delete();
            DB::delete("DELETE FROM saved_posts WHERE post_id = '$post->id'");
            DB::delete("DELETE FROM post_tag WHERE post_id = '$post->id'");
            $post->delete();
        }
        //DB::delete("DELETE FROM posts WHERE user_id = '$userId'");
        return redirect('/user');

    }
    //pouya updated
    public function getRelatedUser($search)
    {
        $users = DB::table('users')
            ->where('user_name', 'LIKE', "%{$search}%")->where('deleted_at','=',null)
            ->paginate(5);
        return View('users', ['users' => $users]);
    }



}
