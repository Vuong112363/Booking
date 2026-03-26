<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Admin\Setting;

class TourReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bookingDetail;
    public $settings;

    public function __construct($bookingDetail, $settings)
    {
        $this->bookingDetail = $bookingDetail;
    $this->settings = $settings;
    }

    public function build()
    {
        return $this->subject('Nhắc nhở: Sắp đến ngày khởi hành Tour của bạn! - GoViet Tours')
                    ->view('emails.tour_reminder');
    }
}