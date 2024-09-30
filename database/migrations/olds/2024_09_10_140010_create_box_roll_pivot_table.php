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
        Schema::create('batch_drum', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('drum_id');
            $table->unsignedBigInteger('batch_id');
            $table->integer('bale_count'); 

            
            $table->foreign('drum_id')->references('id')->on('drums')->onDelete('cascade');
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');

            
            $table->unique(['drum_id', 'batch_id']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_drum');
    }
};