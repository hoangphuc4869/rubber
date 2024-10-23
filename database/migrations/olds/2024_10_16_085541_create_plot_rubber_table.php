<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlotRubberTable extends Migration
{
    public function up()
    {
        Schema::create('plot_rubber', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rubber_id')->constrained('rubber')->onDelete('cascade');
            $table->foreignId('plot_id')->constrained('plots')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plot_rubber');
    }
}