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
        $id = null;

        $posts = post::select('posts.id as id', 'points', 'image', 'review', 'posts.store_id', 'stores.storeName', 'stores.address', 'users.name', 'posts.created_at as created', 'stores.permission')
        ->join('stores', 'posts.store_id', 'stores.id')
        ->join('users', 'posts.user_id', 'users.id')
        ->where('stores.permission',1)
        ->where('storeName', 'LIKE', "%{$keyword}%")
        ->orWhere('address', 'LIKE', "%{$keyword}%")
        ->get();

        if(!empty($posts)){
            foreach($posts as $post){
                $id = $post->id;
            } 
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
        return redirect('/posts');

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
        $id = $post->id;

        //favoritesテーブルの投稿IDから最初のレコードを削除
        $favorite = Auth::user()->favorite()->where('post_id', $id)->first();
        $favorite_id = $favorite['id'];

        favorite::destroy($favorite_id);
        
        //マイページへリダイレクト
        return redirect('/myPage');
    }



    // 店舗検索
    public function store_search(search $request){
        //入力値を取得
        $keyword = $request->keyword;

        //該当の店舗があるか
        $stores = store::select('id', 'storeName', 'address', 'permission')
        ->where('permission',1)
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
