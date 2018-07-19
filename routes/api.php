<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//app api


//user
Route::post('/v1/sign-up','UserController@signUpUser');
Route::post('/v1/login-with-user-name','UserController@loginUserWithUserName');
Route::post('/v1/login-with-token','UserController@loginUserWithToken');

//tag
Route::get('/v1/get-all-tags','TagController@getAllTags');


//post
Route::get('/v1/get-all-posts','PostController@getAllPosts');
Route::post('/v1/get-special-post-with-id','PostController@getSpecialPostWithId');
Route::post('/v1/get-search-result','PostController@getSearchResult');
Route::post('/v1/get-related-posts','PostController@getRelatedPosts');


//saved_post
Route::post('/v1/get-saved-posts','SavedPostController@getSavedPost');
Route::post('/v1/remove-from-saved-posts','SavedPostController@removeFromSavedPosts');
Route::post('/v1/add-to-saved-posts','SavedPostController@addToSavedPosts');

Route::post('user/register', 'APIRegisterController@register');
Route::post('user/login', 'APILoginController@login');
