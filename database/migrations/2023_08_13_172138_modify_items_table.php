<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('items', function (Blueprint $table) {
            //
            $table->bigInteger('user_id')->unsigned(); //カラム追加

            $table->foreign('user_id') //外部キー制約
                 ->references('id')->on('users'); //ｕｓｅｒｓテーブルのidを参照する
                //  ->onDelete('cascade');  //ユーザーが削除されたら紐付くpostsも削除
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            //
        });
    }
}
