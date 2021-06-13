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

Route::get('/', function () {
    return view('welcome');
});

//route::get('/users','UsersController@getIndex');

Auth::routes();

/*
// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');
*/

Route::post('/tweet','UserPageController@userTweet')->name('tweet');
Route::post('/deletetweet','UserPageController@deleteTweet')->name('deletetweet');
Route::post('/favtweet','UserPageController@tweetFav')->name('favtweet');
Route::post('/favtweetdelete','UserPageController@tweetFavReset')->name('favdeltweet');
Route::get('/changeprofile','ChangeProfileController@getIndex')->name('changeprofile');
Route::post('/changeprofile','ChangeProfileController@changeProfile');
Route::post('/deleteuser','ChangeProfileController@deleteUser')->name('deleteuser');
Route::get('/home','HomeController@getIndex')->name('home');
Route::get('/{id}', 'UserPageController@getIndex')->name('userpage');
