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


Route::get('gifts', 'GiftSearchController@index');


Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login');
Route::post('admin/logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
//$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//$this->post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index');


Route::group(['middleware' => 'auth', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'DashboardController@show');

    Route::get('articles', 'ArticlesController@index');
    Route::get('articles/{article}', 'ArticlesController@show');
    Route::get('articles/{article}/edit', 'ArticlesController@edit');
    Route::get('articles/{article}/body/edit', 'ArticleBodyController@edit');
    Route::patch('articles/{article}/body', 'ArticleBodyController@update');
    Route::post('articles', 'ArticlesController@store');
    Route::post('articles/{article}', 'ArticlesController@update');

    Route::post('articles/{article}/publish', 'ArticlePublishingController@update');

    Route::post('articles/{article}/images', 'ArticleImagesController@store');
});