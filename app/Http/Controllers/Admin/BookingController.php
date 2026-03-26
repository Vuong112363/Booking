<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\BookingConfirmationMail;

class BookingController extends Controller
{
    /**
     * Hiển thị danh sách tất cả booking với đầy đủ bộ lọc
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'tour', 'schedule']);

        // 1. Lọc theo từ khóa (ID, Tên user, Email, Tên tour)
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('bookingid', $keyword)
                  ->orWhereHas('user', function($u) use ($keyword) {
                      $u->where('username', 'like', '%' . $keyword . '%')
                        ->orWhere('email', 'like', '%' . $keyword . '%');
                  })
                  ->orWhereHas('tour', function($t) use ($keyword) {
                      $t->where('title', 'like', '%' . $keyword . '%');
                  });
            });
        }

        // 2. Lọc theo trạng thái đặt chỗ
        if ($request->filled('status')) {
            $query->where('bookingstatus', $request->status);
        }

        // 3. Lọc theo ngày đặt đơn
        if ($request->filled('date')) {
            $query->whereDate('bookingdate', $request->date);
        }

        // 4. Lọc theo ngày khởi hành của Tour
        if ($request->filled('start_date')) {
            $query->whereHas('schedule', function($q) use ($request) {
                $q->whereDate('startdate', $request->start_date);
            });
        }

        $bookings = $query->orderBy('bookingid', 'desc')->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Xem chi tiết một booking
     */
    public function show($id)
    {
        $booking = Booking::with(['user', 'tour', 'schedule'])->findOrFail($id);
        // Lấy số tiền hoàn trả đã chốt trong Database
        $refundAmount = $booking->refund_amount ?? 0;
   
        return view('admin.bookings.show', compact('booking', 'refundAmount'));
    }

    /**
     * Xác nhận thu tiền mặt 100% tại quầy
     */
    public function confirmCash($id)
    {
        try {
            DB::beginTransaction();
            
            $booking = DB::table('tbl_bookings')
                ->join('tbl_users', 'tbl_bookings.userid', '=', 'tbl_users.userid')
                ->where('bookingid', $id)
                ->select('tbl_bookings.*', 'tbl_users.email', 'tbl_users.username')
                ->first();

            if (!$booking) return back()->with('error', 'Không tìm thấy đơn hàng.');

            // Cập nhật trạng thái thanh toán đủ
            DB::table('tbl_bookings')->where('bookingid', $id)->update([
                'paymentstatus' => 'paid',
                'paid_amount'   => $booking->totalprice,
                'bookingstatus' => 'confirmed',
                'paymentmethod' => 'Cash'
            ]);

            // Tạo hóa đơn
            $this->autoCreateInvoice($id, $booking->email);

            // Gửi mail xác nhận
            $this->sendBookingEmail($id);

            // Ghi lịch sử hệ thống
            DB::table('tbl_history')->insert([
                'userid'     => Auth::id() ?? session('userid'),
                'actionType' => "Admin xác nhận thu tiền mặt 100% đơn #$id",
                'timestamp'  => now()
            ]);

            DB::commit();
            return back()->with('success', 'Xác nhận thu tiền mặt và gửi mail thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi confirmCash: " . $e->getMessage());
            return back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    /**
     * Cập nhật trạng thái booking thủ công qua form
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'bookingstatus' => 'required|in:pending,confirmed,completed,cancelled',
            'paymentstatus' => 'required|in:unpaid,deposit_paid,paid,refund_pending,refunded'
        ]);

        $booking = Booking::with(['user', 'tour'])->findOrFail($id);
        
        $oldPaymentStatus = $booking->paymentstatus;
        $newStatus = $request->bookingstatus;
        $newPaymentStatus = $request->paymentstatus;

        $isFirstTimePaid = ($newPaymentStatus == 'paid' && $oldPaymentStatus != 'paid');

        // Xử lý tiền thực thu
        if ($newPaymentStatus == 'paid') {
            $booking->paid_amount = $booking->totalprice; 
        } elseif ($newPaymentStatus == 'deposit_paid' && $oldPaymentStatus == 'unpaid') {
            $booking->paid_amount = $booking->deposit_amount > 0 ? $booking->deposit_amount : ($booking->totalprice * 0.3);
        } elseif ($newPaymentStatus == 'unpaid') {
            $booking->paid_amount = 0; 
        }

        $booking->bookingstatus = $newStatus;
        $booking->paymentstatus = $newPaymentStatus;
        $booking->save();

        // Tự động tạo hóa đơn và gửi mail nếu vừa chuyển sang 'paid'
        if ($isFirstTimePaid) {
            $this->autoCreateInvoice($id, $booking->user->email ?? $booking->email);
            $this->sendBookingEmail($id);
        }

        // Gửi mail nếu chuyển trạng thái hoàn tiền thành công hoặc xác nhận đơn
        if ($newPaymentStatus == 'refunded' || ($newStatus == 'confirmed' && $oldPaymentStatus == 'unpaid')) {
            $this->sendBookingEmail($id);
        }

        // Ghi lại lịch sử hệ thống
        History::create([
            'userid' => Auth::id() ?? 1,
            'actionType' => "Cập nhật đơn #$id: Trạng thái $newStatus, Thanh toán $newPaymentStatus",
            'timestamp' => now()
        ]);

        return redirect()->route('admin.bookings.show', $id)->with('success', 'Đã cập nhật trạng thái đơn hàng thành công!');
    }

    // ==========================================
    // CÁC HÀM PHỤ TRỢ (PRIVATE METHODS)
    // ==========================================

    /**
     * Tự động tạo hóa đơn vào bảng tbl_invoice
     */
    private function autoCreateInvoice($bookingId, $customerEmail) {
        $booking = DB::table('tbl_bookings')->where('bookingid', $bookingId)->first();
        if ($booking) {
            $exists = DB::table('tbl_invoice')->where('bookingid', $bookingId)->exists();
            if (!$exists) {
                $tour = DB::table('tbl_tours')->where('tourid', $booking->tourid)->first();
                DB::table('tbl_invoice')->insert([
                    'bookingid'   => $bookingId,
                    'userid'      => $booking->userid,
                    'email'       => $customerEmail ?? 'khachhang@gmail.com',
                    'detelssued'  => now(), // Tên cột chính xác từ SQL của bạn
                    'totalamount' => $booking->totalprice,
                    'detail'      => 'Hóa đơn thanh toán cho Tour: ' . ($tour->title ?? "#$bookingId")
                ]);
            }
        }
    }

    /**
     * Truy vấn dữ liệu đầy đủ và gửi Email cho khách hàng
     */
    private function sendBookingEmail($bookingId) {
        try {
            $bookingDetail = DB::table('tbl_bookings as b')
                ->join('tbl_tours as t', 'b.tourid', '=', 't.tourid')
                ->join('tbl_users as u', 'b.userid', '=', 'u.userid')
                ->leftJoin('tbl_tour_schedules as s', 'b.schedule_id', '=', 's.schedule_id')
                ->leftJoin('tbl_tour_pickups as p', 'b.pickup_id', '=', 'p.pickup_id')
                ->where('b.bookingid', $bookingId)
                ->select(
                    'b.*', 'u.username', 'u.email', 't.title', 
                    's.startdate', 's.enddate', 
                    'p.pickup_name', 'p.pickup_time'
                )
                ->first();

            if ($bookingDetail && $bookingDetail->email) {
                Mail::to($bookingDetail->email)->send(new BookingConfirmationMail($bookingDetail));
            }
        } catch (\Exception $e) {
            Log::error("Lỗi gửi mail đơn hàng #$bookingId tại Admin: " . $e->getMessage());
        }
    }
}