<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id(); // Tạo cột ID tự động tăng
            $table->string('name'); // Cột tên chứng chỉ
            $table->string('file_path'); // Cột đường dẫn tệp chứng chỉ
            $table->timestamps(); // Cột created_at và updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificates');
    }
}