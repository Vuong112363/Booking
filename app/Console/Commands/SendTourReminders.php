<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\TourReminderMail;
use Carbon\Carbon;

class SendTourReminders extends Command
{
    protected $signature = 'mail:send-tour-reminders';
    protected $description = 'Gửi email nhắc nhở khách hàng trước ngày khởi hành 2 ngày';

    public function handle()
    {
        // 1. Lấy ngày mục tiêu (sau đây 2 ngày)
        $targetDate = Carbon::now()->addDays(2)->toDateString();
        
        // 2. Lấy thông tin Settings để truyền vào footer email
        $settings = DB::table('settings')->pluck('value', 'key');

        // 3. Truy vấn đơn hàng: Kết nối Lịch trình và Điểm đón
        $upcomingBookings = DB::table('tbl_bookings')
            ->join('tbl_tour_schedules', 'tbl_bookings.schedule_id', '=', 'tbl_tour_schedules.schedule_id')
            ->join('tbl_tours', 'tbl_bookings.tourid', '=', 'tbl_tours.tourid')
            ->join('tbl_users', 'tbl_bookings.userid', '=', 'tbl_users.userid')
            ->leftJoin('tbl_tour_pickups', 'tbl_bookings.pickup_id', '=', 'tbl_tour_pickups.pickup_id') // Lấy điểm đón
            ->where('tbl_tour_schedules.startdate', $targetDate)
            ->where('tbl_bookings.bookingstatus', 'confirmed')
            ->select(
                'tbl_bookings.*', 
                'tbl_tours.title', 
                'tbl_tour_schedules.startdate', 
                'tbl_tour_schedules.enddate',
                'tbl_users.email', 
                'tbl_users.username',
                'tbl_tour_pickups.pickup_name',
                'tbl_tour_pickups.pickup_time'
            )
            ->get();

        if ($upcomingBookings->isEmpty()) {
            $this->info("Không có tour nào khởi hành vào ngày {$targetDate}.");
            return;
        }

        foreach ($upcomingBookings as $booking) {
            try {
                // Gửi mail và truyền kèm cả biến settings
                Mail::to($booking->email)->send(new TourReminderMail($booking, $settings));
                $this->info("Đã gửi nhắc nhở cho: " . $booking->email);
            } catch (\Exception $e) {
                $this->error("Lỗi gửi mail: " . $e->getMessage());
            }
        }

        $this->info("Hoàn tất gửi nhắc nhở!");
    }
}