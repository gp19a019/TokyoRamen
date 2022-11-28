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

Route::group(['middleware' => 'auth'], function(){
  Route::get('/',[ResourceController::class, 'home'])->name('home'); //トップページ
  Route::post('/search',[RegistrationController::class, 'search'])->name('search'); //投稿検索
  Route::get('/storeInfo',[DisplayController::class, 'storeinfo_'])->name('storeinfo_'); //店名検索画面
  Route::get('/storeInfo/{id}',[RegistrationController::class, 'storeInfo'])->name('storeInfo'); //店名情報
  Route::post('/storeInfo',[RegistrationController::class, 'store_search']);//店名検索
  Route::get('/storeNameForm',[DisplayController::class, 'storeNameForm'])->name('storeNameForm');//店舗登録フォーム画面
  Route::post('/storeNameForm',[RegistrationController::class, 'createStore']); //店舗登録フォーム
  Route::get('/myPage',[RegistrationController::class, 'myPage'])->name('mypage'); //マイページ
  Route::get('/postForm/{id}',[RegistrationController::class, 'postForm'])->name('postForm'); //投稿フォーム画面
  Route::post('/postForm/{id}',[RegistrationController::class, 'createPost']); //投稿フォーム
  Route::get('/favorite/{post}',[RegistrationController::class, 'favorite'])->name('favorite'); //ブックマーク機能
  Route::get('/outFavorite/{post}',[RegistrationController::class, 'outFavorite'])->name('outFavorite'); //ブックマーク解除

  //ポリシークラス
  Route::group(['middleware' => 'can:view,post'], function(){
    Route::get('/editPostForm/{post}',[DisplayController::class, 'editPostForm'])->name('editPostForm'); //投稿編集
    Route::post('/editPostForm/{post}',[RegistrationController::class, 'editPost']); //編集フォーム
    Route::get('/deletePost/{post}',[RegistrationController::class, 'deletePost'])->name('deletePost'); //投稿削除
  });
  
});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
