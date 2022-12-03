<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreatePost;
use App\Http\Requests\CreateStore;
use App\Http\Requests\Search;
use App\Post;
use App\user;
use App\store;
use App\favorite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        //アクセス時
    public function index(){
        $posts = post::select('posts.id as id', 'points', 'image', 'review', 'posts.store_id', 'stores.storeName', 'stores.address', 'users.name', 'posts.created_at as created')
        ->join('stores', 'posts.store_id', 'stores.id')
        ->join('users', 'posts.user_id', 'users.id')
        ->get();

        $post_id = null;
        $favorite_id = null;


        if(!empty($posts)){
            foreach($posts as $post){
                $post_id = $post['id'];
            }
            $favorites = Auth::user()->favorite()->get();
            
            if(!empty($favorites)){
                foreach($favorites as $favorite){
                $favorite_id = $favorite['post_id'];
                }
            }
        }
        
        $message = '店舗はありませんでした。';
        
        return view('toppage', [
            'posts' => $posts,
            'post_id' => $post_id,
            'favorite_id' => $favorite_id,
            'message' => $message
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(createPost $request)
    {
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

        return redirect('/myPage');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(post $post)
    {
        $store = new store;
        $store_id = $post['store_id'];
        $edition = $store->find($store_id);
        $points = [10,20,30,40,50,55,60,65,70,75,80,85,90,95,100];
    
        return view('editPostForm', [
            'edit' => $post,
            'points' => $points,
            'edition' => $edition
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(post $post, createPost $request)
    {
        //エラーハンドリング
        if(is_null($post)){
            abort(404);
        }
        $name = $request->storeName;
        $id = store::where('storeName', $name)->first()->id;

        $columns = ['points', 'image', 'review'];
        foreach($columns as $column){
            $post->$column = $request->$column;
        }
        $post->store_id = $id;

        $file = $request->image;
        $request->file('image')->storeAs('public/img', $file);
        Auth::user()->post()->save($post);

        return redirect('/myPage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //エラーハンドリング
        if(is_null($post)){
            abort(404);
        }
        $post->delete();

        return redirect('/myPage');
    }
}
