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
                <a href="{{ route('storeNameForm') }}" class="nav-link fa fa-cutlery active" aria-current="page">
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
                <a href="{{ route('storeinfo_') }}" class="nav-link link-dark fa fa-cutlery">
                <svg class="bi me-2" width="16" height="16"></svg>
                店舗検索
                </a>
            </li>
        </ul>
    </div>
    <!-- /ライトモードのサイドバー -->


    <!-- 店舗登録申請フォーム -->
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light w-75">
        <h2 class="form store-form mb-3">店舗登録申請フォーム</h2>
        <!-- バリデーションエラー -->
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $message)
                <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('storeNameForm') }}" method="POST" class="w-75 mt-2" style="margin:0 auto">
            @csrf
            <div class="form-group">
                <label for="name" class="form-contents" style="font-size:1.5vw;">店名</label>
                <div class="text-center">
                    <input type="text" class="form-control form-control-lg"placeholder="○○商店" id="name" name="storeName" value="{{ old('storeName') }}">
                </div>
            </div>

            <div class="form-group">
                <label for="postCode" class="form-contents" style="font-size:1.5vw;">郵便番号（数字のみ）</label>
                <div class="text-start w-25">
                    <input type="text" class="form-control form-control-lg" id="postCode" name="postCode" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');"  value="{{ old('postCode') }}">
                </div>
            </div>

            <div class="form-group">
                <label for="address" class="form-contents" style="font-size:1.5vw;">住所</label>
                <div class="text-start">
                    <input type="text" class="form-control form-control-lg" id="address" name="address" value="{{ old('address') }}">
                </div>
            </div>
            

            <div class="text-center" style="margin-top:3vw;">
                <input type="submit" class="btn btn-primary btn-lg" value="申請">
            </div>
        </form>
    </div>

</main>



<style>
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
        text-align:center;
    }
</style>

@endsection