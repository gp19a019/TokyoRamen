<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Model
use App\user;
use App\post;
use App\store;
use App\favorite;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class DisplayController extends Controller
{
    public function storeinfo_(){
        return view('storeInfo'); 
    }

    // 店舗詳細
    public function storeInfo(int $id){
        $store = new store;
        $cols = $store->find($id);

        if(is_null($cols)){
            abort(404);
        }

        $storeName = $cols->storeName;
        $address = $cols->address;

        $posts = post::select('posts.id as id', 'points', 'image', 'review', 'posts.store_id', 'stores.storeName', 'stores.address', 'users.name', 'posts.created_at as created')
        ->join('stores', 'posts.store_id', 'stores.id')
        ->join('users', 'posts.user_id', 'users.id')
        ->where('stores.id', $id)
        ->get();

        foreach($posts as $post){
            $post_id = $post['id'];
            $image = $post['image'];
        }

        $favorites = Auth::user()->favorite()->get();
        $favorite_id = null;
        foreach($favorites as $favorite){
            $favorite_id = $favorite['post_id'];
        }

        $avg = post::where('store_id', $id)->avg('points');
        $count = post::where('store_id', $id)->count();
        return view('storeInfo',[
            'cols' => $cols,
            'storeName' => $storeName,
            'address' => $address,
            'posts' => $posts,
            'id' => $id,
            'avg' => $avg,
            'count' => $count,
            'post_id' => $post_id,
            'favorite_id' => $favorite_id,
            'image' => $image
        ]);
    }

    public function create(store $store)
    {
        //エラーハンドリング
        if(is_null($store)){
            abort(404);
        }

        $storeName = $store->storeName;
        $points = [10,20,30,40,50,55,60,65,70,75,80,85,90,95,100];

        return view('postForm', [
            'storeName' => $storeName ,
            'points' => $points
        ]);
    }




    //マイページ
    public function myPage(){
        $myposts = Auth::user()
        ->post()
        ->select('posts.id as id', 'points', 'image', 'review', 'posts.store_id', 'stores.storeName', 'stores.address', 'users.name', 'posts.created_at as created')
        ->join('stores', 'posts.store_id', 'stores.id')
        ->join('users', 'posts.user_id', 'users.id')
        ->get();
        

        $favs = auth::user()->favorite()->get();
        $favorites = [];
        $fav_id = null;
        if($favs->isEmpty() == false){
            foreach($favs as $fav){
                $fav_id = $fav->post_id;
            }
            $favorites = post::select('posts.id as id', 'points', 'image', 'review', 'posts.store_id', 'stores.storeName', 'stores.address', 'users.name', 'posts.created_at as created')
            ->join('stores', 'posts.store_id', 'stores.id')
            ->join('users', 'posts.user_id', 'users.id')
            ->join('favorites', 'posts.id', 'favorites.post_id')
            ->where('favorites.user_id', Auth::user()->id)
            ->get();
        }
        
        
        return view('myPage', [
            'myposts' => $myposts,
            'favorites' => $favorites,
        ]);
    }

    //店舗申請フォーム
    public function storeNameForm(){
        return view('storeNameForm');
    }



    // -----------------------管理者権限----------------------------
    //管理者ページトップ
    public function admin(){
        return view('admin');
    }

    //店舗申請一覧
    public function permit_store(){
        $store = null;
        $store = store::where('permission', 0)->get();
        $message = '店舗申請はありません。';
        if(!empty($store)){
            return view('storePermit',[
                'stores' => $store,
                'message' => $message
            ]);
        }
    }

    //店舗申請許可
    public function permit_ok(store $store){
        $store->permission = 1;
        $store->save();
       return redirect('/admin');
    }

    //店舗申請拒否
    public function permit_ng(store $store){
        $store->delete();
       return redirect('/admin');
    }

    //投稿一覧
    public function permit_post(){
        $posts = null;
        $posts = post::select('posts.id as id', 'points', 'image', 'review', 'posts.store_id', 'stores.storeName', 'stores.address', 'users.name', 'posts.created_at as created')
        ->join('stores', 'posts.store_id', 'stores.id')
        ->join('users', 'posts.user_id', 'users.id')
        ->get();
        $message = '店舗はありませんでした。';
        
        return view('postPermit', [
            'posts' => $posts,
            'message' => $message
        ]);
    }

    //投稿削除
    public function permit_destroy_post(int $id){
        Post::destroy('$id');

        return redirect('/admin');
    }


}
