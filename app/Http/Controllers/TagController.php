<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class TagController extends Controller
{


  public function getAllTags(){
    $tags = Tag::orderBy('id','desc')->get();
    $result = ["success"=>1,"tags"=>$tags];
    echo json_encode($result);
  }





  public function index()
  {
    //
    $tags = DB::table('tags')->orderBy('created_at', 'dsc')->paginate(5);
    return View('tags', ['tags' => $tags]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
    $tag = Tag::whereName(Input::get('name'))->first();
    if ($tag) {
      return redirect('/tag')->withErrors(['0']);
    } else {
      Tag::create($request->all());
      return redirect('/tag')->withErrors(['1']);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
    //echo url()->full();;

    $tag = Tag::findOrFail($id);
    $tag->update($request->all());
    return redirect('/tag');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
    $tag = Tag::findOrFail($id);
    $tag->delete();
    return redirect('/tag');
  }

  public function getRelatedTag($search)
  {
    $tags = DB::table('tags')
      ->where('name', 'LIKE', "%{$search}%")
      ->paginate(5);
    return View('tags', ['tags' => $tags]);
  }

}
