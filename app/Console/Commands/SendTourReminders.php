<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\TourReminderMail;
use Carbon\Carbon;

class SendTourReminders extends Command
{
    // Tên lệnh dùng để gọi trong Terminal
    protected $signature = 'mail:send-tour-reminders';

    // Mô tả lệnh
    protected $description = 'Quét cơ sở dữ liệu và gửi email nhắc nhở khách hàng trước ngày khởi hành 2 ngày';

    public function handle()
    {
        // 1. Tính toán ra "Ngày mốt" (sau hôm nay 2 ngày)
        $targetDate = Carbon::now()->addDays(2)->format('Y-m-d');
        
        $this->info("Đang quét các tour khởi hành vào ngày: {$targetDate}...");

        // 2. Tìm tất cả đơn hàng đã duyệt (confirmed) và có ngày đi khớp với $targetDate
        $upcomingBookings = DB::table('tbl_bookings')
            ->join('tbl_tours', 'tbl_bookings.tourid', '=', 'tbl_tours.tourid')
            ->join('tbl_users', 'tbl_bookings.userid', '=', 'tbl_users.userid')
            ->where('tbl_tours.startdate', $targetDate)
            ->where('tbl_bookings.bookingstatus', 'confirmed')
            ->select('tbl_bookings.*', 'tbl_tours.title', 'tbl_tours.startdate', 'tbl_users.email', 'tbl_users.username')
            ->get();

        if ($upcomingBookings->isEmpty()) {
            $this->info("Không có tour nào khởi hành vào ngày {$targetDate}.");
            return;
        }

        $count = 0;
        // 3. Vòng lặp gửi email cho từng khách hàng
        foreach ($upcomingBookings as $booking) {
            if (!empty($booking->email)) {
                try {
                    Mail::to($booking->email)->send(new TourReminderMail($booking));
                    $this->info("Đã gửi mail nhắc nhở cho: " . $booking->email);
                    $count++;
                } catch (\Exception $e) {
                    $this->error("Lỗi gửi mail cho {$booking->email}: " . $e->getMessage());
                }
            }
        }

        $this->info("Hoàn tất! Đã gửi thành công {$count} email nhắc nhở.");
    }
}