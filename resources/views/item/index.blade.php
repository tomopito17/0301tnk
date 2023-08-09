@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
<h1>商品一覧</h1>
@stop

@section('content')
{{-- @if (count($items) > 0)
@endif --}}
<div class="container" style="width: 100%">
  <div class="row" >
    <div class="col-4">
      <form action="/items" method="GET">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="検索" name="SearchWord" value="@isset($SearchWord){{$SearchWord}} @endisset" aria-describedby="button-addon2">
        </div>
				<button class="btn btn-outline-secondary" type="submit" id="button-addon2">検索</button>
      </form>
    </div>

    <div class="col-4">
      <div class="input-group mb-3" >
        <div class="input-group-text">
          <input class="form-check-input mt-0" type="checkbox" value=""@isset($AndSearchWord){{$AndSearchWord}} @endisset" aria-label="Checkbox for following text input" >
        </div>
        <input type="text" class="form-control" aria-label="Text input with checkbox" name="AndSearchWord" placeholder="AND検索">
      </div>
    </div>
  </div>
</div>




<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">商品一覧</h3>
        <div class="card-tools">
          <div class="input-group input-group-sm">
            <div class="input-group-append">
              <a href="{{ url('items/add') }}" class="fa fa-plus">商品登録</a>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th>ID</th>
              <th>名前</th>
              <th>種別</th>
              <th>詳細</th>
              <th>削除</th>
              <th>編集</th>
              <th>アイコン</th>
              <th>キーワード</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($items as $item)
            <tr>
              <td>{{ $item->id }}</td>
              <td>{{ $item->name }}</td>
              <td>{{ $item->type }}</td>
              <td>{{ $item->detail }}</td>
              {{-- <td> 
                @csrf
                <input type="hidden" name="id" value="{{$item->id}}">
              <input type="file" name="image"><button>アップロード</button>
              @foreach ($images as $image)
              <img src="{{ asset($image->path) }}" width="20%">
              @endforeach
              <td> --}}
              <td>
                <form action="{{url('items/delete')}}" method="POST" onsubmit="return confirm('削除してよろしいですか？');">
                  @csrf
                  <input type="hidden" name="id" value="{{$item->id}}">
                  <input type="submit" class="btn btn-danger" value="削除">
                </form>
              </td>
              <td>
                <a href="{{ url('items/edit/' . $item->id) }}" class="btn btn-info">編集</a>
                {{-- <a href="{{url('items/edit/' . $item->id)}}">編集</a> --}}
              </td>
              <td>
                <input type="hidden" id="file" name="image">
                @if($item->image!=Null)
                <img src="data:image/png;base64, {{ $item->image }} " style="max-height: 50px; width:auto">
                @else {{"画像無"}}
                @endif
              </td>
              <td>{{ $item->keyword }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{-- @foreach ($images as $image)                            
           <img src="{{ asset($image->path) }}">
        @endforeach --}}
      </div>
    </div>
  </div>
</div>


<form method="POST" action="/items/upload" enctype="multipart/form-data">
  @csrf
  <input type="file" name="image">
  <button>アップロード</button>
</form>
@stop

@section('css')
@stop

@section('js')
@stop
