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
        Schema::table('rubber_warehouses', function (Blueprint $table) {
            $table->foreignId('curing_house_id')->nullable()->constrained('curing_houses')->onDelete('cascade');
            $table->foreignId('curing_area_id')->nullable()->constrained('curing_areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};