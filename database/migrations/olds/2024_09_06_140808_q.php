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

        Schema::table('delivery_dates', function (Blueprint $table) {
            $table->foreign('contract_id')->references('id')->on('contract')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::table('delivery_dates', function (Blueprint $table) {
            $table->dropForeign(['contract_id']);
        });
    }
};