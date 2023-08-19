@extends('adminlte::page')

@section('title', 'CSVファイルセット')
@section('content_header')
<h2>CSVファイルセット</h2>

@stop

@section('content')
@if(session('success') !=Null)
@dump(session('success'))
@endif
@if(session('error') !=Null)
@dump(session('error'))
{{-- {{"ファイル名○○"}} --}}
@endif
<div class="row">
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <form method="POST" action="/items/csv_upload" enctype="multipart/form-data">
    @csrf
    <input type="file" name="csv" id="fileInput">
    <button onclick="getFileName()">CSVアップロード</button>
  </form>
</div>

@stop

@section('css')
@stop

@section('js')
<script>
  function getFileName() {
    const fileInput = document.getElementById('fileInput');
    const selectedFile = fileInput.files[0];

    if (selectedFile) {
      const fileName = selectedFile.name;
      alert(`選択されたファイル名: ${fileName}`);
    } else {
      alert('ファイルが選択されていません。');
    }
  }

</script>
@stop
