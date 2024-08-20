<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bales', function (Blueprint $table) {
            $table->id();
            
            $table->integer('press_temperature')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('cut_check')->nullable(); 
            $table->string('evaluation')->nullable(); 
            $table->string('expected_grade')->nullable(); 
            $table->integer('sample_cut_number')->nullable(); 
            $table->string('packaging_type')->nullable(); 
            $table->string('storage_location')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bales');
    }
};