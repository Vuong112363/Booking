<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Clients\Tours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache; // Đừng quên import Cache

class ToursController extends Controller
{
    private $tours;

    public function __construct()
    {
        $this->tours = new Tours();
    }

    public function index(Request $request)
    {
        $title = 'Tours';

        /*
        |--------------------------------------------------------------------------
        | 1. Tối ưu Cache Sidebar: Lưu trữ Điểm đến trong 1 ngày (86400 giây)
        |--------------------------------------------------------------------------
        */
        $destinations = Cache::remember('tours_destinations_sidebar', 86400, function () {
            return DB::table('tbl_tours')
                ->select('destination', DB::raw('count(*) as count'))
                ->groupBy('destination')
                ->orderBy('destination')
                ->get();
        });

        /*
        |--------------------------------------------------------------------------
        | 2. Tối ưu Code Logic - TÌM KIẾM CHÉO GIỮA TOUR VÀ LỊCH TRÌNH
        |--------------------------------------------------------------------------
        */
        $query = Tours::query()
            // --- A. TÌM KIẾM Ở BẢNG GỐC (tbl_tours) ---
            ->when($request->filled('destination'), fn($q) => $q->where('destination', 'LIKE', '%' . $request->destination . '%'))
            ->when($request->filled('filter_destination'), fn($q) => $q->where('destination', $request->filter_destination))
            ->when($request->filled('filter_domain'), fn($q) => $q->where('domain', $request->filter_domain))
            
            // --- B. TÌM KIẾM Ở BẢNG LỊCH TRÌNH (tbl_tour_schedules) ---
            // Yêu cầu: Tour phải có ít nhất 1 lịch trình mở bán và thỏa mãn các điều kiện lọc
            ->whereExists(function ($subquery) use ($request) {
                $subquery->select(DB::raw(1))
                         ->from('tbl_tour_schedules')
                         ->whereColumn('tbl_tour_schedules.tourid', 'tbl_tours.tourid')
                         ->whereDate('startdate', '>=', now()); // Chỉ tìm lịch trình chưa xuất phát

                // Lọc theo ngày bắt đầu
                if ($request->filled('start_date')) {
                    $subquery->whereDate('startdate', '>=', $request->start_date);
                }

                // Lọc theo ngày kết thúc
                if ($request->filled('end_date')) {
                    $subquery->whereDate('enddate', '<=', $request->end_date);
                }

                // Lọc theo số chỗ trống (Giao diện gửi lên là 'guests', DB lưu là 'quantity')
                if ($request->filled('guests')) {
                    $subquery->where('quantity', '>=', $request->guests);
                }

                // Lọc theo khoảng thời gian (Số ngày đi)
                if ($request->filled('filter_duration')) {
                    $duration = explode('-', $request->filter_duration);
                    if (count($duration) == 2) {
                        $subquery->whereRaw('DATEDIFF(enddate, startdate) BETWEEN ? AND ?', [(int)$duration[0], (int)$duration[1]]);
                    }
                }

                // Lọc theo khoảng giá tiền
                if ($request->filled('price')) {
                    $priceString = preg_replace('/[^0-9\-]/', '', $request->price);
                    $priceRange = explode('-', $priceString);
                    if (count($priceRange) == 2) {
                        $subquery->whereBetween('priceadult', [(float)$priceRange[0], (float)$priceRange[1]]);
                    }
                }
            })

            // --- C. LOGIC SẮP XẾP (SORT BY) ---
            ->when($request->filled('sort_by'), function ($q) use ($request) {
                // Khai báo câu truy vấn phụ để lấy giá Min
                $minPriceSubquery = DB::table('tbl_tour_schedules')
                    ->selectRaw('MIN(priceadult)')
                    ->whereColumn('tbl_tour_schedules.tourid', 'tbl_tours.tourid')
                    ->whereDate('startdate', '>=', now());

                switch ($request->sort_by) {
                    case 'new':
                        $q->orderBy('tourid', 'desc'); 
                        break;
                    case 'old':
                        $q->orderBy('tourid', 'asc');
                        break;
                    case 'high-to-low':
                        $q->orderByDesc($minPriceSubquery);
                        break;
                    case 'low-to-high':
                        $q->orderBy($minPriceSubquery);
                        break;
                    default:
                        $q->orderBy('tourid', 'desc');
                        break;
                }
            }, function ($q) {
                // Sắp xếp mặc định nếu không chọn gì
                $q->orderBy('tourid', 'desc');
            });

        // Lấy dữ liệu phân trang
        $tours = $query->paginate(9)->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Xử lý Request từ AJAX (Đưa lên trước vòng lặp ảnh để tiết kiệm tài nguyên nếu là AJAX)
        |--------------------------------------------------------------------------
        */
        if ($request->ajax()) {
            return response()->json($tours->items()); 
        }

        /*
        |--------------------------------------------------------------------------
    /*
        |--------------------------------------------------------------------------
        | 3. Xóa lỗi N+1 Query: Lấy tất cả ảnh mặc định trong 1 lần truy vấn duy nhất
        |--------------------------------------------------------------------------
        */
        // Tìm ra danh sách ID của các tour đang hiển thị trên trang hiện tại
        $tourIds = $tours->pluck('tourid')->filter(); 

        // Truy vấn 1 lần duy nhất để lấy toàn bộ ảnh của các tour này
        if ($tourIds->isNotEmpty()) {
            $defaultImages = DB::table('tbl_images')
                ->whereIn('tourid', $tourIds)
                ->get()
                ->groupBy('tourid');

            // 3.2 Lấy thông tin Lịch trình (Giá Min & Tổng số chỗ) - CHÍNH LÀ ĐOẠN NÀY ĐÂY
            $schedulesInfo = DB::table('tbl_tour_schedules')
                ->whereIn('tourid', $tourIds)
                ->whereDate('startdate', '>=', now()) // Chỉ lấy các lịch trình chưa xuất phát
                ->select(
                    'tourid', 
                    DB::raw('MIN(priceadult) as min_price'),
                    DB::raw('SUM(quantity) as total_quantity') // Tính tổng chỗ trống
                )
                ->groupBy('tourid')
                ->get()
                ->keyBy('tourid'); // Đưa về dạng mảng [tourid => data] để truy xuất nhanh

            // 3.3 Gán dữ liệu vào từng tour
            foreach ($tours as $tour) {
                // --- Xử lý ảnh ---
                if (!empty($tour->images)) {
                    $tour->display_image = $tour->images;
                } else {
                    $tourImage = $defaultImages->get($tour->tourid)?->first();
                    $tour->display_image = $tourImage ? $tourImage->imageurl : 'default.jpg';
                }

                // --- Xử lý Giá Min và Số lượng ---
                
                // ĐÂY LÀ DÒNG BẠN BỊ THIẾU KHIẾN LỖI UNDEFINED VARIABLE
                $schedule = $schedulesInfo->get($tour->tourid);
                
                // Gán giá min
                $tour->min_price = $schedule ? $schedule->min_price : $tour->priceadult;
                
                // Gán số lượng chỗ
                $tour->quantity = $schedule ? $schedule->total_quantity : ($tour->quantity ?? 0);
            }
        }

        return view('clients.Tours', compact('title', 'tours', 'destinations'));
    }
}