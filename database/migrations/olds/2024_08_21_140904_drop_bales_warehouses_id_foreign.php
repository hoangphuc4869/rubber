<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropBalesWarehousesIdForeign extends Migration
{
    public function up()
    {
        Schema::table('bales', function (Blueprint $table) {
            $table->dropForeign(['warehouses_id']);
            $table->dropColumn('warehouses_id');
        });
    }

    public function down()
    {
        Schema::table('bales', function (Blueprint $table) {
            $table->foreignId('warehouses_id')->nullable()->constrained('warehouses')->onDelete('set null');
        });
    }
}