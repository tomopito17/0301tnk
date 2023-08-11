<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Tag;
use Rap2hpoutre\FastExcel\FastExcel;

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
    //Itemカウント
    $count = Item::count();  
    // 商品一覧取得
    $items = Item
      ::where('items.status', 'active')
      ->select()
      ->get();
    // dd($items);

    $images = Image::get();

    if ($request->SearchWord) {
      if ($request->AndSearchWord && ( "checked" == $request->input("checkbox")) ) {
        $items= Item::where('keyword','like', '%'.$request->SearchWord.'%' )->Where('keyword','like', '%'.$request->AndSearchWord.'%' )->get();
        // dd($items);
      } else {
        $items = Item::where('keyword', 'like', '%' . $request->SearchWord . '%')->get();
        // dd($request);                    
      }

    } else {
      $items = Item::all();
    }


    return view('item.index', [
      'items' => $items,
      'image' => $images,
      'SearchWord' => $request->SearchWord,
      'AndSearchWord' => $request->AndSearchWord,
      'count' => $count,
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
        'url' => $request->url,
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
    $item = Item::find($id);
    $item->name = $request->name;
    $item->url = $request->url;
    $item->type = $request->type;
    $item->detail = $request->detail;
    $item->keyword = $request->keyword;
    if ($request->image) {
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

  public function csv_upload(Request $request)
  {
    if ($request->hasFile('csv')) {
      $file = $request->file('csv');
      $csvData = file($file->getRealPath());

    // $path = 'storage/app/'.$request->csv->store('csv');
    // $collection = fastexcel()->import($path);
    // $realpath = $request->csv->getRealPath();
    // $collection = (new FastExcel)->import($path);
    // dd($collection);
    // $collection = (new FastExcel)->configureCsv(';', '#', 'gbk')->import('file.csv');
    // $Items = (new FastExcel)->import('file.xlsx', function ($line) {}
      array_shift($csvData);// 最初の行(項目ラベルレコード)をスキップ
      //dd($csvData);
      foreach ($csvData as $item) {
        $data = str_getcsv($item); // CSV行を配列に変換

        // YourModelにデータを保存
        Item::create([
          // 'id'=> $data[0],//count+++
          'user_id' => $data[1],
          'name' => $data[2],
          'status'=> $data[3],
          'type' => $data[4],
          'detail' => $data[5],
          'created_at' => $data[6],
          'updated_at' => $data[7],
          'image' =>  $data[8],
          'keyword' => $data[9],
          'url' => $data[10]
          // 'column1' => $data[0], // CSV列に応じて適切なカラムを指定
          // 'column2' => $data[1],
          // 他のカラムも同様に指定
        ]);
      }
      return redirect()->back()->with('success', 'CSVファイルがインポートされました。');
    }
    return redirect()->back()->with('error', 'CSVファイルがアップロードされていません。');
  }
  //     return Item::create([
  //         'user_id' => Auth::user()->id,
  //         'name' => $line['name'],
  //         'type' => $request->type,
  //         'detail' => $request->detail,
  //         'image' => $image,
  //         'keyword' => $request->keyword,
  //     ]);
  // };
 
}