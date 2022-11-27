@extends('layout')
@section('content')

<!-- 投稿フォーム -->
<h2 style="text-align:center;" class="edit-form">編集</h2>
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
<form action="" method="POST" class="w-50 mt-5" style="margin:0 auto" enctype="multipart/form-data">
@csrf
<div class="form-group mb-3">
    <label for="points" class="form-contents" style="font-size:1.5vw;">評価（点数）</label>
    <div class="text-center">
        <select class="form-select" name="points" aria-label="Default select example">
            @foreach($points as $point)
            <option value="{{ $point }}"
             @if($point == $edit['points']) selected @endif >
             {{ $point }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group mb-3">
    <label for="name" class="form-contents" style="font-size:1.5vw;">店名</label>
    <div class="text-center">
        <input class="form-control form-control-lg" type="text" name="storeName" id="name" value="{{ $edition['storeName'] }}" aria-label="Disabled input example" readonly>
    </div>
</div>

<div class="form-group mb-3">
    <div>
        <label for="formFileLg" class="form-label form-contents" style="font-size:1.5vw;">写真</label>
        <input class="form-control w-50" name="image" id="formFileLg" type="file">
    </div>
</div>

<div class="form-group mb-3">
<label for="exampleFormControlTextarea1" class="form-label form-contents" style="font-size:1.5vw;">レビュー、コメントなど</label>
  <textarea class="form-control form-control-lg" name="review" id="exampleFormControlTextarea1" rows="3" maxlength="250">{{ $edit['review'] }}</textarea>
</div>

<div class="text-center mt-3">
    <button type="submit" class="btn btn-primary btn-lg">編集</button>
</div>
</form>

<style>
    .form-contents{
        padding: 0.5em;/*文字周りの余白*/
        color: black;
        background:rgba(255,250,244,0.5);/*背景色*/
        border-left: solid 5px #ffaf58;
    }

    .edit-form{
        color: #364e96;/*文字色*/
        padding: 0.5em 0;/*上下の余白*/
        border-top: solid 3px #364e96;/*上線*/
        border-bottom: solid 3px #364e96;/*下線*/
        width: 30vw;
        margin:0 auto;
    }
    
    .form{
        text-align:center;
        margin-top:4vw;
    }
</style>
@endsection