<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'path',
        'item_id',
      ];
    //イメージ画像を保持する商品の取得
    
    public function item()
    {
        return$this->belongsTo(Item::class);
    }
}
