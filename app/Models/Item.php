<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'detail',
        'image',
        'keyword',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    // public function tags()
    // {
    //     return $this->belongsToMany('App\Models\tag')->withTimestamps();
    // }
    // public function images()//add ImageModel紐づけ
    // {
    //     return this->hasMany(Image::class);
    // }
}
