<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachiningsTable extends Migration
{
    public function up()
    {
        Schema::table('drums', function (Blueprint $table) {
            // $table->id(); 
            // $table->unsignedBigInteger('rolling_code'); 

            // $table->unsignedTinyInteger('status')->default(0); 
            
            // $table->string('code'); 
            // $table->string('name'); 
            // $table->date('ngay'); 
            // $table->time('gio'); 

           
            $table->foreign('rolling_code')
                  ->references('id')
                  ->on('rubber_warehouses')
                  ->onDelete('cascade');

            // $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('drums', function (Blueprint $table) {
            $table->dropForeign(['rolling_code']);
        });

        Schema::dropIfExists('drums');
    }
}