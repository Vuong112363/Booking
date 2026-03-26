<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\clients\Tours;
use App\Models\Clients\Review;
use Illuminate\Support\Facades\DB;
use App\Models\Clients\TourSchedule; // Import thư viện DB
use Illuminate\Http\Request;

class TourDetailController extends Controller
{
    private $tours;

    public function __construct()
    {
        $this->tours = new Tours();
    }

    public function index($id = 0)
    {
        $title = "Chi tiết tours - " . $id;

        // 1. Lấy chi tiết tour
        $tourDetail = $this->tours->getTourDetail($id);
$schedules = TourSchedule::where('tourid', $id)
            ->whereDate('startdate', '>=', now()) // Bỏ qua các ngày đã qua
            ->where('quantity', '>', 0) // Chỉ lấy những ngày còn chỗ trống
            ->orderBy('startdate', 'asc')
            ->get();
        // 2. Lấy dữ liệu Đánh giá & Thống kê sao
$reviews = Review::with('user')
                 ->where('tourid', $id)
                 ->where('status', 1) // CHỈ LẤY ĐÁNH GIÁ ĐƯỢC DUYỆT (HIỆN)
                 ->orderBy('createdat', 'desc')
                 ->get();
        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? round($reviews->avg('rating'), 1) : 0;

        $ratingCounts = [
            5 => $reviews->where('rating', 5)->count(),
            4 => $reviews->where('rating', 4)->count(),
            3 => $reviews->where('rating', 3)->count(),
            2 => $reviews->where('rating', 2)->count(),
            1 => $reviews->where('rating', 1)->count(),
        ];

        $ratingPercentages = [];
        foreach ($ratingCounts as $stars => $count) {
            $ratingPercentages[$stars] = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        }

        // 3. Kiểm tra User đã đăng nhập và ĐÃ ĐẶT TOUR CHƯA
        $hasBooked = false;
        if (session()->has('userid')) {
            $hasBooked = DB::table('tbl_bookings')
                ->where('userid', session('userid'))
                ->where('tourid', $id)
                // ->where('status', 'Thành công') // Mở comment dòng này nếu bảng có cột trạng thái
                ->exists();
        }

        return view('clients.tour-detail', compact(
            'title', 
            'tourDetail', 
            'reviews', 
            'totalReviews', 
            'averageRating', 
            'ratingCounts', 
            'ratingPercentages', 
            'hasBooked', // Truyền biến này ra View
            'schedules'
        ));
    }
}