<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class DestinationController extends Controller
{
    /**
     * Hiển thị trang điểm đến
     */
    public function index()
    {
        // 1. Lấy danh sách điểm đến phổ biến (ĐÃ FIX: Thêm domain)
        $popularDestinations = DB::table('tbl_tours')
            ->select('destination', 'domain', DB::raw('count(*) as total_tours'), DB::raw('MIN(images) as image'))
            ->where('availability', 1) // Tùy chọn: Chỉ lấy các điểm đến đang mở bán
            ->groupBy('destination', 'domain')
            ->limit(6)
            ->get();

        // 2. Lấy các tour ưu đãi 
        $hotDeals = DB::table('tbl_tours')
            ->select('tbl_tours.*') 
            ->addSelect(['min_price' => DB::table('tbl_tour_schedules')
                ->selectRaw('MIN(priceadult)')
                ->whereColumn('tbl_tour_schedules.tourid', 'tbl_tours.tourid')
                ->whereDate('startdate', '>=', now()) 
            ])
            ->where('availability', 1) 
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('tbl_tour_schedules')
                      ->whereColumn('tbl_tour_schedules.tourid', 'tbl_tours.tourid')
                      ->whereDate('startdate', '>=', now());
            })
            ->orderBy('min_price', 'asc')
            ->limit(3)
            ->get();

        // 3. Trả về giao diện 
        return view('Clients.Destination', compact('popularDestinations', 'hotDeals'));
    }
}