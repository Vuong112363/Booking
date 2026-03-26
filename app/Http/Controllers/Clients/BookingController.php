<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\History;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\BookingConfirmationMail;
use App\Models\Clients\Tours;
use Carbon\Carbon;


class BookingController extends Controller
{
    
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
            Mail::to($bookingDetail->email)->send(new \App\Mail\BookingConfirmationMail($bookingDetail));
        }
    } catch (\Exception $e) {
        \Log::error("Lỗi gửi mail Booking #$bookingId: " . $e->getMessage());
    }
}

    // =========================
    // TRANG ĐẶT TOUR
    // =========================
    public function index(Request $request, $id)
    {
        if(!session()->has('userid')){
            return redirect('/login')
            ->with('error','Vui lòng đăng nhập để đặt tour');
        }

        if (!$request->filled('schedule_id')) {
            return redirect('/tour-detail/' . $id)->with('error', 'Vui lòng chọn lịch khởi hành trước khi đặt tour!');
        }

        // LẤY THÔNG TIN LỊCH TRÌNH
        $schedule = DB::table('tbl_tour_schedules') 
            ->where('schedule_id', $request->schedule_id)
            ->first();

        if (!$schedule) {
            return redirect('/tour-detail/' . $id)->with('error', 'Lịch khởi hành không tồn tại hoặc đã bị xóa!');
        }

        $title = "Đặt Tour";

        $tourModel = new Tours();
        $tour = $tourModel->getTourDetail($id); 

        if (!$tour) {
            return redirect('/')->with('error', 'Tour không tồn tại!');
        }

        return view('Clients.Booking',compact('tour','title', 'schedule'));
    }


    // =========================
    // LƯU BOOKING
    // =========================
    public function store(Request $request, $id)

    {
        

        if(!session()->has('userid')){
            return redirect('/login')
            ->with('error','Vui lòng đăng nhập để đặt tour');
        }

        $userid = session('userid');

        // 🔒 chống spam
        $pendingBookings = DB::table('tbl_bookings')
            ->where('userid', $userid)
            ->where('bookingstatus', 'pending')
            ->count();

        if($pendingBookings >= 3){
            return back()->with('error','Bạn có quá nhiều đơn chưa thanh toán');
        }

        $dailyBookings = DB::table('tbl_bookings')
            ->where('userid', $userid)
            ->whereDate('bookingdate', date('Y-m-d'))
            ->count();

        if($dailyBookings >= 5){
            return back()->with('error','Bạn đã đạt giới hạn 5 đơn/ngày. Vui lòng thử lại ngày mai!.Hoặc liên hệ hỗ trợ nếu cần đặt gấp.');
        }

        $payment = $request->paymentmethod;
        $adult = $request->numadults;
        $child = $request->numchildren;
        $schedule_id = $request->schedule_id;

        $tour = DB::table('tbl_tours')->where('tourid',$id)->first();
        
        // KIỂM TRA LỊCH TRÌNH VÀ GÁN GIÁ TIỀN
        $priceAdult = $tour->priceadult ?? 0;
        $priceChild = $tour->pricechild ?? 0;
        $availableQuantity = $tour->quantity ?? 0;
        $startDate = $tour->startdate ?? null;

        $schedule = null;
        if ($schedule_id) {
            $schedule = DB::table('tbl_tour_schedules')->where('schedule_id', $schedule_id)->first();
            if ($schedule) {
                $priceAdult = $schedule->priceadult;
                $priceChild = $schedule->pricechild;
                $availableQuantity = $schedule->quantity;
                $startDate = $schedule->startdate;
            }
        }

        $total = ($adult * $priceAdult) + ($child * $priceChild);

        // 1. KIỂM TRA XEM TOUR ĐÃ QUÁ HẠN CHƯA
        if ($startDate && \Carbon\Carbon::parse($startDate)->endOfDay()->isPast()) {
            return back()->with('error', 'Rất tiếc, lịch khởi hành này đã qua. Vui lòng chọn ngày khác!');
        }

        // 2. KIỂM TRA TOUR CÓ BỊ TẠM NGƯNG KHÔNG
        if ($tour->availability == 0) {
            return back()->with('error', 'Tour này hiện đang tạm ngưng nhận khách.');
        }

        // 3. KIỂM TRA SỐ LƯỢNG CHỖ TRỐNG
        $totalPassengers = $adult + $child;
        if ($availableQuantity < $totalPassengers) {
            return back()->with('error', 'Số chỗ trống không đủ. Chuyến này chỉ còn ' . $availableQuantity . ' chỗ.');
        }

        // 4. Xử lý mã giảm giá (Nếu có)
        $couponCode = trim($request->input('coupon_code_hidden'));
        if($couponCode) {
            $promotion = DB::table('tbl_promotion')
                ->where('code', $couponCode)
                ->where('quantity', '>', 0)
                ->first();
                
            if($promotion) {    
                $discountAmount = $total * ($promotion->discount_percent / 100);
                $total = $total - $discountAmount;
                DB::table('tbl_promotion')
                    ->where('promotionid', $promotion->promotionid)
                    ->decrement('quantity', 1);
            }
        }

        $deposit = round($total * 0.3);
        $info = "Tên: ".$request->username." | Email: ".$request->email." | SĐT: ".$request->tel." | Địa chỉ: ".$request->dia_chi;

        // Lưu booking
        $bookingData = [
            'tourid' => $id,
            'userid' => $userid,
            'bookingdate' => now(),
            'numadults' => $adult,
            'numchildren' => $child,
            'totalprice' => $total,
            'schedule_id' => $request->schedule_id,
            'pickup_id' => $request->pickup_id,
            'pickup_fee_total' => $request->pickup_fee_total_hidden,
            'deposit_amount' => $deposit,
            'paid_amount' => 0,
            'paymentstatus' => 'unpaid',
            'bookingstatus' => 'pending',
            'paymentmethod' => $payment,
            'specialrequest' => $info
        ];

        DB::table('tbl_bookings')->insert($bookingData);
        $bookingId = DB::getPdo()->lastInsertId();

        // 5. TRỪ SỐ CHỖ TRỐNG
        if ($schedule) {
            DB::table('tbl_tour_schedules')->where('schedule_id', $schedule_id)->decrement('quantity', $totalPassengers);
        } else {
            DB::table('tbl_tours')->where('tourid', $id)->decrement('quantity', $totalPassengers);
        }

        // ==========================================
        // GỬI EMAIL (ĐÃ FIX LỖI JOIN BẢNG LẤY STARTDATE)
        // ==========================================
        try {
            $bookingDetail = DB::table('tbl_bookings')
                ->join('tbl_tours', 'tbl_bookings.tourid', '=', 'tbl_tours.tourid')
                ->leftJoin('tbl_tour_schedules', 'tbl_bookings.schedule_id', '=', 'tbl_tour_schedules.schedule_id')
                ->where('tbl_bookings.bookingid', $bookingId)
                ->select('tbl_bookings.*', 'tbl_tours.title', 'tbl_tour_schedules.startdate')
                ->first();

            $bookingDetail->email = $request->email;
            $bookingDetail->username = $request->username;

            Mail::to($request->email)->send(new BookingConfirmationMail($bookingDetail));
            
        } catch (\Exception $e) {
            \Log::error("Lỗi gửi mail đặt tour ID $bookingId: " . $e->getMessage());
        }
        if($payment == "cash") {
            $this->sendBookingEmail($bookingId);
        }

        if($payment == "momo"){
            return redirect('/momo-payment/'.$bookingId);
        }

        History::create([
            'userid' => $userid,
            'actionType' => "Tạo đơn đặt tour mới (ID: $bookingId). Phương thức: " . $request->paymentmethod,
            'timestamp' => now()
        ]);

        return redirect('/booking-history')->with('success','Đặt tour thành công!');
    }


    // =========================
    // MOMO PAYMENT
    // =========================
    public function momo_payment($bookingId)
{
    $booking = DB::table('tbl_bookings')->where('bookingid', $bookingId)->first();

    if (!$booking) return back()->with('error', 'Không tồn tại booking');
    if ($booking->paymentstatus == 'paid') return back()->with('error', 'Đã thanh toán rồi.');

    $amount = ($booking->paymentstatus == 'unpaid') ? (int)$booking->deposit_amount : (int)($booking->totalprice - $booking->paid_amount);
    $orderInfo = "Thanh toan tour #" . $bookingId;

    if ($amount <= 0) return back()->with('error', 'Số tiền không hợp lệ.');

    // --- LẤY THÔNG TIN TỪ DATABASE QUA HELPER get_setting ---
    // Nếu trong DB chưa có, nó sẽ lấy giá trị mặc định ở tham số thứ 2
    $endpoint    = get_setting('momo_environment', 'https://test-payment.momo.vn/v2/gateway/api/create');
    $partnerCode = get_setting('momo_partner_code', 'MOMO3PZW20250404_TEST');
    $accessKey   = get_setting('momo_access_key', 'aCkRGYFnwrlAxV6O');
    $secretKey   = get_setting('momo_secret_key', 'BfyQQNQty1udFv5UNh4WoOrHTbK2HGYD');
    
    $orderId     = time() . "_" . $bookingId;
    $redirectUrl = url('/momo-return/' . $bookingId);
    $ipnUrl      = url('/momo-return/' . $bookingId);

    // Xây dựng chuỗi ký tự Hash
    $rawHash = "accessKey=" . $accessKey . 
               "&amount=" . $amount . 
               "&extraData=" . 
               "&ipnUrl=" . $ipnUrl . 
               "&orderId=" . $orderId . 
               "&orderInfo=" . $orderInfo . 
               "&partnerCode=" . $partnerCode . 
               "&redirectUrl=" . $redirectUrl . 
               "&requestId=" . $orderId . 
               "&requestType=captureWallet";

    $signature = hash_hmac("sha256", $rawHash, $secretKey);

    $data = [
        'partnerCode' => $partnerCode,
        'requestId'   => $orderId,
        'amount'      => $amount,
        'orderId'     => $orderId,
        'orderInfo'   => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl'      => $ipnUrl,
        'requestType' => "captureWallet",
        'extraData'   => "",
        'signature'   => $signature,
        'lang'        => 'vi'
    ];

    $result = $this->execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true);

    if (!isset($jsonResult['payUrl'])) {
        // Ghi log lỗi nếu không lấy được link thanh toán để dễ debug
        \Log::error("MoMo Payment Error: ", $jsonResult);
        return back()->with('error', 'Lỗi kết nối với MoMo. Vui lòng thử lại sau.');
    }

    return redirect($jsonResult['payUrl']);
}

    private function execPostRequest($url,$data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_HTTPHEADER,['Content-Type: application/json']);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }


    // =========================
    // MOMO RETURN (ĐÃ TÍCH HỢP HÓA ĐƠN)
    // =========================
    public function momo_return(Request $request, $bookingId)
    {
        $cleanId = preg_replace('/[^0-9]/', '', $bookingId);

        if ($request->resultCode == 0) {
            $booking = DB::table('tbl_bookings')->where('bookingid', $cleanId)->first();
            
            if ($booking) {
                $message = ""; 
                if ($booking->paymentstatus == 'unpaid') {
                    DB::table('tbl_bookings')->where('bookingid', $cleanId)->update([
                        'paymentstatus' => 'deposit_paid',
                        'paid_amount'   => $booking->deposit_amount > 0 ? $booking->deposit_amount : ($booking->totalprice * 0.3),
                        'bookingstatus' => 'confirmed',
                        'paymentmethod' => 'MoMo'
                    ]);
                    $message = "Thanh toán đặt cọc thành công!";
                } elseif ($booking->paymentstatus == 'deposit_paid') {
                    DB::table('tbl_bookings')->where('bookingid', $cleanId)->update([
                        'paymentstatus' => 'paid',
                        'paid_amount'   => $booking->totalprice, 
                    ]);
                    $message = "Thanh toán 100% số dư thành công!";
                }

                // --- TỰ ĐỘNG TẠO HÓA ĐƠN ---
                $this->autoCreateInvoice($cleanId);
                $this->sendBookingEmail($cleanId);

                DB::table('tbl_history')->insert([
                    'userid' => session('userid'),
                    'actionType' => $message . " (Đơn hàng #$cleanId)",
                    'timestamp' => now()
                ]);

                return redirect('/booking-history')->with('success', $message);
            }
        }
        return redirect('/booking-history')->with('error', 'Thanh toán không thành công.');
    }

    // =========================
    // LỊCH SỬ
    // =========================
    public function history()
    {
        if(!session()->has('userid')){
            return redirect('/login');
        }

        $userid = session('userid');

        $bookings = DB::table('tbl_bookings')
        ->join('tbl_tours','tbl_bookings.tourid','=','tbl_tours.tourid')
        ->leftJoin('tbl_tour_schedules', 'tbl_bookings.schedule_id', '=', 'tbl_tour_schedules.schedule_id')
        ->leftJoin('tbl_tour_pickups', 'tbl_bookings.pickup_id', '=', 'tbl_tour_pickups.pickup_id')
        ->where('tbl_bookings.userid',$userid)
        ->select(
            'tbl_bookings.*',
            'tbl_tours.title',
            'tbl_tours.duration',
            'tbl_tours.destination',
            'tbl_tours.images',
            'tbl_tour_pickups.pickup_name', 
            'tbl_tour_pickups.pickup_time',
            'tbl_tour_schedules.startdate'
        )
        ->orderBy('bookingdate','desc')
        ->paginate(5);

        $tourIds = $bookings->pluck('tourid')->filter()->unique();
        $timelines = collect();
        if ($tourIds->isNotEmpty()) {
            $timelines = DB::table('tbl_timeline')
                ->whereIn('tourid', $tourIds)
                ->orderBy('timelineID', 'asc')
                ->get()
                ->groupBy('tourid');
        }

        foreach ($bookings as $booking) {
            $booking->timelines = $timelines->get($booking->tourid) ?? [];
        }

        return view('Clients.booking-history',compact('bookings'));
    }

// ==========================================
    // HỦY + HOÀN TIỀN (Bản hoàn chỉnh đã trừ phí đón)
    // ==========================================
   public function cancel(Request $request, $id)
{
    // 1. Lấy thông tin booking và lịch trình
    $booking = DB::table('tbl_bookings')
        ->leftJoin('tbl_tour_schedules', 'tbl_bookings.schedule_id', '=', 'tbl_tour_schedules.schedule_id')
        ->where('bookingid', $id)
        ->first();

    // Kiểm tra đơn hàng tồn tại
    if (!$booking) {
        return back()->with('error', 'Không tìm thấy đơn hàng.');
    }

    // Chặn nếu đơn hàng đã hủy rồi
    if ($booking->bookingstatus == 'cancelled') {
        return back()->with('error', 'Đơn hàng này đã được xử lý hủy trước đó.');
    }

    // --- BỔ SUNG: KIỂM TRA TOUR ĐÃ KHỞI HÀNH CHƯA ---
    $now = \Carbon\Carbon::now();
    $startDate = \Carbon\Carbon::parse($booking->startdate); // Thường startdate sẽ bao gồm cả giờ: Y-m-d H:i:s

    if ($now->greaterThanOrEqualTo($startDate)) {
        return back()->with('error', 'Tour đã hoặc đang khởi hành, không thể hủy qua hệ thống. Vui lòng liên hệ Hotline để được hỗ trợ.');
    }

    try {
        DB::beginTransaction();

        $refundAmount = 0;
        $paymentStatus = $booking->paymentstatus; 

        // 2. Tính toán tiền hoàn dựa trên NGÀY TRÒN (Carbon)
        // Dùng startOfDay để tính toán mốc 2 ngày, 5 ngày theo lịch
        $nowDate = \Carbon\Carbon::now()->startOfDay();
        $startDateOnly = \Carbon\Carbon::parse($booking->startdate)->startOfDay();
        $daysToStart = $nowDate->diffInDays($startDateOnly, false); 

        if ($booking->paid_amount > 0) {
            // --- LOGIC TRỪ PHỤ PHÍ ĐÓN KHÁCH ---
            $pickupFee = $booking->pickup_fee_total ?? 0;
            $refundableBase = $booking->paid_amount - $pickupFee;

            if ($refundableBase < 0) $refundableBase = 0;

            // Tính toán theo mốc thời gian
            if ($daysToStart >= 5) {
                $refundAmount = $refundableBase; 
            } elseif ($daysToStart >= 2) {
                $refundAmount = $refundableBase * 0.5;
            }
            
            if ($refundAmount > 0) {
                $paymentStatus = 'refund_pending'; 
            }
        }

        // 3. Cập nhật Database
        DB::table('tbl_bookings')->where('bookingid', $id)->update([
            'bookingstatus' => 'cancelled',
            'paymentstatus' => $paymentStatus, 
            'refund_amount' => $refundAmount,
            'cancel_reason' => $request->cancel_reason ?? 'Khách hàng yêu cầu',
            'specialrequest' => $booking->specialrequest . " | REFUND INFO: " . ($request->refund_info ?? 'N/A')
        ]);

        // 4. Hoàn trả lại số lượng chỗ trống
        if (!empty($booking->schedule_id)) {
            $totalPassengers = $booking->numadults + $booking->numchildren;
            DB::table('tbl_tour_schedules')
                ->where('schedule_id', $booking->schedule_id)
                ->increment('quantity', $totalPassengers);
        }

        DB::commit();

        // 5. Gửi email thông báo
        $this->sendBookingEmail($id);

        return back()->with('success', 'Hủy tour thành công! Tiền hoàn đã được tính khấu trừ phụ phí đón khách.');
        
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error("Lỗi khi hủy đơn #$id: " . $e->getMessage());
        return back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
    }
}
    // =========================
    // XÁC NHẬN TIỀN MẶT (ADMIN)
    // =========================
    public function confirmCash($id)
    {
        try {
            DB::beginTransaction();
            $booking = DB::table('tbl_bookings')
                ->join('tbl_users', 'tbl_bookings.userid', '=', 'tbl_users.userid')
                ->leftJoin('tbl_tour_schedules', 'tbl_bookings.schedule_id', '=', 'tbl_tour_schedules.schedule_id')
                ->where('bookingid', $id)
                ->first();

            if (!$booking) return back()->with('error', 'Không tìm thấy đơn hàng.');

            DB::table('tbl_bookings')->where('bookingid', $id)->update([
                'paymentstatus' => 'paid',
                'paid_amount' => $booking->totalprice,
                'bookingstatus' => 'confirmed',
                'paymentmethod' => 'Cash'
            ]);

            // --- TẠO HÓA ĐƠN TIỀN MẶT ---
            $this->autoCreateInvoice($id);
            $this->sendBookingEmail($id);

            DB::table('tbl_history')->insert([
                'userid' => \Illuminate\Support\Facades\Auth::id() ?? 3,
                'actionType' => "Admin xác nhận thu tiền mặt đơn #$id",
                'timestamp' => now()
            ]);

            DB::commit();
            return back()->with('success', 'Xác nhận thu tiền mặt thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // =========================
    // HÀM PHỤ TRỢ: TỰ ĐỘNG TẠO HÓA ĐƠN
    // =========================
    private function autoCreateInvoice($bookingId) {
        $booking = DB::table('tbl_bookings')->where('bookingid', $bookingId)->first();
        if ($booking) {
            $exists = DB::table('tbl_invoice')->where('bookingid', $bookingId)->exists();
            if (!$exists) {
                $tour = DB::table('tbl_tours')->where('tourid', $booking->tourid)->first();
                DB::table('tbl_invoice')->insert([
                    'bookingid' => $bookingId,
                    'userid' => $booking->userid,
                    'email'       => $customerEmail ?? 'vuongvanbui20@gmail.com', // Dùng email khách truyền vào
                    'detelssued' => now(),
                    'totalamount' => $booking->totalprice,
                    'detail' => 'Hóa đơn Tour: ' . ($tour->title ?? $booking->tourid)
                ]);
            }
        }
    }

    // =========================
    // CHI TIẾT
    // =========================
    public function detail($id)
    {
        $userid = session('userid');
        $booking = DB::table('tbl_bookings')
        ->join('tbl_tours','tbl_bookings.tourid','=','tbl_tours.tourid')
        ->leftJoin('tbl_tour_schedules', 'tbl_bookings.schedule_id', '=', 'tbl_tour_schedules.schedule_id')
        ->where('bookingid',$id)
        ->where('tbl_bookings.userid',$userid)
        ->select('tbl_bookings.*','tbl_tours.title','tbl_tour_schedules.startdate','tbl_tours.location')
        ->first();

        return view('Clients.booking-detail',compact('booking'));
    }

    public function checkCoupon(Request $request) {
        $coupon = DB::table('tbl_promotion')
            ->where('code', $request->coupon_code)
            ->where('startdate', '<=', now())
            ->where('enddate', '>=', now())
            ->where('quantity', '>', 0)
            ->first();

        if ($coupon) {
            return response()->json(['success' => true, 'discount' => $coupon->discount_percent, 'message' => "Giảm {$coupon->discount_percent}%"]);
        }
        return response()->json(['success' => false, 'message' => 'Mã không khả dụng.']);
    }
    

}