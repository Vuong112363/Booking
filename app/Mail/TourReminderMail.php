<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TourReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bookingDetail;

    public function __construct($bookingDetail)
    {
        $this->bookingDetail = $bookingDetail;
    }

    public function build()
    {
        return $this->subject('Nhắc nhở: Sắp đến ngày khởi hành Tour của bạn! - GoViet Tours')
                    ->view('emails.tour_reminder');
    }
}