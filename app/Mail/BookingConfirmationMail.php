<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bookingDetail;

    public function __construct($bookingDetail)
    {
        $this->bookingDetail = $bookingDetail;
    }
// File: app/Mail/BookingConfirmationMail.php

public function build()
{
    $id = $this->bookingDetail->bookingid;
    
    // ƯU TIÊN KIỂM TRA TRẠNG THÁI HỦY TRƯỚC
    if ($this->bookingDetail->bookingstatus === 'cancelled') {
        $subject = "Xác nhận Hủy đơn đặt Tour - #$id";
        return $this->subject($subject)
                    ->view('emails.booking_confirmation');
    }

    // NẾU KHÔNG HỦY THÌ MỚI XÉT CÁC TRẠNG THÁI THANH TOÁN
    switch ($this->bookingDetail->paymentstatus) {
        case 'deposit_paid': 
            $subject = "Xác nhận thanh toán cọc thành công - #$id"; 
            break;
        case 'paid': 
            $subject = "Xác nhận đã thanh toán 100% - #$id"; 
            break;
        default: 
            $subject = "Xác nhận đặt đơn thành công - #$id"; 
            break;
    }

    return $this->subject($subject)->view('emails.booking_confirmation');
}
}