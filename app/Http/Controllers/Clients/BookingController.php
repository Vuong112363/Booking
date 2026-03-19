<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\History;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmationMail;

class BookingController extends Controller
{

    // =========================
    // TRANG ĐẶT TOUR
    // =========================
    public function index($id)
    {
        if(!session()->has('userid')){
            return redirect('/login')
            ->with('error','Vui lòng đăng nhập để đặt tour');
        }

        $title = "Đặt Tour";

        $tour = DB::table('tbl_tours')
        ->where('tourid',$id)
        ->first();

        return view('Clients.Booking',compact('tour','title'));
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
            return back()->with('error','Giới hạn 5 đơn/ngày');
        }

        $payment = $request->paymentmethod;
        $adult = $request->numadults;
        $child = $request->numchildren;

        $tour = DB::table('tbl_tours')->where('tourid',$id)->first();

        $total = ($adult * $tour->priceadult) + ($child * $tour->pricechild);

        $deposit = round($total * 0.3); // Làm tròn đến hàng nghìn

        $info = "Tên: ".$request->username.
                " | Email: ".$request->email.
                " | SĐT: ".$request->tel.
                " | Địa chỉ: ".$request->dia_chi;

        DB::table('tbl_bookings')->insert([
            'tourid'=>$id,
            'userid'=>$userid,
            'bookingdate'=>now(),
            'numadults'=>$adult,
            'numchildren'=>$child,
            'totalprice'=>$total,

            // ✅ PAYMENT (mới)
            'deposit_amount'=>$deposit,
            'paid_amount'=>0,
            'paymentstatus'=>'unpaid',

            // ✅ BOOKING
            'bookingstatus'=>'pending',

            'paymentmethod'=>$payment,
            'specialrequest'=>$info
        ]);

        $bookingId = DB::getPdo()->lastInsertId();
// ==========================================
        // GỬI EMAIL NGAY SAU KHI TẠO ĐƠN HÀNG
        // ==========================================
        try {
            // Lấy thông tin chi tiết của tour vừa đặt
            $bookingDetail = DB::table('tbl_bookings')
                ->join('tbl_tours', 'tbl_bookings.tourid', '=', 'tbl_tours.tourid')
                ->where('tbl_bookings.bookingid', $bookingId)
                ->select('tbl_bookings.*', 'tbl_tours.title', 'tbl_tours.startdate')
                ->first();

            // Gắn thêm thông tin khách hàng từ form nhập vào
            $bookingDetail->email = $request->email;
            $bookingDetail->username = $request->username;

            // Kích hoạt gửi mail
            Mail::to($request->email)->send(new BookingConfirmationMail($bookingDetail));
            
        } catch (\Exception $e) {
            // Ghi lại lỗi nếu có trục trặc gửi mail để không làm gián đoạn việc đặt tour của khách
            \Illuminate\Support\Facades\Log::error("Lỗi gửi mail đặt tour ID $bookingId: " . $e->getMessage());
        }

        if($payment == "momo"){
            return redirect('/momo-payment/'.$bookingId);
        }

        History::create([
        'userid' => $userid,
        'actionType' => "Tạo đơn đặt tour mới (ID: $bookingId). Phương thức: " . $request->paymentmethod,
        'timestamp' => now()
    ]);

        return redirect('/booking-history')
        ->with('success','Đặt tour thành công!');
    }


    // =========================
    // MOMO PAYMENT
    // =========================
 public function momo_payment($bookingId)
{
    $booking = DB::table('tbl_bookings')
        ->where('bookingid',$bookingId)
        ->first();

    if(!$booking){
        return back()->with('error','Không tồn tại booking');
    }

    if($booking->paymentstatus != 'unpaid'){
        return back()->with('error','Đã thanh toán rồi');
    }

    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

    $partnerCode = "MOMO3PZW20250404_TEST";
    $accessKey = "aCkRGYFnwrlAxV6O";
    $secretKey = "BfyQQNQty1udFv5UNh4WoOrHTbK2HGYD";

    $orderInfo = "Thanh toán tour";

    // 🔥 FIX QUAN TRỌNG
    $amount = (int)$booking->deposit_amount;

    $orderId = time()."_".$bookingId;
    $requestId = $orderId;

    $redirectUrl = url('/momo-return/'.$bookingId);
    $ipnUrl = url('/momo-return/'.$bookingId);

    $extraData = "";

    $rawHash =
        "accessKey=".$accessKey.
        "&amount=".$amount.
        "&extraData=".$extraData.
        "&ipnUrl=".$ipnUrl.
        "&orderId=".$orderId.
        "&orderInfo=".$orderInfo.
        "&partnerCode=".$partnerCode.
        "&redirectUrl=".$redirectUrl.
        "&requestId=".$requestId.
        "&requestType=captureWallet";

    $signature = hash_hmac("sha256", $rawHash, $secretKey);

    $data = [
        'partnerCode'=>$partnerCode,
        'requestId'=>$requestId,
        'amount'=>$amount,
        'orderId'=>$orderId,
        'orderInfo'=>$orderInfo,
        'redirectUrl'=>$redirectUrl,
        'ipnUrl'=>$ipnUrl,
        'requestType'=>"captureWallet",
        'extraData'=>$extraData,
        'signature'=>$signature,

        // 🔥 FIX thêm
        'lang' => 'vi'
    ];

    $result = $this->execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true);

    // DEBUG
    if(!isset($jsonResult['payUrl'])){
        dd($jsonResult);
    }

    return redirect($jsonResult['payUrl']);
}



    private function execPostRequest($url,$data)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_HTTPHEADER,[
            'Content-Type: application/json'
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }


    // =========================
    // MOMO RETURN
    // =========================
   public function momo_return(Request $request, $bookingId)
{
    // Nếu ID bị dính chữ (ví dụ 21resultCode=0), ta chỉ lấy phần số
    $cleanId = preg_replace('/[^0-9]/', '', $bookingId);

    if ($request->resultCode == 0) {
        // Kiểm tra xem booking có tồn tại không
        $booking = DB::table('tbl_bookings')->where('bookingid', $cleanId)->first();
        
        if ($booking) {
            DB::table('tbl_bookings')
                ->where('bookingid', $cleanId)
                ->update([
                    'paymentstatus' => 'deposit_paid',
                    // Cập nhật số tiền thực tế đã thu (lấy từ MoMo gửi về hoặc từ cột deposit)
                    'paid_amount'   => $booking->deposit_amount > 0 ? $booking->deposit_amount : ($booking->totalprice * 0.3),
                    'bookingstatus' => 'confirmed'
                ]);

            // Ghi lịch sử
            DB::table('tbl_history')->insert([
                'userid'     => session('userid'),
                'actionType' => "Thanh toán đặt cọc thành công đơn hàng #$cleanId",
                'timestamp'  => now()
            ]);

    // ==========================================

            return redirect('/booking-history')->with('success', 'Đặt cọc thành công!');
        }
    }

    return redirect('/booking-history')->with('error', 'Thanh toán không thành công');
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
        ->where('tbl_bookings.userid',$userid)
        ->select(
            'tbl_bookings.*',
            'tbl_tours.title',
            'tbl_tours.startdate'
        )
        ->orderBy('bookingdate','desc')
        ->get();

        return view('Clients.booking-history',compact('bookings'));
    }


    // =========================
    // HỦY + HOÀN TIỀN
    // =========================
 // Tận dụng lại Class Mail bạn đang có


    // =========================
    // XÁC NHẬN TIỀN MẶT (ADMIN)
public function cancel(Request $request, $id)
{
    // 1. Lấy dữ liệu (Phải có Username và Email từ bảng users)
    $booking = DB::table('tbl_bookings')
        ->join('tbl_tours', 'tbl_bookings.tourid', '=', 'tbl_tours.tourid')
        ->join('tbl_users', 'tbl_bookings.userid', '=', 'tbl_users.userid')
        ->where('bookingid', $id)
        ->select('tbl_bookings.*', 'tbl_tours.title', 'tbl_tours.startdate', 'tbl_users.email', 'tbl_users.username')
        ->first();

    if (!$booking) return back()->with('error', 'Không tìm thấy đơn.');

    try {
        DB::beginTransaction();

        $refundAmount = 0;
        // KHAI BÁO BIẾN TRƯỚC ĐỂ TRÁNH LỖI UNDEFINED
        $paymentStatus = $booking->paymentstatus; 

        if ($booking->paid_amount > 0) {
            $daysToStart = (strtotime($booking->startdate) - time()) / (60 * 60 * 24);

            if ($daysToStart >= 5) {
                $refundAmount = $booking->paid_amount; 
            } elseif ($daysToStart >= 2) {
                $refundAmount = $booking->paid_amount * 0.5;
            } else {
                $refundAmount = 0;
            }
            $paymentStatus = 'refund_pending'; // Gán giá trị nếu có hoàn tiền
        }

        // 2. Cập nhật Database (Dòng 332-337 bạn bị lỗi ở đây)
        DB::table('tbl_bookings')->where('bookingid', $id)->update([
            'bookingstatus' => 'cancelled',
            'paymentstatus' => $paymentStatus, 
            'cancel_reason' => $request->cancel_reason,
            'specialrequest' => $booking->specialrequest . " | REFUND INFO: " . $request->refund_info
        ]);

        // Trả lại chỗ trống
        DB::table('tbl_tours')->where('tourid', $booking->tourid)->increment('quantity', 1);

        // 3. CHUẨN BỊ DỮ LIỆU GỬI MAIL
        // Ép các biến vào object để file Blade nhận được
        $booking->bookingstatus = 'cancelled'; 
        $booking->refund_calculated = $refundAmount;
        $booking->refund_info = $request->refund_info;
        $booking->cancel_reason = $request->cancel_reason;

        // 4. GỬI MAIL (Đảm bảo Mail::to lấy đúng email từ DB)
        Mail::to($booking->email)->send(new \App\Mail\BookingConfirmationMail($booking));

        DB::commit();
        return back()->with('success', 'Hủy tour thành công. Vui lòng kiểm tra email để biết thông tin hoàn tiền nếu có.');
        
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error("LỖI TẠI HÀM CANCEL: " . $e->getMessage());
        return back()->with('error', 'Lỗi: ' . $e->getMessage());
    }
}    // XÁC NHẬN TIỀN MẶT (ADMIN)
    // =========================
    public function confirmCash($id)
    {
        try {
            DB::beginTransaction();

            $booking = DB::table('tbl_bookings')
                ->join('tbl_users', 'tbl_bookings.userid', '=', 'tbl_users.userid')
                ->join('tbl_tours', 'tbl_bookings.tourid', '=', 'tbl_tours.tourid')
                ->where('bookingid', $id)
                ->select('tbl_bookings.*', 'tbl_users.email', 'tbl_users.username', 'tbl_tours.title', 'tbl_tours.startdate')
                ->first();

            if (!$booking) return back()->with('error', 'Không tìm thấy đơn hàng.');

            // Cập nhật thu đủ 100% tiền mặt
            DB::table('tbl_bookings')->where('bookingid', $id)->update([
                'paymentstatus' => 'paid',
                'paid_amount' => $booking->totalprice,
                'bookingstatus' => 'confirmed'
            ]);

            // Ghi nhật ký
            DB::table('tbl_history')->insert([
                'userid' => \Illuminate\Support\Facades\Auth::id() ?? 3,
                'actionType' => "Admin xác nhận thu tiền mặt đơn #$id",
                'timestamp' => now()
            ]);

            // Gửi mail
            try {
                $booking->paymentstatus = 'paid';
                \Illuminate\Support\Facades\Mail::to($booking->email)->send(new \App\Mail\BookingConfirmationMail($booking));
            } catch (\Exception $e) {}

            DB::commit();
            return back()->with('success', 'Xác nhận thu tiền mặt thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
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
        ->where('bookingid',$id)
        ->where('tbl_bookings.userid',$userid)
        ->select(
            'tbl_bookings.*',
            'tbl_tours.title',
            'tbl_tours.startdate',
            'tbl_tours.location'
        )
        ->first();

        return view('Clients.booking-detail',compact('booking'));
    }

}