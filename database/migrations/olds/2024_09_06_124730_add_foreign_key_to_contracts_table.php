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
        Schema::table('contract', function (Blueprint $table) {
            $table->foreign('contract_type_id')->references('id')->on('contract_type')->onDelete('set null');
        });

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contract', function (Blueprint $table) {
            $table->dropForeign(['contract_type_id']);
        });
    }
};