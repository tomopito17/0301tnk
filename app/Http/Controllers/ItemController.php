<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 商品一覧
     */
    public function index()
    {
        // 商品一覧取得
        $items = Item
            ::where('items.status', 'active')
            ->select()
            ->get();

        $images = Image
            ::get(); 

        return view('item.index', compact('items','images'));
    }

    /**
     * 商品登録
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
            ]);

            // 商品登録
            Item::create([
                'Item_id' => Auth::Item()->id,
                'name' => $request->name,
                'type' => $request->type,
                'detail' => $request->detail,
            ]);

            return redirect('/items');
        }

        return view('item.add');
    }

    public function delete(Request $request)
    {
        $item = Item::find($request->id);
        $item -> delete();
        
        return redirect('items');
    }

    public function editAllocate($id,Request $request){
    $item = Item::find($id);
    return view('item.edit',compact('item'));
    //dd($item);
  }

  public function ItemEdit($id,Request $request){
    //取得した既存レコードから編集する
    //$item = Item::find($id);
    //$item = Item::where('id','=',$request->id)
    //   ->update([
    Item::where('id','=',$request->id)->
      update([
        'name' => $request->name,
        'type' => $request->type,
        'detail' => $request->detail,
      ]);
    return redirect('/items');
    }
}
