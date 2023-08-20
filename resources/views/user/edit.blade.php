@extends('adminlte::page')

@section('title', 'ユーザ編集')

@section('content_header')
<h1>ユーザ編集</h1>
@stop

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>ユーザ情報編集</h1>
    <a href="/user">戻る</a>
    <form method="post" action="/user/update" >
        @csrf
    <table>
        <tr>
    <th>名前</th> <td><input type="text" name="name" value="{{ $user->name }}" required></td>
        </tr> 
        <tr>
            <th>メール</th> <td><input type="text" name="email" value="{{ $user->email }}" required></td>
        </tr> 
        <tr>
            <th>権限</th> 
            <td>
            <input type="radio" name="role" value="1" @if(($user->role==1)) checked @endif>ユーザ
            <input type="radio" name="role" value="2" @if($user->role==2) checked @endif>管理者
            </td>
        </tr> 
    </table>
    <input type="hidden" name="id" value="{{ $user->id }}">
    <p><input type="submit" value="編集OK"></p>
    </form>
</body>
</html>
@stop

@section('css')
@stop

@section('js')
@stop