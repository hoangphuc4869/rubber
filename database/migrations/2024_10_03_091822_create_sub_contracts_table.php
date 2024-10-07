<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Schema::create('sub_contracts', function (Blueprint $table) {
        //     $table->id(); // Khóa chính
        //     $table->unsignedBigInteger('contract_id'); // Khóa ngoại liên kết với bảng contracts
        //     $table->unsignedInteger('contract_type_id')->nullable(); // Giống bảng contracts
        //     $table->string('so_ngay_hd')->nullable(); // Giống bảng contracts
        //     $table->string('contract_number', 50)->nullable(); // Giống bảng contracts
        //     $table->string('count_contract', 191)->nullable(); // Giống bảng contracts
        //     $table->date('contract_date')->nullable(); // Giống bảng contracts
        //     $table->string('thang_giao_hang', 255)->nullable(); // Giống bảng contracts
        //     $table->unsignedInteger('customer_id')->nullable(); // Giống bảng contracts
        //     $table->float('so_luong')->nullable(); // Giống bảng contracts
        //     $table->string('san_pham', 50)->nullable(); // Giống bảng contracts
        //     $table->date('ngay_giao_hang')->nullable(); // Giống bảng contracts
        //     $table->date('ngay_dong_cont')->nullable(); // Giống bảng contracts
        //     $table->string('loai_pallet', 255)->nullable(); // Giống bảng contracts
        //     $table->string('lenh_xuat_hang', 255)->nullable(); // Giống bảng contracts
        //     $table->string('thi_truong', 255)->nullable(); // Giống bảng contracts
        //     $table->string('don_vi_xuat_thuong_mai', 255)->nullable(); // Giống bảng contracts
        //     $table->string('supplier', 191)->nullable(); // Giống bảng contracts
        //     $table->string('ban_cho_ben_thu_3', 255)->nullable(); // Giống bảng contracts
        //     $table->text('trang_thai')->default('Chưa thanh toán'); // Giống bảng contracts

        //     $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
        //     $table->timestamps(); // Tự động tạo created_at và updated_at
        // });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_contracts');
    }
};