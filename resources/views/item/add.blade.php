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
            <input type="number" class="form-control" id="type" name="type" placeholder="1, 2, 3, ...">
          </div>

          <div class="form-group">
            <label for="detail">詳細とレビュー</label>
            <input type="text" class="form-control" id="detail" name="detail" placeholder="詳細説明">
          </div>
          <div class="form-group">
            <label for="detail">画像</label><br>
            <input type="file" name="image">
          </div>

          <div class="form-group">            
            <label for="keyword">キーワード</label>
						<input type="text" class="form-control" id="keyword" name="keyword" placeholder="キーワード">
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
@stop
