@extends('layout')
@section('content')

<!-- ライトモードのサイドバー -->
<main class="d-flex flex-nowrap w-100 mt-4">
    <div class="d-flex flex-column flex-shrink-0 p-3 w-25 side-bar">
        <hr>
        <ul class="nav nav-pills flex-column mb-auto mt-1">
            <li class="nav-item mb-4">
                <a href="{{ route('posts.index') }}" class="nav-link link-dark fa fa-home">
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
                <a class="dropdown-toggle nav-link  fa fa-info active" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-current="page">
                    <svg class="bi me-2" width="16" height="16"></svg>
                    マイページ
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="{{ route('mypage') }}">自分の投稿</a></li>
                    <li><a class="dropdown-item" href="{{ route('mypage') }}">ブックマーク一覧</a></li>
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
        <!-- 自投稿／ブックマーク閲覧 -->
        <h2 class="form mypost mb-5">マイページ</h2>
        <ul class="nav nav-tabs" style="font-size:1.5vw;">
        <li class="nav-item">
            <a class="nav-link active" href="#myPosts" data-bs-toggle="tab">自投稿</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#myFavorites" data-bs-toggle="tab">ブックマーク</a>
        </li>
        </ul>

        <div class="tab-content">
        <!-- 自投稿 -->
            <div id="myPosts" class="tab-pane active">
                <div class="h2 all_post" style="border-bottom: solid 0.2vw black;">自分の投稿一覧</div>
                <div class="main-top p-4">
                    @if(empty($myposts) == true)
                    <div class="alert alert-danger" role="alert">
                        投稿はありません。
                    </div>
                    @else
                    @foreach($myposts as $mypost)
                    <div class="card mb-4" style="max-width: 65vw;">
                        <div class="card-header rounded">
                            <div class="d-flex">
                                <div class="pointt">
                                    <span style="font-size:2.8vw;">{{ $mypost['points'] }}</span><span style="font-size:1.2vw;">点</span>
                                </div>
                                <div class="information ml-5">
                                    <a class="storeName" href="{{ route('storeInfo', ['id' => $mypost['store_id']]) }}">{{ $mypost['storeName'] }}</a>
                                    <div class="border-top border-dark mt-1" style="font-size:1.3vw;">{{ $mypost['address'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-0">
                            <div class="col-md-4 p-2">
                                <img src="storage/img/{{ $mypost['image'] }}" class="ramen_ ml-3">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <p class="card-text ml-2 post-text" style="font-size:1.4vw;" maxlength="250">{{ $mypost['review'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex">
                                <div class="info2 mt-3" style="font-size:1.2vw;">
                                    <span style="margin-left:53vw;"><span>{{ $mypost['created']->format('Y-m-d') }}</span>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- リンク -->
                    <div class="d-flex justify-content-around w-75 mt-4 mb-4"  style="margin:0 auto;">
                        <button type="button" class="btn btn-lg btn-success btn1" onclick="location.href='{{ route('posts.edit', ['post' => $mypost['id']]) }}'">編集</button>
                        <form action="{{ route('posts.destroy', ['post' => $mypost['id']]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="btn btn-lg btn-danger" onclick="return confirm('削除しますか？')" value="削除" />
                        </form>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>

            <!-- ブックマーク -->
            <div id="myFavorites" class="tab-pane">
                <div class="h2 all_post" style="border-bottom: solid 0.2vw black;">ブックマーク一覧</div>
                <div class="main-top p-4">
                    @if(empty($favorites) == true)
                    <div class="alert alert-danger" role="alert">
                        ブックマークはありません。
                    </div>
                    @else
                    @foreach($favorites as $favorite)
                    <div class="card mb-4" style="max-width: 65vw;">
                        <div class="card-header rounded">
                            <div class="d-flex">
                                <div class="pointt">
                                    <span style="font-size:2.8vw;">{{ $favorite['points'] }}</span><span style="font-size:1.2vw;">点</span>
                                </div>
                                <div class="information ml-5">
                                    <a class="storeName" href="{{ route('storeInfo', ['id' => $favorite['store_id']]) }}">{{ $favorite['storeName'] }}</a>
                                    <div class="border-top border-dark mt-1" style="font-size:1.3vw;">{{ $favorite['address'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-0">
                            <div class="col-md-4 p-2">
                                <img src="storage/img/{{ $favorite['image'] }}" class="ramen_ ml-3">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <p class="card-text ml-2 post-text" style="font-size:1.4vw;" maxlength="250">{{ $favorite['review'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex">
                                <button type="button" class="fa fa-bookmark btn btn-info" style="width:13vw;" onclick="location.href='{{ route('outFavorite', ['post' => $favorite['id']]) }}'">ブックマーク解除</button>
                                <div class="info2 mt-3" style="font-size:1.2vw;">
                                    <span style="margin-left:34vw;"><span class="fa fa-user">{{ $favorite['name'] }}</span> | {{ $favorite['created']->format('Y-m-d') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>

            
        </div>
    </div>
</main>







<!-- css -->
<style>
    .mypost{
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
        width: 72vw;
        margin:0 auto ;
        margin-top:4vw;
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
        font-size:10vw;
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
        margin-left:7vw;
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
    .all_post{
        margin-top:2vw;
        text-align:center;
    }
    .storeName{
        font-size:1.3vw;
        cursor:pointer;
        text-decoration:none;
    }
</style>

@endsection