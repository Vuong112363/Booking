<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail; // Thêm thư viện Mail
use App\Mail\BookingConfirmationMail;


class BookingController extends Controller
{
    // Hiển thị danh sách tất cả booking
public function index(Request $request)
    {
        // Khởi tạo query ban đầu với Eager Loading
        $query = Booking::with(['user', 'tour']);

        // 1. Lọc theo từ khóa (ID, Tên user, Tên tour)
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

        // 2. Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('bookingstatus', $request->status);
        }

        // 3. Lọc theo ngày đặt
        if ($request->filled('date')) {
            $query->whereDate('bookingdate', $request->date);
        }

        // Thực thi query, sắp xếp mới nhất lên đầu và phân trang
        $bookings = $query->orderBy('bookingid', 'desc')->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }
    // Xem chi tiết một booking
    public function show($id)
    {
        $booking = Booking::with(['user', 'tour'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    // Cập nhật trạng thái booking (Duyệt / Hủy)
 // Cập nhật trạng thái booking (Duyệt / Hủy / Thanh toán)
    public function updateStatus(Request $request, $id)
    {
        // Thêm validate cho paymentstatus
        $request->validate([
            'bookingstatus' => 'required|in:pending,confirmed,cancelled',
            'paymentstatus' => 'required|in:unpaid,deposit_paid,paid,refund_pending'
        ]);

        $booking = Booking::findOrFail($id);
        
        $newStatus = $request->bookingstatus;
        $newPaymentStatus = $request->paymentstatus;

        // ========================================================
        // 1. DÒNG NÀY RẤT QUAN TRỌNG: Khai báo cờ trước khi cập nhật
        // ========================================================
        $isFirstTimePaid = ($newPaymentStatus == 'paid' && $booking->paymentstatus != 'paid');

        // 2. Xử lý tự động tính tiền
        if ($newPaymentStatus == 'paid') {
            $booking->paid_amount = $booking->totalprice; // Thu đủ 100%
        } elseif ($newPaymentStatus == 'deposit_paid' && $booking->paymentstatus == 'unpaid') {
            $booking->paid_amount = $booking->deposit_amount > 0 ? $booking->deposit_amount : ($booking->totalprice * 0.3); // Mới thu cọc
        } elseif ($newPaymentStatus == 'unpaid') {
            $booking->paid_amount = 0; // Đưa về chưa thanh toán
        }

        // 3. Cập nhật Database
        $booking->bookingstatus = $newStatus;
        $booking->paymentstatus = $newPaymentStatus;
        $booking->save();

        // 4. --- CODE GỬI MAIL BÁO ĐÃ THU ĐỦ 100% ---
        if ($isFirstTimePaid) {
            try {
                // Lấy thông tin chi tiết để truyền vào template Mail
                $bookingDetail = \Illuminate\Support\Facades\DB::table('tbl_bookings')
                    ->join('tbl_tours', 'tbl_bookings.tourid', '=', 'tbl_tours.tourid')
                    ->join('tbl_users', 'tbl_bookings.userid', '=', 'tbl_users.userid')
                    ->where('tbl_bookings.bookingid', $id)
                    ->select('tbl_bookings.*', 'tbl_tours.title', 'tbl_tours.startdate', 'tbl_users.email', 'tbl_users.username')
                    ->first();

                if($bookingDetail && $bookingDetail->email) {
                    \Illuminate\Support\Facades\Mail::to($bookingDetail->email)->send(new \App\Mail\BookingConfirmationMail($bookingDetail)); 
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Lỗi gửi mail thanh toán 100% (Admin): " . $e->getMessage());
            }
        }
        // ----------------------------------------

        // 5. Ghi lại lịch sử hệ thống
        $adminId = \Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->userid : 3; 
        
        $actionText = "Admin cập nhật Booking ID: {$booking->bookingid} | Tour: " . strtoupper($newStatus) . " | Thanh toán: " . strtoupper($newPaymentStatus);
        
        $history = new History();
        $history->userid = $adminId; 
        $history->actionType = $actionText;
        $history->save();

        return redirect()->route('admin.bookings.show', $id)->with('success', 'Đã cập nhật trạng thái đơn và thanh toán thành công!');
    }
}