<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('plot_rubber', function (Blueprint $table) {
           
            $table->foreign('rubber_id')->references('id')->on('rubber')->onDelete('cascade');
            $table->foreign('plot_id')->references('id')->on('plots')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('plot_rubber');
    }
};