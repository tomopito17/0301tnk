<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Tag;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Validator;

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
      ::with('user')
      ->where('items.status', 'active')
      ->select()
      ->get();
    // dd($items);

    $images = Image::get();
    $select = $request->input('select');
    // dump($request->select);
    if ($request->Search == "Name") {
      if ($request->SearchName && ($select == "select-name")) {
        // if ($request->SearchName) {
        $items = Item::where('name', 'like', '%' . $request->SearchName . '%')->get();
      } elseif ($request->SearchName && ($select == "select-detail")) {
        $items = Item::where('detail', 'like', '%' . $request->SearchName . '%')->get();
      }
      elseif($request->SearchName && ($select == "select-both")){
        $items = Item::where('name', 'like', '%' . $request->SearchName . '%')->orWhere('detail', 'like', '%' . $request->SearchName . '%')->get();
      }else {
         // dd($items);      
         $items = Item::all();
        //  $items = Item::paginate(5);
      }


    } elseif ($request->Search == "keyword") {
      if ($request->SearchWord) {
        if ($request->AndSearchWord && ("checked" == $request->input("checkbox"))) {
          $items = Item::where('keyword', 'like', '%' . $request->SearchWord . '%')->Where('keyword', 'like', '%' . $request->AndSearchWord . '%')->get();
          // dd($items);
        } else {
          $items = Item::where('keyword', 'like', '%' . $request->SearchWord . '%')->get();
          // dd($request);                    
        }

      } else {
        $items = Item::all();
        // $items = Item::paginate(5);
      }
    }
    else {
      $items = Item::all();
      // $items = Item::cursorpaginate(5);
    }

    return view('item.index', [
      'items' => $items,
      'image' => $images,
      'SearchName' => $request->SearchName,
      'SearchWord' => $request->SearchWord,
      'AndSearchWord' => $request->AndSearchWord,
      'count' => $count,
    ]);

    // return view('item.index', compact('items', 'images'));
  }

  public function detail($id){
    $item = Item::find($id);
    //dd($item);
    return view('item.detail',compact('item')
    //,['item' => $item,]
    );  //compact('items'));
  }

  /**
   * 商品登録
   */
  public function add(Request $request)
  {

    // POSTリクエストのとき
    if ($request->isMethod('post')) {
      // バリデーション
      // $this->validate($request, [
      //   'name' => 'required|max:100',
      $rule = [
        //バリデーションのルール
        'name' => 'required|max:100|unique:items',
        'type' => 'required',
        'url' => 'required|unique:items',
        // 'detail' => 'required|max:500',
      ];
      $msg = [
        //表示される内容
        'name.required' => '名前登録は必須です。',
        'name.max' => 'Itemの文字数は100文字以内です。',
        'name.unique' => 'その名前では登録済みです。',
        'type.required' => '種類は必須です。',
        'url.required' => 'URL登録は必須です',
        'url.unique' => 'そのURLは登録済みです。',
        // 'detail.required' => 'required|max:500',
      ];

      $request->validate($rule, $msg);


      // ]);
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
  public function csvfile_set()
  {
    return view('item.csvfile_set');
  }


  public function csv_upload(Request $request)
  {
    // dd($request);
    if ($request->hasFile('csv')) {
      if($request->csv->getClientOriginalExtension() !== "csv") {
        return redirect()->back()->with('error', '拡張子がCSVではりません');
        // throw new Exception("拡張子が不正です。");
      }
      $file = $request->file('csv');
      $csvData = file($file->getRealPath());
        
    //   $extension = $csvData->getClientOriginalExtension();
    //   if ($extension !== 'csv') {
    //     return response()->json(['error' => '無効なファイル形式です。CSVファイルのみが許可されています。'], 400);
    // }
      array_shift($csvData);// 最初の行(項目ラベルレコード)をスキップ
      foreach ($csvData as $row) {
        $data = str_getcsv($row); // CSV行を配列に変換
        //validation   
        // $validator = Validator::make($data, [
        //       1 => 'numeric', 
        //       2 => 'confirmed|required|string|max:255', 
        //       // 10 => 'url',
        // ]);
        // if ($validator->fails()) {
        //   // バリデーションに失敗した場合の処理
        //   return back()->withErrors($validator)->withInput();
        // }

        // YourModelにデータを保存
        Item::create([
          // 'id'=> $data[0],//count+++
          'user_id' => $data[1],
          'name' => $data[2],
          'status' => $data[3],
          'type' => $data[4],
          'detail' => $data[5],
          'created_at' => $data[6],
          'updated_at' => $data[7],
          'image' => $data[8],
          'keyword' => $data[9],
          'url' => $data[10]
          // 'column1' => $data[0], // CSV列に応じて適切なカラムを指定
          // 'column2' => $data[1],
          // 他のカラムも同様に指定
        ]);
      }
      return redirect()->back()->with('success', 'CSVファイルがインポートされました。');
    }
    return redirect()->back()->with('error', 'CSVファイルの値の型が正しいか確認して下さい。');

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