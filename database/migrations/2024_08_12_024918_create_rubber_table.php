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
        Schema::create('rubber', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('status');
            $table->unsignedBigInteger('truck_id')->nullable(); 
            $table->unsignedBigInteger('farm_id')->nullable(); 
            $table->unsignedBigInteger('receiving_place_id')->nullable(); 
            $table->string('latex_type');
            $table->string('material_age');
            $table->float('fresh_weight', 8, 3);
            $table->float('drc_percentage', 4, 2);
            $table->float('dry_weight', 8, 3);
            $table->unsignedInteger('material_condition');
            $table->string('impurity_type');
            $table->string('grade');
            $table->timestamps();

            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('set null');
            $table->foreign('farm_id')->references('id')->on('farms')->onDelete('set null');
            $table->foreign('receiving_place_id')->references('id')->on('curing_areas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rubber');
    }
};