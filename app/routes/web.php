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

Route::group(['middleware' => 'auth'], function(){
  Route::get('/',[ResourceController::class, 'home'])->name('home'); //トップページ
  Route::post('/search',[RegistrationController::class, 'search'])->name('search');
  Route::get('/postDetail',[DisplayController::class, 'postDetail']); //投稿詳細
  Route::get('/storeInfo',[DisplayController::class, 'storeinfo_'])->name('storeinfo_');
  Route::get('/storeInfo/{id}',[RegistrationController::class, 'storeInfo'])->name('storeInfo'); //店名情報
  Route::post('/storeInfo',[RegistrationController::class, 'store_search']);
  Route::get('/storeNameForm',[DisplayController::class, 'storeNameForm'])->name('storeNameForm');
  Route::post('/storeNameForm',[RegistrationController::class, 'createStore']); //店舗登録フォーム
  Route::get('/myPage',[RegistrationController::class, 'myPage'])->name('mypage'); //マイページ
  Route::get('/postForm/{id}',[RegistrationController::class, 'postForm'])->name('postForm');//投稿フォーム
  Route::post('/postForm/{id}',[RegistrationController::class, 'createPost']);
  Route::get('/editPostForm/{post}',[DisplayController::class, 'editPostForm'])->name('editPostForm');//編集フォーム
  Route::post('/editPostForm/{post}',[RegistrationController::class, 'editPost']);
  Route::get('/deletePost/{post}',[RegistrationController::class, 'deletePost'])->name('deletePost');
  Route::get('/favorite/{post}',[RegistrationController::class, 'favorite'])->name('favorite');
  Route::get('/outFavorite/{post}',[RegistrationController::class, 'outFavorite'])->name('outFavorite');
  Route::get('result', [RegistrationController::class, 'location'])->name('result.currentLocation'); //GoogleMap API
});



/* 
・GoogleMapAPI
・マイページ投稿表示（ブックマーク）
・その他
*/

