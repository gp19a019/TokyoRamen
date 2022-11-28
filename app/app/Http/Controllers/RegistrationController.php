<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CreatePost;

use App\Http\Requests\CreateStore;

use App\Http\Requests\Search;

use App\user;

use App\post;

use App\store;

use App\favorite;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{   
    // 店舗検索
    public function search(search $request){
        $keyword = $request->input('keyword');
        

        $posts = post::select('posts.id as id', 'points', 'image', 'review', 'posts.store_id', 'stores.storeName', 'stores.address', 'users.name', 'posts.created_at as created')
        ->join('stores', 'posts.store_id', 'stores.id')
        ->join('users', 'posts.user_id', 'users.id')
        ->where('storeName', 'LIKE', "%{$keyword}%")
        ->orWhere('address', 'LIKE', "%{$keyword}%")
        ->get();

        foreach($posts as $post){
            $id = $post->id;
        }
        $message = '店舗はありませんでした。';

        return view('toppage', [
            'posts' => $posts,
            'keyword' => $keyword,
            'id' => $id,
            'message' => $message
        ]);
    }


    // 店舗申請
    public function createStore(createStore $request){
        $store = new store;
        $columns = ['storeName', 'postCode', 'address'];

        foreach($columns as $column){
            $store->$column = $request->$column;
        }

        $store->save();
        return redirect('/');

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


    // 投稿フォーム（フォーム画面へ遷移）
    public function postForm(int $id){
        $store = new store;
        $cols = $store->find($id);

        //エラーハンドリング
        if(is_null($cols)){
            abort(404);
        }

        $storeName = $cols->storeName;
        $points = [10,20,30,40,50,55,60,65,70,75,80,85,90,95,100];

        return view('postForm', [
            'storeName' => $storeName ,
            'points' => $points
        ]);
    }


    // 投稿フォーム
    public function createPost(createPost $request){
        $name = $request->storeName;
        $id = store::where('storeName', $name)->first()->id;

        $post = new post;
        $columns = ['points', 'image', 'review'];
        foreach($columns as $column){
            $post->$column = $request->$column;
        }
        $post->store_id = $id;

        $file = $request->image;
        $request->file('image')->storeAs('public/img', $file);
        Auth::user()->post()->save($post);

        return redirect('/');
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


    // ブックマーク登録
    public function favorite(post $post){
        //エラーハンドリング
        if(is_null($post)){
            abort(404);
        }

        //該当投稿のID取得
        $favorite = new favorite;
        
        //favoritesテーブルの投稿IDから最初のレコードを挿入
        $favorite->post_id = $post->id;
        Auth::user()->favorite()->save($favorite);

        //マイページへリダイレクト
        return redirect('/myPage');
    }


    // ブックマーク解除
    public function outFavorite(post $post){
        //エラーハンドリング
        if(is_null($post)){
            abort(404);
        }

        //該当投稿のID取得
        $id = $post['id'];

        //favoritesテーブルの投稿IDから最初のレコードを削除
        $favorite = favorite::where('post_id', $id)->first();
        Auth::user()->favorite()->delete($favorite);
        
        //マイページへリダイレクト
        return redirect('/myPage');
    }



    // 店舗検索
    public function store_search(search $request){
        //入力値を取得
        $keyword = $request->keyword;

        //該当の店舗があるか
        $stores = store::select('id', 'storeName', 'address')
        ->where('storeName', 'LIKE', "%{$keyword}%")
        ->orWhere('address', 'LIKE', "%{$keyword}%")
        ->get(); 

        //それぞれの変数にnullをセット
        $id = null;
        $storeName = null;
        $address = null;

        //入力値から取得したデータをそれぞれ代入
        foreach($stores as $store){
            $id = $store->id;
            $storeName = $store->storeName;
            $address = $store->address;
        }

        //取得した店舗のIDから全投稿取得
        $posts = post::select('posts.id as id', 'points', 'image', 'review', 'posts.store_id', 'stores.storeName', 'stores.address', 'users.name', 'posts.created_at as created')
        ->join('stores', 'posts.store_id', 'stores.id')
        ->join('users', 'posts.user_id', 'users.id')
        ->where('posts.store_id', $id)
        ->get();

        //レビュー平均値
        $avg = post::where('store_id', $id)->avg('points');
        //レビュー投稿数
        $count = post::where('store_id', $id)->count();
        //検索結果がなかった場合のアラート表示
        $message = '店舗はありませんでした。';


        return view('storeInfo', [
            'stores' => $stores,
            'id' => $id,
            'storeName' => $storeName,
            'address' => $address,
            'posts' => $posts,
            'avg' => $avg,
            'count' => $count,
            'message' => $message
        ]);
    }
}
