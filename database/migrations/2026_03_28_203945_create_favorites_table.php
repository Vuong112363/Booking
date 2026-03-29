<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id(); // Khóa chính tự tăng
            
            // Cột lưu ID của người dùng (user)
            $table->unsignedBigInteger('userid');
            
            // Cột lưu ID của tour (LƯU Ý: Nếu tourid của bạn là chuỗi chữ/số thì dùng string('tour_id'), nếu là số thì dùng unsignedBigInteger('tour_id'))
            $table->string('tourid'); // Hoặc: $table->unsignedBigInteger('tour_id');

            $table->timestamps(); // Tự động tạo 2 cột created_at và updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
    }
};