@extends('adminlte::page')

@section('title', '情報登録')

@section('content_header')
<h1>教材情報登録</h1>
@stop

@section('content')
<div class="row">
  <div class="col-md-10">
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div class="card card-primary">
      <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="name">名前</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="名前">
          </div>

          <div class="form-group">
            <label for="name">URL</label>
            <input type="text" class="form-control" id="name" name="url" placeholder="URL">
          </div>

          <div class="form-group">
            <label for="type">種別</label>
            {{-- <input type="number" class="form-control" id="type" name="type" placeholder="WEB, 本"> --}}
            <select class="form-select" name="type">
              <option value="">選択して下さい</option>
              <option value="1">WEB</option>
              <option value="2">本</option>
            </select>
            @if($errors->has('type'))
            <span style="color: red;">
              {{ $errors->first('type') }}
            </span>
            @endif
          </div>

          <div class="form-group">
            <label for="keyword">キーワード</label>
            <input type="text" class="form-control" id="keyword" name="keyword" placeholder="キーワード">
          </div>
        </div>

        <div class="form-group">
          <label for="detail">詳細</label>
          <input type="text" class="form-control" id="detail" name="detail" placeholder="詳細説明">
          {{-- <textarea class="form-control" id="detail" name="detail" placeholder="詳細説明" rows="6" cols="50" ></textarea> --}}
        </div>

        <div class="form-group">
          <label for="image">画像アイコン</label><br>
          <input type="file" id="file" name="image"><br>
          <div>
            <span id="msg"></span>
          </div>
        </div>



        <div class="card-footer">
          <button type="submit" class="btn btn-primary">登録</button>
        </div>
      </form>
    </div>
  </div>
</div>
@stop

@section('css')
@stop

@section('js')
<script>
  //   /*入力フォームの要素*/　EditBlade引用
  var fileform = document.getElementById("file");
  /*結果出力用の要素*/
  var result = document.getElementById("msg");
  if (document.getElementById("File_img") == null) {
    // var wkName = ""; //初期化 /*imgタグで表示する画像を退避*/
    //     wkName = document.getElementById("File_img").src;
    result.innerHTML = "登録する画像は未掲載です。";
    //ifでid=File_imgのタグが存在するかチェック
    // if((wkName=="")) {
    // result.innerHTML = "画像は未掲載です。";
    // }else {
    //     result.innerHTML = "変更ありません";
    // }
  }
  /*画像ファイルが変わったかを検知*/
  fileform.addEventListener("change", (e) => {
    // inputfile = fileform.files[0];
    //  if(wkName=="") {
    //    result.innerHTML = "画像は未掲載です。";
    //  }
    // if (wkName != inputfile.name) 
    // {
    // メッセージ表示
    result.innerHTML = "画像登録を設定中です";
    // } //else省略
  });

  // 

</script>
@stop
