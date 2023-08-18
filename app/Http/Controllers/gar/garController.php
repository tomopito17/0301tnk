public function csv_upload(Request $request)
  {
    // dd($request);
    if ($request->hasFile('csv')) {
      $file = $request->file('csv');
      $csvData = file($file->getRealPath());

      
    //   $extension = $csvData->getClientOriginalExtension();
    //   if ($extension !== 'csv') {
    //     return response()->json(['error' => '無効なファイル形式です。CSVファイルのみが許可されています。'], 400);
    // }

      // $path = 'storage/app/'.$request->csv->store('csv');
      // $collection = fastexcel()->import($path);
      // $realpath = $request->csv->getRealPath();
      // $collection = (new FastExcel)->import($path);
      // dd($collection);
      // $collection = (new FastExcel)->configureCsv(';', '#', 'gbk')->import('file.csv');
      // $Items = (new FastExcel)->import('file.xlsx', function ($line) {}
      array_shift($csvData); // 最初の行(項目ラベルレコード)をスキップ
      // dd($csvData);
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