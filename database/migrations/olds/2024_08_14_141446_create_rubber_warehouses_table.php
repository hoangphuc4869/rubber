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
        Schema::create('rubber_warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('curing_house');
            $table->string('curing_area');
            $table->string('rubbers'); 
            $table->date('date')->nullable();
            $table->time('time')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rubber_warehouses');
    }
};