@extends('adminlte::page')

@section('title', '教材一覧')

@section('content_header')
<div class="container" style="width: 100%">
  @if(session('success') !=Null)
  @dump(session('success'))
  @endif
  <div class="row">
    <h1 class="col">教材リスト</h1>

    <div class="col">
      <div class="input-group	">
        <input type="text" class="form-control" placeholder="名前検索" name="SearchName" value="@isset($SearchName){{$SearchName}} @endisset" aria-describedby="button-addon2">
        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">名前検索</button>
      </div>
    </div>
  </div>
</div>
@stop

@section('content')

<div class="container" style="width: 100%">
  <form action="/items" method="GET">

    <div class="row">
      <div class="col px-0">
        <div class="input-group	">
          <input type="text" class="form-control" placeholder="キーワード検索" name="SearchWord" value="@isset($SearchWord){{$SearchWord}} @endisset" aria-describedby="button-addon2">
        </div>
        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">検索</button>
      </div>

      <div class="col px-0">
        <div class="input-group">
          <div class="input-group-text">
            <input class="form-check-input mt-0" type="checkbox" name="checkbox" value="checked">
          </div>
          <input type="text" class="form-control" aria-label="Text input with checkbox" name="AndSearchWord" placeholder="AND検索" value="@isset($AndSearchWord){{$AndSearchWord}} @endisset" aria-label="Checkbox for following text input">
        </div>
      </div>
    </div>
	</form>

	<div class="row">
		<form method="POST" action="/items/csv_upload" enctype="multipart/form-data">
			@csrf
			<input type="file" name="csv">
			<button>CSVアップロード</button>
		</form>
	</div>

</div>



<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">教材一覧</h3>
        @if (count($items) > 0)
        <span class="item-sum">{{"　登録数：" . $count}}</span>
        @endif
        <div class="card-tools">
          <div class="input-group input-group-sm">
            <div class="input-group-append">
              <a href="{{ url('items/add') }}" class="fa fa-plus">教材登録</a>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th>ID</th>
              <th>名前(リンク)</th>
              <th class=text-center>種別/登録者</th>
              <th>詳細</th>
              <th>　削除/編集</th>              
              <th>アイコン</th>
              <th>キーワード</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($items as $item)
            <tr>
              <td>{{ $item->id }}</td>
              <td><a href="{{$item->url}}" target="_blank">{{ $item->name }}</a></td>
              <td class=text-center>
                @if($item->type==1)Web @else 本  @endif {{"/".$item->user_id}}
              </td>
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
              <div class="row">
                  <form action="{{url('items/delete')}}" method="POST" onsubmit="return confirm('削除してよろしいですか？');">
                    @csrf
                    <input type="hidden" name="id" value="{{$item->id}}">
                    <div class="col px-0">
                    <input type="submit" class="btn btn-danger" value="削除">
                    </div>
                  </form>             
                <div class="col px-1">
                  <a href="{{ url('items/edit/' . $item->id) }}" class="btn btn-info">編集</a>
                  {{-- <a href="{{url('items/edit/' . $item->id)}}">編集</a> --}}
                </div>
              </div>

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
