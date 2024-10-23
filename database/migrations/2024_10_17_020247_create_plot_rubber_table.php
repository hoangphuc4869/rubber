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
        Schema::create('plot_rubber', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rubber_id');
            $table->integer('plot_id', false, true)->length(10); 
            $table->timestamps();

            
            $table->foreign('plot_id')->references('id')->on('plots')->onDelete('cascade');
            $table->foreign('rubber_id')->references('id')->on('rubber')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plot_rubber');
    }
};