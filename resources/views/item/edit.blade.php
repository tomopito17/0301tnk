@extends('adminlte::page')

@section('content_header')
<h1>商品編集</h1>
@stop

@section('content')
<!-- <div class="row"> -->
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
  <form action="{{ url('items/edit') }}/{{ $item->id }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    <div class="card card-primary">
      <form method="POST">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="name">名前</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="名前" value="{{$item->name}}">
          </div>

          <div class="form-group">
            <label for="type">種別</label>
            <input type="number" class="form-control" id="type" name="type" placeholder="1, 2, 3, ..." value="{{$item->type}}">
          </div>

          <div class="form-group">
            <label for="detail">詳細</label>
            <input type="text" class="form-control" id="detail" name="detail" placeholder="詳細説明" value="{{$item->detail}}">
          </div>
          <div class="form-group">
            <label for="image">画像</label>
            <input type="file" id="file" name="image"><br>
            @if(!is_null($item->image))
            <img src="data:image/png;base64, {{ $item->image }} " id="File_img" width="300px" style="vertical-align: top">
            {{-- @else{{"画像を変更中"}} --}}
            @endif
            <div>
              <span id="msg"></span>
            </div>
            {{-- @foreach ($images as $image)
                        <img src="{{ asset($image->path) }}">
            @endforeach --}}
          </div>
          <div class="form-group">
            <label for="keyword">キーワード</label>
            <input type="text" class="form-control" id="keyword" name="keyword" placeholder="キーワード" value="{{$item->keyword}}">
          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">編集OK</button>
        </div>
      </form>

    </div>
</div>
<!-- </div -->
@stop

@section('css')
@stop

@section('js')
<script>
  /*入力フォームの要素*/
  var fileform = document.getElementById("file");
  /*結果出力用の要素*/
  var result = document.getElementById("msg");
  if (document.getElementById("File_img") == null) {
    // var wkName = ""; //初期化 /*imgタグで表示する画像を退避*/
    //     wkName = document.getElementById("File_img").src;
    result.innerHTML = "追加または変更の画像は未掲載です。";
    //ifでid=File_imgのタグが存在するかチェック
    // if((wkName=="")) {
    // result.innerHTML = "画像は未掲載です。";
    // }else {
    //     result.innerHTML = "変更ありません";
    // }
  }
  /*画像ファイルが変わったかを検知*/
  fileform.addEventListener("change", (e) => {
    inputfile = fileform.files[0];
    //  if(wkName=="") {
    //    result.innerHTML = "画像は未掲載です。";
    //  }
    if (wkName != inputfile.name) {
      // メッセージ表示
      result.innerHTML = "画像を追加または変更を設定中です";
    } //else省略
  });

</script>
@stop
