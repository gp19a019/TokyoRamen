@extends('layout')
@section('content')
<h2 class="regist mb-5 mt-5" style="text-align:center">会員登録フォーム</h2>

@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $message)
    <p>{{ $message }}</p>
    @endforeach
</div>
@endif

<form action="{{ route('register') }}" method="POST" class="w-50 mt-5" style="margin:0 auto">
@csrf
<div class="form-group">
    <label for="name" class="form-contents" style="font-size:1.5vw;">ニックネーム</label>
    <div class="text-center">
        <input type="text" class="form-control form-control-lg" id="name" maxlength="15" name="name" value="{{ old('name') }}" required />
    </div>
</div>

<div class="form-group">
    <label for="email" class="form-contents" style="font-size:1.5vw;">メールアドレス</label>
    <div class="text-center">
        <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" required />
    </div>
</div>

<div class="form-group">
    <label for="password" class="form-contents" style="font-size:1.5vw;">パスワード</label>
    <div class="text-center">
        <input type="password" class="form-control form-control-lg" id="password" maxlength="15" name="password" required>
    </div>
</div>

<div class="form-group">
    <label for="password-confirm" class="form-contents" style="font-size:1.5vw;">パスワード（確認）</label>
    <div class="text-center">
        <input type="password" class="form-control form-control-lg" id="password-confirm" maxlength="15" name="password_confirmation" required>
    </div>
</div>

<div class="text-center">
    <button type="submit" class="btn btn-primary btn-lg">送信</button>
</div>
</form>


<style>
    .regist{
        color: #364e96;/*文字色*/
        padding: 0.5em 0;/*上下の余白*/
        border-top: solid 3px #364e96;/*上線*/
        border-bottom: solid 3px #364e96;/*下線*/
        width: 30vw;
        margin:0 auto;
        text-align:center;
    }
    .form-contents{
        padding: 0.5em;/*文字周りの余白*/
        color: black;
        background:rgba(255,250,244,0.5);/*背景色*/
        border-left: solid 5px #ffaf58;
    }
</style>
@endsection

