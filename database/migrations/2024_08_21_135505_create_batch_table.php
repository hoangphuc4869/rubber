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
        Schema::create('batch', function (Blueprint $table) {
           
            $table->id();
            
            $table->string('expected_grade')->nullable(); 
            $table->integer('sample_cut_number')->nullable(); 
            $table->string('packaging_type')->nullable(); 
            $table->string('storage_location')->nullable();

            $table->timestamps();
        
        });


        Schema::table('drums', function (Blueprint $table) {
           
            $table->foreignId('batch_id')->nullable()->constrained('batch')->onDelete('set null');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch');
    }
};