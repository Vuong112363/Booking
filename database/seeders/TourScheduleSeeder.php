<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TourScheduleSeeder extends Seeder
{
    public function run()
    {
        // Thêm 3 lịch trình mẫu cho tourid = 23
        $schedules = [
            [
                'tourid' => 23,
                'startdate' => Carbon::now()->addDays(5)->toDateString(), // Khởi hành sau 5 ngày
                'enddate' => Carbon::now()->addDays(8)->toDateString(),
                'quantity' => 20, // Chỗ trống dồi dào
                'priceadult' => 2500000,
                'pricechild' => 1500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tourid' => 23,
                'startdate' => Carbon::now()->addDays(15)->toDateString(), // Khởi hành sau 15 ngày
                'enddate' => Carbon::now()->addDays(18)->toDateString(),
                'quantity' => 3, // Sắp hết chỗ
                'priceadult' => 3500000, // Thử tăng giá vào ngày này (ví dụ giá lễ tết)
                'pricechild' => 2000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tourid' => 23,
                'startdate' => Carbon::now()->subDays(2)->toDateString(), // Đã khởi hành cách đây 2 ngày
                'enddate' => Carbon::now()->addDays(1)->toDateString(),
                'quantity' => 10,
                'priceadult' => 2500000,
                'pricechild' => 1500000,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('tbl_tour_schedules')->insert($schedules);
    }
}