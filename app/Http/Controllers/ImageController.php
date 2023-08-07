<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Image;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        // ディレクトリ名
        $dir = 'imageFolda';

        // アップロードされたファイル名を取得
        $file_name = $request->file('image')->getClientOriginalName();

        // 取得したファイル名で保存
        $request->file('image')->storeAs('public/' . $dir, $file_name);

        // ファイル情報をDBに保存
        $image = new Image();
        $image->name = $file_name;
        $image->path = 'storage/' . $dir . '/' . $file_name;
       // $image->item_id = $request->id;
        $image->save();
        //$images = $request->items()->get(); //itemsと画像を紐づけ

        return redirect('/');
    }


}