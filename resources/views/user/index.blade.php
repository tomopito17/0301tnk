@extends('adminlte::page')

@section('title', 'ユーザ一覧')

@section('content_header')
<h1>ユーザー一覧</h1>
@stop

@section('content')

<div class="card-body table-responsive p-0">
  <table class="table table-hover text-nowrap">
    <thead>
      <tr>
        <th>ID</th>
        <th>名前</th>
        <th>メール</th>
        <th>権限</th>
        <th>更新日時</th>
        <th>編集</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
      <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>@if($user->role==1) 利用者 @else 管理者 @endif </td>
        <td>{{ $user->updated_at }}</td>
        <td><a href="/user/edit/{{ $user->id }}">編集</a></td>
      </tr>
      @endforeach
    <tbody>
  </table>
</div>
@stop

@section('css')
@stop

@section('js')
@stop