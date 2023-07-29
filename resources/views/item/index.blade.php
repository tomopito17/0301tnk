@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>商品一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">商品一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ url('items/add') }}" class="btn btn-default">商品登録</a>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->detail }}</td>
                                    <td>
                                        <form method="POST" action="/items/upload" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <input type="file" name="image"><button>アップロード</button>
                                        @foreach ($images as $image)                            
                                            <img src="{{ asset($image->path) }}">                             
                                        @endforeach 
                                    <td>    
                                    <td>
                                        <form action="{{url('items/delete')}}" method="POST" 
                                        onsubmit="return confirm('削除してよろしいですか？');">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <input type="submit" class="btn btn-danger" value="削除">
                                        </form>
                                    </td>
                                    <td>                                       
                                        <a href="{{ url('items/edit/' . $item->id) }}" class="btn btn-info">編集</a>                                  
                                        <!-- <a href="{{url('items/edit/' . $item->id)}}">編集</a> -->                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>                        
                    </table>
                    <!-- @foreach ($images as $image)                            
                       <img src="{{ asset($image->path) }}">                             
                    @endforeach -->
                </div>
            </div>
        </div>
    </div>
    <!-- <form method="POST" action="/items/upload" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image">
    <button>アップロード</button> -->
</form>
@stop

@section('css')
@stop

@section('js')
@stop
