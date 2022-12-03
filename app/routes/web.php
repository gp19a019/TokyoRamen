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

use App\Http\Controllers\DisplayController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ResourceController;

Auth::routes();

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset/{token}', 'Auth\ResetPasswordController@reset');

//middleware
Route::group(['middleware' => 'auth'], function(){
  //一般ユーザ
  Route::group(['middleware' => 'can:general'], function(){
    Route::get('/create/{store}',[DisplayController::class, 'create'])->name('create'); //投稿
    Route::post('/search',[RegistrationController::class, 'search'])->name('search'); //投稿検索
    Route::get('/storeInfo',[DisplayController::class, 'storeinfo_'])->name('storeinfo_'); //店名検索画面
    Route::get('/storeInfo/{id}',[DisplayController::class, 'storeInfo'])->name('storeInfo'); //店名情報
    Route::post('/storeInfo',[RegistrationController::class, 'store_search']);//店名検索
    Route::get('/storeNameForm',[DisplayController::class, 'storeNameForm'])->name('storeNameForm');//店舗登録フォーム画面
    Route::post('/storeNameForm',[RegistrationController::class, 'createStore']); //店舗登録フォーム
    Route::get('/myPage',[DisplayController::class, 'myPage'])->name('mypage'); //マイページ
    Route::get('/favorite/{post}',[RegistrationController::class, 'favorite'])->name('favorite'); //ブックマーク機能
    Route::get('/outFavorite/{post}',[RegistrationController::class, 'outFavorite'])->name('outFavorite'); //ブックマーク解除
    
    //ResourceController
    Route::resource('posts','PostController')->except(['create','show']);
    Route::put('/posts/{post}', 'PostController@update');
  });

  //管理者権限
  Route::group(['middleware' => 'can:admin'], function(){
    Route::get('/admin', [DisplayController::class, 'admin'])->name('admin');
    Route::get('/permit_store', [DisplayController::class, 'permit_store'])->name('permit_store');
    Route::get('/permit_ok/{store}', [DisplayController::class, 'permit_ok'])->name('permit_ok');
    Route::get('/permit_ng/{store}', [DisplayController::class, 'permit_ng'])->name('permit_ng');
    Route::get('/permit_post', [DisplayController::class, 'permit_post'])->name('permit_post');
    Route::get('/permit_destroy_post/{id}', [DisplayController::class, 'permit_destroy_post'])->name('permit_destroy_post');

  });
});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
