<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bookingDetail;
    public $settings;

    /**
     * Khởi tạo class mail
     * @param object $bookingDetail Dữ liệu booking đã được Join đầy đủ từ Controller
     */
    public function __construct($bookingDetail)
    {
        $this->bookingDetail = $bookingDetail;
        
        // Tự động lấy cấu hình từ bảng settings để hiển thị ở Footer
        $this->settings = DB::table('settings')->pluck('value', 'key')->toArray();
    }

    /**
     * Xây dựng nội dung Email
     */
    public function build()
    {
        $id = $this->bookingDetail->bookingid;
        $siteName = $this->settings['site_name'] ?? 'GoViet Travel';

        // Tự động xác định Tiêu đề Email dựa trên trạng thái thực tế
        if ($this->bookingDetail->bookingstatus === 'cancelled') {
            $subject = "🔔 [Thông báo] Hủy đơn đặt Tour #$id - $siteName";
        } else {
            $subject = match($this->bookingDetail->paymentstatus) {
                'paid'         => "✅ [Xác nhận] Đã thanh toán 100% đơn #$id - $siteName",
                'deposit_paid' => "💳 [Xác nhận] Đã nhận tiền đặt cọc đơn #$id - $siteName",
                'refund_pending' => "💰 [Thông báo] Đang xử lý hoàn tiền đơn #$id",
                default        => "📨 [Xác nhận] Đơn đặt Tour mới #$id - $siteName",
            };
        }

        return $this->subject($subject)
                    ->view('emails.booking_confirmation');
    }
}