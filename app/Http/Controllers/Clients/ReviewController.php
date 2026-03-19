<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clients\Review;
use Illuminate\Support\Facades\DB; // Thêm thư viện DB để truy vấn bảng booking

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate dữ liệu đầu vào
        $request->validate([
            'tourid' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required'
        ]);

        $userId = session('userid');
        $tourId = $request->tourid;

        // 2. Kiểm tra xem người dùng đã đặt tour này chưa
        // LƯU Ý: Thay 'tbl_bookings', 'userid', 'tourid' bằng tên bảng/cột thực tế của bạn
        $hasBooked = DB::table('tbl_bookings')
            ->where('userid', $userId)
            ->where('tourid', $tourId)
            // ->where('status', 'Thành công') // (Khuyên dùng) Chỉ cho đánh giá khi đơn hàng đã hoàn tất
            ->exists();

        if (!$hasBooked) {
            return back()->with('error', 'Bạn phải đặt và trải nghiệm tour này mới có thể đánh giá.');
        }

        // 3. (Tùy chọn thêm) Kiểm tra xem người dùng đã đánh giá tour này chưa
        $hasReviewed = Review::where('userid', $userId)
            ->where('tourid', $tourId)
            ->exists();

        if ($hasReviewed) {
            return back()->with('error', 'Bạn đã đánh giá tour này rồi. Cảm ơn bạn!');
        }

        // 4. Nếu thỏa mãn mọi điều kiện, tiến hành lưu đánh giá
        Review::create([
            'tourid' => $tourId,
            'userid' => $userId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'createdat' => now()
        ]);

        return back()->with('success', 'Đánh giá thành công! Cảm ơn bạn đã góp ý.');
    }
}