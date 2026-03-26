<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
  
    // Tìm hóa đơn dựa trên bookingid
    public function exportPDF($bookingid)
{
    // 1. Lấy dữ liệu Booking chi tiết (Join với Schedule để lấy startdate tránh lỗi Log)
    $booking = DB::table('tbl_bookings')
        ->join('tbl_tours', 'tbl_bookings.tourid', '=', 'tbl_tours.tourid')
        ->leftJoin('tbl_tour_schedules', 'tbl_bookings.schedule_id', '=', 'tbl_tour_schedules.schedule_id')
        ->leftJoin('tbl_tour_pickups', 'tbl_bookings.pickup_id', '=', 'tbl_tour_pickups.pickup_id')
        ->where('tbl_bookings.bookingid', $bookingid)
        ->select(
            'tbl_bookings.*', 
            'tbl_tours.title', 
            'tbl_tour_schedules.startdate',
            'tbl_tour_pickups.pickup_name'
        )
        ->first();

    if (!$booking) return back()->with('error', 'Không tìm thấy đơn hàng.');

    // 2. Tự động tạo hóa đơn vào tbl_invoice nếu chưa tồn tại (Dành cho đơn đã thanh toán)
    $invoice = DB::table('tbl_invoice')->where('bookingid', $bookingid)->first();
    
    if (!$invoice && ($booking->paymentstatus == 'paid' || $booking->paymentstatus == 'deposit_paid')) {
        $invoiceId = DB::table('tbl_invoice')->insertGetId([
            'bookingid'   => $booking->bookingid,
            'userid'      => $booking->userid,
            'email'       => $booking->email ?? session('email'),
            'detelssued'  => now(),
            'totalamount' => $booking->totalprice,
            'detail'      => 'Hóa đơn Tour: ' . $booking->title
        ]);
        $invoice = DB::table('tbl_invoice')->where('invoiceid', $invoiceId)->first();
    }

    if (!$invoice) return back()->with('error', 'Đơn hàng chưa được thanh toán để xuất hóa đơn.');

    // 3. Chuẩn bị dữ liệu cho View PDF
    $data = [
        'invoice' => $invoice,
        'booking' => $booking
    ];

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('Invoice.invoice-pdf', $data)
              ->setPaper('a4', 'portrait');

    return $pdf->download('Invoice-GoViet-' . $bookingid . '.pdf');
}
}
