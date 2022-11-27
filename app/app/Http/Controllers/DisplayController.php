<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Model
use App\Post;
use App\User;
use App\Store;
use App\Favorite;

class DisplayController extends Controller
{
    //アクセス時
    public function index(){
        return view('toppage');
    }

    //投稿詳細
    public function postDetail(){
        return view('postDetail');
    }

    //店名情報
    public function storeinfo_(){
        return view('storeInfo');
    }

    //店舗登録フォーム
    public function storeNameForm(){
        return view('storeNameForm');
    }

    

    //投稿フォーム
    public function postForm(){
        return view('postForm');
    }
    
    //編集
    public function editPostForm(int $id){
        $post = new post;
        $store = new store;
        $edit = $post->find($id)->toArray();
        $store_id = $edit['store_id'];
        $edition = $store->find($store_id)->toArray();
        $points = [10,20,30,40,50,55,60,65,70,75,80,85,90,95,100];
    
        return view('editPostForm', [
            'edit' => $edit,
            'points' => $points,
            'edition' => $edition
        ]);
    }
}
