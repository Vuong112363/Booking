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
        | 2. Tối ưu Code Logic với when()
        |--------------------------------------------------------------------------
        */
        $query = Tours::query()
            ->when($request->filled('destination'), fn($q) => $q->where('destination', 'LIKE', '%' . $request->destination . '%'))
            ->when($request->filled('start_date'), fn($q) => $q->whereDate('startdate', '>=', $request->start_date))
            ->when($request->filled('end_date'), fn($q) => $q->whereDate('enddate', '<=', $request->end_date))
            ->when($request->filled('guests'), fn($q) => $q->where('quantity', '>=', $request->guests))
            ->when($request->filled('filter_destination'), fn($q) => $q->where('destination', $request->filter_destination))
            ->when($request->filled('filter_domain'), fn($q) => $q->where('domain', $request->filter_domain))
            ->when($request->filled('sort_by'), function ($q) use ($request) {
                switch ($request->sort_by) {
                    case 'new':
                        // Mới nhất (Sắp xếp theo ID tour giảm dần)
                        $q->orderBy('tourid', 'desc'); 
                        break;
                    case 'old':
                        // Cũ nhất (Sắp xếp theo ID tour tăng dần)
                        $q->orderBy('tourid', 'asc');
                        break;
                    case 'high-to-low':
                        // Giá cao đến thấp
                        $q->orderBy('priceadult', 'desc');
                        break;
                    case 'low-to-high':
                        // Giá thấp đến cao
                        $q->orderBy('priceadult', 'asc');
                        break;
                    default:
                        $q->orderBy('tourid', 'desc');
                        break;
                }
            }, function ($q) {
                // Trạng thái mặc định nếu khách hàng chưa chọn gì (luôn hiện tour mới nhất lên đầu)
                $q->orderBy('tourid', 'desc');
            })
            ->when($request->filled('filter_duration'), function ($q) use ($request) {
                $duration = explode('-', $request->filter_duration);
                if (count($duration) == 2) {
                    $q->whereRaw('DATEDIFF(enddate, startdate) BETWEEN ? AND ?', [(int)$duration[0], (int)$duration[1]]);
                }
            })
            
            ->when($request->filled('price'), function ($q) use ($request) {
                $priceString = preg_replace('/[^0-9\-]/', '', $request->price);
                $priceRange = explode('-', $priceString);
                if (count($priceRange) == 2) {
                    $q->whereBetween('priceadult', [(float)$priceRange[0], (float)$priceRange[1]]);
                }
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

            foreach ($tours as $tour) {
                if (!empty($tour->images)) {
                    $tour->display_image = $tour->images;
                } else {
                    // Trích xuất ảnh đầu tiên từ bộ sưu tập ảnh đã lấy về
                    $tourImage = $defaultImages->get($tour->tourid)?->first();
                    $tour->display_image = $tourImage ? $tourImage->imageurl : 'default.jpg';
                }
            }
        }

        return view('clients.Tours', compact('title', 'tours', 'destinations'));
    }
}