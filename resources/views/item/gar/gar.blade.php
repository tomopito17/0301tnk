<td>
  <button class="">管理</button>
  <div class="details"  style="display: none;">
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
    </div>
  </div>
  </div>
</td>

<script>
  $(document).ready(function() {
    $('table').on('click', '.toggle-details', function() {
        $(this).closest('tr').find('.details').toggle();
    });
  });
  </script>
  



{{-- <script>
  $(document).ready(function() {
      $('table').on('click', '.toggle-details', function() {
          $(this).closest('tr').find('.details').toggle();
      });
  });
</script> --}}

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
