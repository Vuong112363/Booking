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
    Schema::create('tbl_tour_schedules', function (Blueprint $table) {
        $table->id('schedule_id');
        $table->integer('tourid'); // Khóa ngoại liên kết với bảng tbl_tours hiện tại của bạn
        $table->date('startdate'); // Ngày đi
        $table->date('enddate');   // Ngày về
        $table->integer('quantity'); // Số lượng chỗ của chuyến này
        
        // Bạn có thể lưu giá riêng cho từng ngày (ví dụ lễ tết giá cao hơn)
        $table->integer('priceadult')->nullable(); 
        $table->integer('pricechild')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_tour_schedules');
    }
};
