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
                    <a href="{{ route('admin') }}" class="navbar-brand ml-lg-3">
                        <h1 class="m-0 display-5 text-uppercase text-black" style="font-family: 'Sawarabi Mincho', sans-serif;">東京ラーメンログ</h1>
                    </a>
                    @if(Auth::check())
                    <div class="collapse navbar-collapse justify-content-between px-lg-3 navi_" id="navbarCollapse">
                        <div class="my-navbar-control text-end">
                            <a href="{{ route('admin') }}" class="my-navbar-item fa fa-user text-decoration-none">{{ Auth::user()->name }}[管理者]</a>
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
        </div>

        <h3 class="bg-success mt-3" style="text-align:center;--bs-bg-opacity: .5;" >管理者専用ページ</h3>
        <h2 style="text-align:center;" class="permission mt-5">店舗申請一覧</h2>
        @if(empty($stores) == true)
            <div class="alert alert-danger" role="alert">
                店舗申請はありません。
            </div>
        @else
            @foreach($stores as $store)
            <table class="table table-bordered border-info w-75 mt-4" style="margin:0 auto;">
                <tbody>
                    <tr>
                    <th scope="row">店名</th>
                    <td>{{ $store->storeName }}</td>
                    </tr>
                    <tr>
                    <th scope="row">郵便番号</th>
                    <td>@if(!empty($store['postCode'])) {{ $store->postCode }} @endif</td>
                    </tr>
                    <tr>
                    <th scope="row">住所</th>
                    <td>{{ $store->address }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-around w-50 mt-4 mb-4"  style="margin:0 auto;">
                <button type="button" class="btn btn-success btn-lg" onclick="location.href='{{ route('permit_ok', ['store' => $store['id']]) }}'">許可</button>
                <button type="button" class="btn btn-danger btn-lg" onclick="location.href='{{ route('permit_ng', ['store' => $store['id']]) }}'">拒否</button>
            </div>
            @endforeach
        @endif
    </body>
</html>


<style>
    @import url('https://fonts.googleapis.com/css?family=Sawarabi+Mincho');
    .bg-img{
        background-image: url('{{ asset('storage/img/jinmen.jpg') }}');
        background-size: cover;
        background-position: center 34%;
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
    .permission{
        color: #364e96;/*文字色*/
        padding: 0.5em 0;/*上下の余白*/
        border-top: solid 3px #364e96;/*上線*/
        border-bottom: solid 3px #364e96;/*下線*/
        width: 30vw;
        margin:0 auto;
    }
    
</style>