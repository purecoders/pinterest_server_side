<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Tag;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
  Route::resource('/tag', 'TagController');
  Route::resource('/user', 'UserAdminController');
  Route::post('/user-search', 'UserAdminController@search');
  Route::get('/user-delete/{id}', 'UserAdminController@userDelete');
  Route::get('/manageTag', 'TagController@index');
  Route::get('/tag-delete/{id}', 'TagController@tagDelete');
  Route::post('/tag-search', 'TagController@tagSearch');
  Route::get('/getTag/{search}', 'TagController@getRelatedTag');
  Route::get('/getUser/{search}', 'UserAdminController@getRelatedUser')->name('search-user');
});


//Auth::routes();
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index')->name('home');
