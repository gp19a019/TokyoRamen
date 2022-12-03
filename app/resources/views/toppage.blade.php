@extends('layout')
@section('content')

<!-- ライトモードのサイドバー -->
<main class="d-flex flex-nowrap w-100 mt-4">
    <div class="d-flex flex-column flex-shrink-0 p-3 w-25 side-bar">
        <hr>
        <ul class="nav nav-pills flex-column mb-auto mt-1">
            <li class="nav-item mb-4">
                <a href="{{ route('posts.index') }}" class="nav-link fa fa-home active" aria-current="page">
                <svg class="bi me-2" width="16" height="16"></svg>
                トップ
                </a>
            </li>
            <li class=" mb-4">
                <a href="{{ route('storeNameForm') }}" class="nav-link link-dark fa fa-cutlery">
                <svg class="bi me-2" width="16" height="16"></svg>
                店舗申請
                </a>
            </li>
            <li class="mb-4" style="cursor: pointer;">
                <a class="dropdown-toggle nav-link link-dark fa fa-info" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg class="bi me-2" width="16" height="16"></svg>
                    マイページ
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="{{ url('myPage#myPosts') }}">自分の投稿</a></li>
                    <li><a class="dropdown-item" href="{{ url('myPage#myFavorites') }}">ブックマーク一覧</a></li>
                </ul>
            </li>
            <li class=" mb-4">
                <a href="{{ route('storeinfo_') }}" class="nav-link link-dark fa fa-cutlery">
                <svg class="bi me-2" width="16" height="16"></svg>
                店舗検索
                </a>
            </li>
        </ul>
    </div>
    <!-- /ライトモードのサイドバー -->


    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light w-75">
        <!-- 検索機能 -->
        <h2 class="form all-post mb-5">投稿一覧</h2>
        <form action="{{ 'search' }}" method="post">
            @csrf
            <div class="input-group w-75" style="margin:0 auto">
                <input type="search" class="form-control form-control-lg" name="keyword" placeholder="店名、または地名を入力">
                <input class="btn btn-outline-success btn-lg" type="submit" id="button-addon2" value="検索">
            </div>
        </form>

        <!-- 投稿一覧 -->
        <div class="main-top p-4">
            @if(empty($posts) == true)
                <div class="alert alert-danger" role="alert">
                    投稿はありません。
                </div>
            @else
            @foreach($posts as $post)
            <div class="card mb-4" style="max-width: 65vw;">
                <div class="card-header rounded">
                    <div class="d-flex">
                        <div class="pointt">
                            <span style="font-size:2.8vw;">{{ $post['points'] }}</span><span style="font-size:1.2vw;">点</span>
                        </div>
                        <div class="information ml-5">
                            <a class="storeName" href="{{ route('storeInfo', ['id' => $post['store_id']]) }}">{{ $post['storeName'] }}</a>
                            <div class="border-top border-dark mt-1" style="font-size:1.3vw;">{{ $post['address'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-md-4 p-2">
                        <img src="storage/img/{{ $post['image'] }}" class="ramen_ ml-3">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <p class="card-text ml-2 post-text" style="font-size:1.4vw;" maxlength="250">{{ $post['review'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        @if(!(Auth::user()->name == $post['name']))
                            @if(!empty($post_id) && !($post_id == $favorite_id))
                            <button type="button" class="fa fa-bookmark btn btn-outline-info" onclick="location.href='{{ route('favorite', ['post' => $post['id']]) }}'">ブックマーク</button>
                            <div class="info2 mt-3" style="font-size:1.2vw;">
                                <span style="margin-left:38vw;"><span class="fa fa-user">{{ $post['name'] }}</span> | {{ $post['created']->format('Y-m-d') }}</span>  
                            </div>
                            @else
                            <button type="button" class="fa fa-bookmark btn btn-info" style="width:13vw;" onclick="location.href='{{ route('outFavorite', ['post' => $post['id']]) }}'">ブックマーク解除</button>
                            <div class="info2 mt-3" style="font-size:1.2vw;">
                                <span style="margin-left:34vw;"><span class="fa fa-user">{{ $post['name'] }}</span> | {{ $post['created']->format('Y-m-d') }}</span>
                            </div>
                            @endif
                        @else
                        <div class="info2 mt-3" style="font-size:1.2vw;">
                        <span style="margin-left:48vw;"><span class="fa fa-user">{{ $post['name'] }}</span> | {{ $post['created']->format('Y-m-d') }}</span>  
                        </div>
                        @endif
                        
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>

    </div>



</div>
<!-- css -->
<style>
    .all-post{
        color: #364e96;/*文字色*/
        padding: 0.5em 0;/*上下の余白*/
        border-top: solid 3px #364e96;/*上線*/
        border-bottom: solid 3px #364e96;/*下線*/
        width: 30vw;
        margin:0 auto;
        text-align:center;
    }
    .side-bar{
        height: 35vw;
        background-color:#EEEEEE;
    }
    .main-top{
        background-color:#663333;
        width: 68vw;
        margin:0 auto ;
        margin-top:3vw;
    }
    .user-namee{
        font-size:1.15vw;
        margin-right:10vw;
        margin-bottom:3vw;
    }
    .points{
        padding:1vw;
        width: 20vw;
        height:17vw;
        font-size:8vw;
        text-align:center;
    }
    .name{
        font-size:1.4vw;
        margin-bottom:6vw;
    }
    .address{
        font-size:1.4vw;
    }
    .info{
        margin-left:4vw;
        margin-bottom:3vw;
        margin-top:2.5vw;
    }
    .date{
        text-align:end;
        margin-right:3vw;
        margin-top:2.5vw;
        margin-bottom:1.5vw;
        font-size:1.15vw;
    }
    .ramen_{
        width: 22vw;
        height: 20vw;
    }
    .post--{
        width: 60vw;
    }
    .storeName{
        font-size:1.3vw;
        cursor:pointer;
        text-decoration:none;
    }
</style>



@endsection