<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\user;

use App\post;

use App\store;

use App\favorite;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */


    // トップページ
    public function home(){
        $posts = post::select('posts.id as id', 'points', 'image', 'review', 'posts.store_id', 'stores.storeName', 'stores.address', 'users.name', 'posts.created_at as created')
        ->join('stores', 'posts.store_id', 'stores.id')
        ->join('users', 'posts.user_id', 'users.id')
        ->get();

        foreach($posts as $post){
            $post_id = $post['id'];
        }

        $id = $post->id;
        $favorites = Auth::user()->favorite()->get();
        $favorite_id = null;
        foreach($favorites as $favorite){
            $favorite_id = $favorite['post_id'];
        }
        $message = '店舗はありませんでした。';
        
        return view('toppage', [
            'posts' => $posts,
            'post_id' => $post_id,
            'favorite_id' => $favorite_id,
            'id' => $id,
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
