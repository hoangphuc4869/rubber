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
        Schema::table('bales', function (Blueprint $table) {
            
            // $table->dropForeign(['bales_drum_id_foreign']);
            $table->foreignId('drum_id')->nullable()->constrained('drums')->onDelete('cascade');

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