@extends('layout')
@section('content')
<h2 class="log mb-5 mt-5" style="text-align:center">ログイン</h2>

@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $message)
    <p>{{ $message }}</p>
    @endforeach
</div>
@endif

<form action="{{ route('login') }}" method="POST" class="border border-3 rounded w-75 forms">
    @csrf
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label form-contents">メールアドレス</label>
        <div class="col-xs-4">
            <input type="email" class="form-control form-control-lg" name="email" id="exampleInputEmail1" value="{{ old('email') }}" aria-describedby="emailHelp">
        </div>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label form-contents">パスワード</label>
        <input type="password" class="form-control form-control-lg" name="password" id="exampleInputPassword1">
    </div>
    
    <input type="submit" class="btn btn-outline-dark btn-lg" value="ログイン">
    @if (Route::has('password.request'))
        <a class="btn btn-link" href="{{ route('password.request') }}">
            {{ __('パスワードをお忘れの方はこちら') }}
        </a>
    @endif
</form>


<style>
    .forms{
        margin:0 auto;
        margin-top:2vw;
        padding:5vw;
        font-size:1.5vw;
    }
    .log{
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