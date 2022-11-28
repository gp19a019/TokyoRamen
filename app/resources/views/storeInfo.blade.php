<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>東京ラーメンログ</title>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

        <!-- Ajax -->
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">


    </head>

    <body>
    <div class="main w-100 bg-img" style="height:20vw;">
        <!-- Navbar Start -->
        <div class="container-fluid p-0 mb-3 bg-transparent">
            <nav class="navbar navbar-expand-lg py-3 py-lg-0 px-lg-5 aaa" style="height:20vw;">
                <a href="{{ route('home') }}" class="navbar-brand ml-lg-3">
                    <h1 class="m-0 display-5 text-uppercase text-black" style="font-family: 'Sawarabi Mincho', sans-serif;">東京ラーメンログ</h1>
                </a>
                @if(Auth::check())
                <div class="collapse navbar-collapse justify-content-between px-lg-3 navi_" id="navbarCollapse">
                    <div class="navbar-nav m-auto ml-2 navi1">
                        <a href="{{ route('home') }}" class="nav-item nav-link fa fa-home">トップ</a>
                        <a href="{{ route('storeNameForm') }}" class="nav-item nav-link ml-3 fa fa-cutlery">店舗申請</a>
                        <a href="{{ route('mypage') }}" class="nav-item nav-link ml-3 fa fa-info">マイページ</a>
                        <a href="{{ route('storeinfo_') }}" class="nav-item nav-link ml-3 fa fa-cutlery">店舗検索</a>
                    </div>
                    <div class="my-navbar-control text-end">
                        <a href="{{ route('home') }}" class="my-navbar-item fa fa-user text-decoration-none">{{ Auth::user()->name }}</a>
                            /
                        <a href="#" id="logout" class="my-navbar-item">ログアウト</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="post" style="display: none;">
                        @csrf
                        </form>
                        <script>
                            document.getElementById('logout').addEventListener('click',function(event){
                            event.preventDefault();
                            document.getElementById('logout-form').submit();
                            });
                        </script>

                        @else
                        <a class="my-navbar-item" href="{{ route('login') }}">ログイン</a>
                            /
                        <a class="my-navbar-item" href="{{ route('register') }}">会員登録</a>
                        @endif
                    </div>
                </div>
            </nav>
        </div>
        <!-- Navbar End -->

        <style>
            @import url('https://fonts.googleapis.com/css?family=Sawarabi+Mincho');
            .bg-img{
                background-image: url('storage/img/jinmen.jpg');
                background-size: cover;
                background-position: center 30%;
            }
            .aaa{
                background-color: rgba(255, 255, 255, 0.25);
            }
            .navi1{
                font-weight: bold;
            }
            .ramen{
                width: 5vw;
                height: 5vw;
                margin-left:0.5vw;
            }
            .navi_{
                margin-right:2vw;
                font-size:1.25vw;
            }
        </style>
    </div>

<!-- 店舗情報 -->
<!-- ライトモードのサイドバー -->
<main class="d-flex flex-nowrap w-100 mt-4">
    <div class="d-flex flex-column flex-shrink-0 p-3 w-25 side-bar">
        <hr>
        <ul class="nav nav-pills flex-column mb-auto mt-1">
            <li class="nav-item mb-4">
                <a href="{{ route('home') }}" class="nav-link link-dark fa fa-home">
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
                    <li><a class="dropdown-item" href="{{ route('mypage') }}">自分の投稿</a></li>
                    <li><a class="dropdown-item" href="{{ route('mypage') }}">ブックマーク一覧</a></li>
                </ul>
            </li>
            <li class=" mb-4">
                <a href="{{ route('storeinfo_') }}" class="nav-link fa fa-cutlery active" aria-current="page">
                <svg class="bi me-2" width="16" height="16"></svg>
                店舗検索
                </a>
            </li>
        </ul>
    </div>
    <!-- /ライトモードのサイドバー -->
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light w-75">
        <div class="h2 detail mb-5">店舗詳細</div>
        <!-- 検索機能 -->
        <form action="{{ url('storeInfo') }}" method="post">
            @csrf
            <div class="input-group w-75" style="margin:0 auto">
                <input type="search" class="form-control form-control-lg" name="keyword" placeholder="店名、または地名を入力">
                <input class="btn btn-outline-success btn-lg" type="submit" id="button-addon2" value="検索">
            </div>
        </form>

        @if(!empty($id))
        <table class="table table-bordered border-info w-75 mt-4" style="margin:0 auto;">
            <tbody>
                <tr>
                <th scope="row">店名</th>
                <td>{{ $storeName }}</td>
                </tr>
                <tr>
                <th scope="row">住所</th>
                <td>{{ $address }}</td>
                </tr>
                <tr>
                <th scope="row">平均点</th>
                <td style="color:red;">{{ (int)$avg }}</td>
                </tr>
                <tr>
                <th scope="row">レビュー投稿数</th>
                <td>{{ $count }}</td>
                </tr>
                <tr>
                <th scope="row">マップ</th>
                <td>
                    <div id="map" style="width: 30vw;height: 25vw;"></div>
                    <!-- APIキーを指定してjsファイルを読み込む -->
                    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2oZmSlJZ5nRVkdFoTTSHLfPcz3igUga0&callback=initMap"></script>
                    <script type="text/javascript">
                    // Google Mapを表示する関数
                    function initMap() {
                    const geocoder = new google.maps.Geocoder();
                    // ここでaddressのvalueに住所のテキストを指定する
                    geocoder.geocode( { address: '{{ $address }}'}, function(results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                        const latlng = {
                            lat: results[0].geometry.location.lat(),
                            lng: results[0].geometry.location.lng()
                        }
                        const opts = {
                            zoom: 15,
                            center: new google.maps.LatLng(latlng)
                        }
                        const map = new google.maps.Map(document.getElementById('map'), opts)
                        new google.maps.Marker({
                            position: latlng,
                            map: map 
                        })
                        } else {
                        console.error('Geocode was not successful for the following reason: ' + status)
                        }
                    })
                    }
                    </script>
                </td>
                </tr>
            </tbody>
        </table>

        <!-- リンク -->
        <div class="mt-4 text-center">
            <button type="button" class="btn btn-lg btn-outline-info" onclick="location.href='{{ route('postForm', ['id' => $id]) }}'">このお店のレビューを書く</button>
        </div>

        <!-- 投稿一覧 -->
        <div class="main-top p-4">
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
                            @if(!($post_id == $favorite_id))
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
        </div>
        @else
            @if(!empty($message))
            <script>alert('{{ $message }}')</script>
            @endif
        @endif
    </div>
</main>
</body>

<!-- css -->
<style>
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
    .post--{
        width: 60vw;
    }
    .form-contents{
        padding: 0.5em;/*文字周りの余白*/
        color: black;
        background:rgba(255,250,244,0.5);/*背景色*/
        border-left: solid 5px #ffaf58;
    }
    .store-form{
        color: #364e96;/*文字色*/
        padding: 0.5em 0;/*上下の余白*/
        border-top: solid 3px #364e96;/*上線*/
        border-bottom: solid 3px #364e96;/*下線*/
        width: 30vw;
        margin:0 auto;
    }
    .user-namee{
        font-size:1.15vw;
        text-align:end;
        margin-right:1.5vw;
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
    .detail{
        margin-top:4vw;
        color: #364e96;/*文字色*/
        padding: 0.5em 0;/*上下の余白*/
        border-top: solid 3px #364e96;/*上線*/
        border-bottom: solid 3px #364e96;/*下線*/
        width: 30vw;
        margin:0 auto;
        text-align:center;
    }
    .all_post{
        margin-top:6vw;
        text-align:center;
    }
    .ramen_{
        width: 22vw;
        height: 20vw;
    }
    .storeName{
        font-size:1.3vw;
        cursor:pointer;
        text-decoration:none;
    }
</style>
</html>