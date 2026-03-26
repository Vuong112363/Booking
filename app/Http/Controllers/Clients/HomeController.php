<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clients\Tours; 
use App\Models\Clients\Blog;
use Illuminate\Support\Facades\DB; 

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Trang chủ';
        
        // 1. Lấy các tour đang mở bán (availability = 1) 
        // VÀ BẮT BUỘC phải có lịch trình chưa xuất phát
        $tours = Tours::where('availability', 1)
                      ->whereExists(function ($query) {
                          $query->select(DB::raw(1))
                                ->from('tbl_tour_schedules')
                                ->whereColumn('tbl_tour_schedules.tourid', 'tbl_tours.tourid')
                                ->whereDate('startdate', '>=', now());
                      })
                      ->orderBy('tourid', 'desc')
                      ->take(8)
                      ->get();

        /*
        |--------------------------------------------------------------------------
        | XỬ LÝ ẢNH, GIÁ "CHỈ TỪ" VÀ TỔNG SỐ CHỖ (Chống N+1 Query)
        |--------------------------------------------------------------------------
        */
        $tourIds = $tours->pluck('tourid')->filter();

        if ($tourIds->isNotEmpty()) {
            // 1. Lấy tất cả ảnh của 8 tour này
            $defaultImages = DB::table('tbl_images')
                ->whereIn('tourid', $tourIds)
                ->get()
                ->groupBy('tourid');

            // 2. Lấy GIÁ MIN và TỔNG SỐ CHỖ (quantity) từ lịch trình
            $schedulesInfo = DB::table('tbl_tour_schedules')
                ->whereIn('tourid', $tourIds)
                ->whereDate('startdate', '>=', now())
                ->select(
                    'tourid', 
                    DB::raw('MIN(priceadult) as min_price'),
                    DB::raw('SUM(quantity) as total_quantity') // FIX LỖI "HẾT CHỖ" Ở ĐÂY
                )
                ->groupBy('tourid')
                ->get()
                ->keyBy('tourid'); // Gom nhóm theo tourid để dễ truy xuất

            // 3. Gán dữ liệu vào biến $tours để View có thể dùng
            foreach ($tours as $tour) {
                // Xử lý ảnh
                if (!empty($tour->images)) {
                    $tour->display_image = $tour->images;
                } else {
                    $tourImage = $defaultImages->get($tour->tourid)?->first();
                    $tour->display_image = $tourImage ? ($tourImage->imageurl ?? $tourImage->imageUrl ?? 'default.jpg') : 'default.jpg';
                }

                // Xử lý Lịch trình (Giá Min & Số Chỗ)
                $schedule = $schedulesInfo->get($tour->tourid);
                
                // Gán giá min
                $tour->min_price = $schedule ? $schedule->min_price : ($tour->priceadult ?? 0);
                
                // GHI ĐÈ SỐ CHỖ: Tránh lỗi "Đã hết chỗ" ở View
                $tour->quantity = $schedule ? $schedule->total_quantity : ($tour->quantity ?? 0);
            }
        }

        /*------------------------------------------------------------------------*/

        $blogs = Blog::where('is_active', 1)
        ->latest()
        ->take(3) // lấy 3 bài mới
        ->get();

        $testimonials = DB::table('tbl_reviews')
        ->join('tbl_users', 'tbl_reviews.userid', '=', 'tbl_users.userid')
        ->join('tbl_tours', 'tbl_reviews.tourid', '=', 'tbl_tours.tourid')
        ->where('tbl_reviews.status', 1)
        ->select('tbl_reviews.*', 'tbl_users.username', 'tbl_users.avatar', 'tbl_tours.title as tour_name', 'tbl_tours.destination')
        ->orderBy('tbl_reviews.rating', 'desc') // Ưu tiên các đánh giá 5 sao lên đầu
        ->limit(8)
        ->get();

        $popularDestinations = DB::table('tbl_tours')
    ->select(
        'destination',
        DB::raw('MIN(images) as image'), // lấy 1 ảnh đại diện
        'domain',
        DB::raw('COUNT(*) as total_tours')
    )
    ->whereNotNull('destination')
    ->groupBy('destination', 'domain')
    ->orderByDesc(DB::raw('COUNT(*)'))
    ->limit(6)
    ->get();
        return view('Clients.home', compact('title', 'tours', 'blogs', 'testimonials', 'popularDestinations'));
    }
}