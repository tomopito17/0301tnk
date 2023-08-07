<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Tag;

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
    public function index(Request $request)
    {
        // 商品一覧取得
        $items = Item
            ::where('items.status', 'active')
            ->select()
            ->get();
        // dd($items);

        $images = Image::get();

        if ($request->SearchWord) {
            $items = Item::where('name', 'like', '%' . $request->SearchWord . '%')->get();
            // dd($request);
        } else {
            $items = Item::all();
        }
        
        return view('item.index', [
            'items' => $items,
            'image' => $images,
            'SearchWord' =>$request->SearchWord,
        ]);

        // return view('item.index', compact('items', 'images'));
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
            $image = null;
            if ($request->image != Null) {
                $image = base64_encode(file_get_contents($request->image->getRealPath()));
            }
            // 商品登録
            Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'type' => $request->type,
                'detail' => $request->detail,
                'image' => $image,
                'keyword' => $request->keyword,
            ]);

            // $tags = Tag::pluck('name', 'id')->toArray();

            return redirect('/items');
        }

        return view('item.add');
    }

    public function delete(Request $request)
    {
        $item = Item::find($request->id);
        $item->delete();

        return redirect('items');
    }

    public function editAllocate($id)
    {
        $item = Item::find($id);

        return view('item.edit', compact('item'));
        //dd($item);
    }

    public function ItemEdit($id, Request $request)
    {
        //取得した既存レコードから編集する
        //$item = Item::find($id);
        //$item = Item::where('id','=',$request->id)
        //   ->update([
        // $image = base64_encode(file_get_contents($request->image->getRealPath()));
       $item= Item::find($id);
       $item->name=$request->name;
       $item->type=$request->type;
       $item->detail=$request->detail;
       $item->keyword=$request->keyword;
       if($request->image){
        $item->image = base64_encode(file_get_contents($request->image->getRealPath()));
       }
       $item->save();
            // update([
            //     'name' => $request->name,
            //     'type' => $request->type,
            //     'detail' => $request->detail,
            //     'image' => $image,
            //     'keyword' => $request->keyword,
            // ]);
        return redirect('/items');
    }
}