@extends('adminlte::page')

@section('title', '教材一覧')

@section('content_header')
{{-- @if(session('success') !=Null)
 @dump(session('success'))
 @endif --}}


<div class="container-fluid" style="width: 100%">
  <div class="row px-0">
    <h1>教材リスト　</h1>
    <div class="col">
      <form action="/items" method="GET">
        <label for="type" class="form-label">名前か詳細、または両方を検索対象として選択</label>
        <select class="form-select" name="select">
          {{-- <option value="" >選択してください</option> --}}
          <option value="select-name" @if(isset($_GET['select']) && $_GET['select']=='select-name' ){{"selected"}} @endif>名前</option>
          <option value="select-detail" @if(isset($_GET['select']) && $_GET['select']=='select-detail' ){{"selected"}} @endif>詳細</option>
          <option value="select-both" @if(isset($_GET['select']) && $_GET['select']=='select-both' ){{"selected"}} @endif>名前と詳細</option>
        </select>
        {{-- </div>
    <div class="col float-left"> --}}

        <div class="input-group">
          <input type="text" class="form-control" placeholder="名前or詳細検索" name="SearchName" value="@isset($SearchName){{$SearchName}} @endisset" aria-describedby="button-addon2">
          <button class="btn btn-outline-secondary" type="submit" id="button-addon2" name="Search" value="Name">名前or詳細検索</button>
        </div>
      </form>
    </div>
  </div>
</div>

@stop

@section('content')

<div class="container-fluid">
  <form action="/items" method="GET">

    <div class="row">
      <label for="type" class="form-label">キーワード検索　</label>
      <div class="col px-0">
        <div class="input-group	">
          <input type="text" class="form-control" placeholder="キーワード検索" name="SearchWord" value="@isset($SearchWord){{$SearchWord}} @endisset" aria-describedby="button-addon2">
        </div>
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
    <button class="btn btn-outline-secondary" type="submit" id="button-addon2" name="Search" value="keyword">キーワード検索</button>キーワードを2つでAND検索する際はチェックボックスにチェック(☑)をいれてください
  </form>

  {{-- <div class="row">
		<form method="POST" action="/items/csv_upload" enctype="multipart/form-data">
			@csrf
			<input type="file" name="csv">
			<button>CSVアップロード</button>
		</form>
	</div> --}}

</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><b>教材一覧</b></h3>
        @if (count($items) > 0)
        <span class="item-sum">　　IDより詳細ページへ{{"　　全登録数：" . $count."　"}} <a href="/items">一覧を更新</a></span>
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
              <th class=text-center>アイコン</th>
              <th class=text-center>種別/登録者</th>
              <th>詳細</th>
              <th>変更</th>
              <th>キーワード</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($items as $item)
            <tr>
              <td><a href="{{ url('/items/detail' ,$item->id)}}">{{ $item->id }}</a></td>
              <td style="overflow: hidden; text-overflow: ellipsis;white-space: nowrap; max-width:200px">
                <a href="{{$item->url}}" target="_blank">{{ $item->name }}</a>
              </td>

              <td class=text-center>
                <input type="hidden" id="file" name="image">
                @if($item->image!=Null)
                <img src="data:image/png;base64, {{ $item->image }}" style="height:30px; width:30px; object-fit:cover">
                @else {{"画像無"}}
                @endif
              </td>

              <td class=text-center>
                @if($item->type==1)Web @else 本 @endif {{"/".$item->user->name}}
              </td>
              <td style="overflow: hidden; text-overflow: ellipsis;white-space: nowrap; max-width:400px">
                <details>
                  <summary>{{mb_strimwidth($item->detail, 0, 7, '…')}}</summary>{{ $item->detail }}
                </details>
              </td>
              {{-- <td> 
                @csrf
                <input type="hidden" name="id" value="{{$item->id}}">
              <input type="file" name="image"><button>アップロード</button>
              @foreach ($images as $image)
              <img src="{{ asset($image->path) }}" width="20%">
              @endforeach
              <td> --}}
              <td>
                <button class="toggle-details" class=text-center>管理</button>
                <div class="details" style="display: none;">
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
{{-- @if(($request->Search == "Name") || ($request->Search == "keyword")){{}} @else{{$items->links}}
@endif --}}
{{-- @if() {{$items->links()}}
@endif --}}
{{-- <form method="POST" action="/items/upload" enctype="multipart/form-data">
  @csrf
  <input type="file" name="image">
  <button>アップロード</button>
</form> --}}
@stop

@section('css')
@stop

@section('js')
<script>
  $(document).ready(function() {
    $('table').on('click', '.toggle-details', function() {
      $(this).closest('tr').find('.details').toggle();
    });
  });

</script>
{{-- <script>
  $(document).ready(function() {
    // 初期状態で非表示にする
    $(".toggleable").hide();

    // クリックした行のカラムを表示/非表示にする
    $("tbody tr").click(function() {
        $(this).find(".toggleable").toggle();
    });
});
</script> --}}
@stop
