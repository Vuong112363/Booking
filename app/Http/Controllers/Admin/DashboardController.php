<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->month;
        $currentYear = date('Y');

        // 1. TỔNG QUAN HỆ THỐNG (KPIs) - Giữ nguyên các chức năng cũ
        $totalBookings = DB::table('tbl_bookings')->count();
        $bookingsToday = DB::table('tbl_bookings')->whereDate('bookingdate', $today)->count();
        $totalUsers = DB::table('tbl_users')->where('role', 0)->count(); // Chỉ đếm khách hàng
        $activeTours = DB::table('tbl_tours')->where('availability', 1)->count();
        $pendingBookings = DB::table('tbl_bookings')->where('bookingstatus', 'pending')->count();

        // 2. TÍNH TOÁN TÀI CHÍNH MỚI (CHÍNH XÁC 100%)
        // Doanh thu thực = (Tổng tiền khách đã đóng) - (Tổng tiền chốt hoàn trả cho khách)
        $totalPaidAll = DB::table('tbl_bookings')->sum('paid_amount');
        $totalRefundAll = DB::table('tbl_bookings')->sum('refund_amount');
        $totalRevenue = $totalPaidAll - $totalRefundAll; 

        // Doanh thu tháng này (Đã khấu trừ tiền hoàn trả của tháng này)
        $paidThisMonth = DB::table('tbl_bookings')
            ->whereMonth('bookingdate', $thisMonth)
            ->whereYear('bookingdate', $currentYear)
            ->sum('paid_amount');
        $refundThisMonth = DB::table('tbl_bookings')
            ->whereMonth('bookingdate', $thisMonth)
            ->whereYear('bookingdate', $currentYear)
            ->sum('refund_amount');
        $revenueThisMonth = $paidThisMonth - $refundThisMonth;

        // Doanh thu tháng trước (Để tính tăng trưởng)
        $lastMonthDate = Carbon::now()->subMonth();
        $paidLastMonth = DB::table('tbl_bookings')
            ->whereMonth('bookingdate', $lastMonthDate->month)
            ->whereYear('bookingdate', $lastMonthDate->year)
            ->sum('paid_amount');
        $refundLastMonth = DB::table('tbl_bookings')
            ->whereMonth('bookingdate', $lastMonthDate->month)
            ->whereYear('bookingdate', $lastMonthDate->year)
            ->sum('refund_amount');
        $revenueLastMonth = $paidLastMonth - $refundLastMonth;

        // Tính % tăng trưởng doanh thu
        $revenueGrowth = 0;
        if ($revenueLastMonth > 0) {
            $revenueGrowth = (($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100;
        } elseif ($revenueThisMonth > 0) {
            $revenueGrowth = 100;
        }

        // PHỤ PHÍ ĐÓN KHÁCH (Khoản thu cố định không hoàn)
        $totalPickupFees = DB::table('tbl_bookings')
            ->whereIn('paymentstatus', ['paid', 'deposit_paid', 'refund_pending', 'refunded'])
            ->sum('pickup_fee_total');

        // TIỀN CHỜ HOÀN TRẢ (Lấy trực tiếp từ cột refund_amount đã chốt)
        $totalRefundPending = DB::table('tbl_bookings')
            ->where('paymentstatus', 'refund_pending')
            ->sum('refund_amount');

        // TIỀN ĐÃ HOÀN TRẢ XONG
        $totalRefunded = DB::table('tbl_bookings')
            ->where('paymentstatus', 'refunded')
            ->sum('refund_amount');

        // CÔNG NỢ CẦN THU (Tính cả phí đón)
            $totalDebt = DB::table('tbl_bookings')
            ->where('bookingstatus', '!=', 'cancelled')
            ->where('paymentstatus', '!=', 'paid')
            ->sum(DB::raw('totalprice - paid_amount'));

        // 3. BIỂU ĐỒ DOANH THU 12 THÁNG (Đã trừ refund hàng tháng)
        $monthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $mPaid = DB::table('tbl_bookings')
                ->whereYear('bookingdate', $currentYear)
                ->whereMonth('bookingdate', $i)
                ->sum('paid_amount');
            $mRefund = DB::table('tbl_bookings')
                ->whereYear('bookingdate', $currentYear)
                ->whereMonth('bookingdate', $i)
                ->sum('refund_amount');
            $monthlyRevenue[] = $mPaid - $mRefund;
        }

        // 4. BIỂU ĐỒ TRẠNG THÁI ĐƠN
        $statusChart = [
            'confirmed'      => DB::table('tbl_bookings')->where('bookingstatus', 'confirmed')->count(),
            'pending'        => DB::table('tbl_bookings')->where('bookingstatus', 'pending')->count(),
            'cancelled'      => DB::table('tbl_bookings')->where('bookingstatus', 'cancelled')->count(),
            'refund_pending' => DB::table('tbl_bookings')->where('paymentstatus', 'refund_pending')->count(),
        ];

        // 5. TOP 5 TOUR BÁN CHẠY (Chức năng cũ của bạn)
        $topTours = DB::table('tbl_bookings')
            ->join('tbl_tours', 'tbl_bookings.tourid', '=', 'tbl_tours.tourid')
            ->select(
                'tbl_bookings.tourid',
                'tbl_tours.title',
                DB::raw('count(*) as total_bookings'),
                DB::raw('sum(paid_amount - refund_amount) as total_earned')
            )
            ->whereIn('bookingstatus', ['confirmed', 'completed'])
            ->groupBy('tbl_bookings.tourid', 'tbl_tours.title')
            ->orderByDesc('total_bookings')
            ->limit(5)
            ->get();

        // 6. BOOKING MỚI NHẤT (Chức năng cũ của bạn)
        $recentBookings = DB::table('tbl_bookings')
            ->join('tbl_users', 'tbl_bookings.userid', '=', 'tbl_users.userid')
            ->select('tbl_bookings.*', 'tbl_users.username')
            ->orderByDesc('bookingid')
            ->limit(6)
            ->get();

        // 7. LỊCH SỬ HỆ THỐNG (Chức năng cũ của bạn)
        $histories = DB::table('tbl_history')
            ->join('tbl_users', 'tbl_history.userid', '=', 'tbl_users.userid')
            ->select('tbl_history.*', 'tbl_users.username')
            ->orderByDesc('timestamp')
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact(
            'totalBookings', 'bookingsToday', 'totalUsers', 'activeTours', 'pendingBookings',
            'totalRevenue', 'revenueThisMonth', 'revenueGrowth', 'totalDebt', 'totalRefundPending', 'totalRefunded', 'totalPickupFees',
            'monthlyRevenue', 'statusChart', 'topTours', 
            'recentBookings', 'histories'
        ));
    }
}