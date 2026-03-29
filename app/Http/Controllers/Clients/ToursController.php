<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Clients\Tours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

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
            ->whereExists(function ($subquery) use ($request) {
                $subquery->select(DB::raw(1))
                         ->from('tbl_tour_schedules')
                         ->whereColumn('tbl_tour_schedules.tourid', 'tbl_tours.tourid')
                         ->whereDate('startdate', '>=', now()); // Chỉ tìm lịch trình chưa xuất phát

                if ($request->filled('start_date')) {
                    $subquery->whereDate('startdate', '>=', $request->start_date);
                }

                if ($request->filled('end_date')) {
                    $subquery->whereDate('enddate', '<=', $request->end_date);
                }

                if ($request->filled('guests')) {
                    $subquery->where('quantity', '>=', $request->guests);
                }

                if ($request->filled('filter_duration')) {
                    $duration = explode('-', $request->filter_duration);
                    if (count($duration) == 2) {
                        $subquery->whereRaw('DATEDIFF(enddate, startdate) BETWEEN ? AND ?', [(int)$duration[0], (int)$duration[1]]);
                    }
                }

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
        | 3. Xóa lỗi N+1 Query: Gán Ảnh, Giá, Chỗ trống và Trạng thái Yêu thích
        |--------------------------------------------------------------------------
        */
        $tourIds = $tours->pluck('tourid')->filter(); 

        if ($tourIds->isNotEmpty()) {
            // Lấy toàn bộ ảnh mặc định
            $defaultImages = DB::table('tbl_images')
                ->whereIn('tourid', $tourIds)
                ->get()
                ->groupBy('tourid');

            // Lấy thông tin Lịch trình (Giá Min & Tổng số chỗ)
            $schedulesInfo = DB::table('tbl_tour_schedules')
                ->whereIn('tourid', $tourIds)
                ->whereDate('startdate', '>=', now())
                ->select(
                    'tourid', 
                    DB::raw('MIN(priceadult) as min_price'),
                    DB::raw('SUM(quantity) as total_quantity')
                )
                ->groupBy('tourid')
                ->get()
                ->keyBy('tourid');
            
            // Lấy danh sách Tour ID mà user hiện tại đã yêu thích
            $userFavoriteTourIds = [];
            if (session()->has('userid')) {
                $userFavoriteTourIds = DB::table('favorites') 
                    ->where('userid', session('userid'))
                    ->whereIn('tourid', $tourIds)
                    ->pluck('tourid')
                    ->toArray();
            }

            // Gán dữ liệu vào từng object tour
            foreach ($tours as $tour) {
                // Xử lý ảnh
                if (!empty($tour->images)) {
                    $tour->display_image = $tour->images;
                } else {
                    $tourImage = $defaultImages->get($tour->tourid)?->first();
                    $tour->display_image = $tourImage ? $tourImage->imageurl : 'default.jpg';
                }

                // Xử lý Giá Min và Số lượng
                $schedule = $schedulesInfo->get($tour->tourid);
                $tour->min_price = $schedule ? $schedule->min_price : $tour->priceadult;
                $tour->quantity = $schedule ? $schedule->total_quantity : ($tour->quantity ?? 0);
                
                // Gán trạng thái yêu thích
                $tour->is_favorited = in_array($tour->tourid, $userFavoriteTourIds);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Xử lý Request từ AJAX (Ví dụ: Load More, Lọc)
        | CHÚ Ý: Đặt ở đây để đảm bảo biến $tours đã được gán đầy đủ thuộc tính
        |--------------------------------------------------------------------------
        */
        if ($request->ajax()) {
            return response()->json($tours->items()); 
        }

        return view('clients.Tours', compact('title', 'tours', 'destinations'));
    }

    /*
    |--------------------------------------------------------------------------
    | Xử lý Yêu Thích Tour (Gọi bằng AJAX)
    |--------------------------------------------------------------------------
    */
    public function toggleFavorite(Request $request)
    {
        try {
            // Kiểm tra đăng nhập
            if (!session()->has('userid')) {
                return response()->json(['status' => 'error', 'message' => 'Vui lòng đăng nhập để lưu tour'], 401);
            }

            $userid = session('userid');
            $tourid = $request->tourid; 

            // Sử dụng đúng tên cột userid và tourid
            $favoriteQuery = DB::table('favorites')
                ->where('userid', $userid)
                ->where('tourid', $tourid);

            if ($favoriteQuery->exists()) {
                // Đã thích -> Bỏ thích
                $favoriteQuery->delete();
                return response()->json(['status' => 'removed', 'message' => 'Đã bỏ yêu thích']);
            } else {
                // Chưa thích -> Thêm mới
                DB::table('favorites')->insert([
                    'userid' => $userid,
                    'tourid' => $tourid,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                return response()->json(['status' => 'added', 'message' => 'Đã thêm vào yêu thích']);
            }
        } catch (\Exception $e) {
            // TÓM CỔ LỖI VÀ TRẢ VỀ JSON
            return response()->json([
                'status' => 'error',
                'message' => 'LỖI CHÍNH XÁC LÀ: ' . $e->getMessage()
            ], 500);
        }
    }
        
}