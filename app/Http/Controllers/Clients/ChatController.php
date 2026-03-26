<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Events\ChatMessageSent;

class ChatController extends Controller
{
    // ==========================================
    // 1. LẤY LỊCH SỬ TIN NHẮN KHI MỞ KHUNG CHAT
    // ==========================================
    public function fetchMessages()
    {
        if (!session()->has('userid')) {
            return response()->json(['status' => 'error', 'message' => 'Vui lòng đăng nhập để chat.']);
        }

        $userid = session('userid');
        $now = now();
        $timeout = 60; 

        // BƯỚC 1: KIỂM TRA ĐIỀU KIỆN CHÀO LẠI VÀ LƯU VÀO DB TRƯỚC
        $lastActive = session('bot_last_active');
        
        if (!session()->has('bot_has_greeted') || ($lastActive && $now->diffInMinutes($lastActive) > $timeout)) {
            $welcomeMsg = "Chào bạn! ✨ Tôi là trợ lý AI của GoViet Travel. Tôi có thể giúp bạn tìm tour, báo giá hoặc kiểm tra lịch trình. Bạn muốn đi đâu nào?";
            
            DB::table('tbl_chat')->insert([
                'userid'    => $userid,
                'message'   => $welcomeMsg,
                'isread'    => 'N',
                'adminid'   => 999,
                'createdat' => $now,
                'ipaddress' => request()->ip()
            ]);
            session(['bot_has_greeted' => true]);
        }

        session(['bot_last_active' => $now]);

        // BƯỚC 2: SAU ĐÓ MỚI LẤY LỊCH SỬ TIN NHẮN 
        $messages = DB::table('tbl_chat')
            ->where('userid', $userid)
            ->orderBy('createdat', 'desc')
            ->limit(50)
            ->get();

        $result = $messages->reverse()->values();
        return response()->json(['status' => 'success', 'messages' => $result]);
    }

    // ==========================================
    // 2. XỬ LÝ GỬI TIN NHẮN (USER -> HỆ THỐNG)
    // ==========================================
    public function sendMessage(Request $request)
    {
        if (!session()->has('userid')) {
            return response()->json(['status' => 'error', 'message' => 'Vui lòng đăng nhập để chat.']);
        }

        $userid = session('userid');
        $userMessage = trim($request->input('message'));

        if (empty($userMessage)) {
            return response()->json(['status' => 'error', 'message' => 'Tin nhắn không được để trống.']);
        }

        // Lưu tin nhắn user
        DB::table('tbl_chat')->insert([
            'userid' => $userid,
            'message' => $userMessage,
            'isread' => 'N',
            'adminid' => 0,
            'createdat' => now(),
            'ipaddress' => $request->ip()
        ]);
        event(new ChatMessageSent($userid, $userMessage, 'msg-user'));

        // ==========================================
        // PHÂN LUỒNG ADMIN VÀ BOT
        // ==========================================
        $botKeywords = ['gặp bot', 'chat với bot', 'thoát admin', 'hủy admin', 'gọi bot', 'bot ơi','bot', 'trợ lý', 'trợ giúp', 'tư vấn tự động'];
        $wantsBot = false;
        foreach ($botKeywords as $word) {
            if (str_contains(mb_strtolower($userMessage), $word)) {
                $wantsBot = true; break;
            }
        }

        $adminKeywords = ['admin', 'nhân viên', 'người thật', 'tư vấn', 'hỗ trợ', 'gặp người','gặp admin'];
        $wantsAdmin = false;
        foreach ($adminKeywords as $word) {
            if (str_contains(mb_strtolower($userMessage), $word)) {
                $wantsAdmin = true; break;
            }
        }

        $lastBotCallTime = DB::table('tbl_chat')
            ->where('userid', $userid)
            ->where(function($query) use ($botKeywords) {
                foreach($botKeywords as $word) {
                    $query->orWhere('message', 'LIKE', '%' . $word . '%');
                }
            })
            ->max('createdat') ?? '2000-01-01 00:00:00';

        $isWaitingAdmin = DB::table('tbl_chat')
            ->where('userid', $userid)
            ->where(function($query) {
                $query->where('message', 'LIKE', '%gặp admin%')->orWhere('message', 'LIKE', '%nhân viên%');
            })
            ->where('createdat', '>', now()->subHours(2))
            ->where('createdat', '>', $lastBotCallTime)
            ->exists();

        $adminJoined = DB::table('tbl_chat')
            ->where('userid', $userid)
            ->whereNotIn('adminid', [0, 999])
            ->where('createdat', '>', now()->subMinutes(30))
            ->where('createdat', '>', $lastBotCallTime)
            ->exists();

        if ($wantsBot) {
            $replyMessage = 'Đã ngắt kết nối với Admin. Trợ lý AI GoViet đã quay lại, tôi có thể giúp gì cho bạn?';
            $this->saveBotMessage($userid, $replyMessage);
            return response()->json(['status' => 'success', 'reply' => $replyMessage, 'sender' => 'bot']);
        }

        if ($wantsAdmin) {
            $replyMessage = 'Đã gửi yêu cầu. Chuyên viên tư vấn của GoViet sẽ vào hỗ trợ bạn ngay nhé!';
            $this->saveBotMessage($userid, $replyMessage);
            return response()->json(['status' => 'success', 'reply' => $replyMessage, 'sender' => 'bot']);
        }

        if ($isWaitingAdmin || $adminJoined) {
            return response()->json(['status' => 'success', 'reply' => '', 'sender' => 'bot']);
        }
        
        // ==============================================================================
        // AI NÂNG CẤP: LỌC DỮ LIỆU ĐA CHIỀU (ĐIỂM ĐẾN, THỜI GIAN, LỊCH TRÌNH)
        // ==============================================================================
        try {
            // 1. LỌC ĐIỂM ĐẾN
            $popularDestinations = ['đà lạt', 'sapa', 'nha trang', 'đà nẵng', 'phú quốc', 'hạ long', 'thái lan', 'hàn quốc', 'nhật bản', 'hà nội', 'hồ chí minh'];
            $targetDestination = '';
            foreach ($popularDestinations as $dest) {
                if (str_contains(mb_strtolower($userMessage), $dest)) {
                    $targetDestination = $dest; break;
                }
            }

            // 2. LỌC THỜI GIAN (Bắt cụm từ "tháng 5", "t10", v.v.)
            $targetMonth = null;
            $targetYear = now()->year;
            if (preg_match('/th[aá]ng\s*(\d{1,2})/i', $userMessage, $matches) || preg_match('/t(\d{1,2})/i', $userMessage, $matches)) {
                $month = (int)$matches[1];
                if ($month >= 1 && $month <= 12) {
                    $targetMonth = $month;
                    if ($targetMonth < now()->month) $targetYear++; // Nếu qua tháng đó rồi thì lấy năm sau
                }
            }

            // 3. KIỂM TRA XEM KHÁCH CÓ HỎI LỊCH TRÌNH KHÔNG
            $wantsTimeline = preg_match('/lịch trình|đi đâu|chi tiết|làm gì|chương trình/i', $userMessage);

            // 4. LẤY MÃ GIẢM GIÁ (Viết tắt)
            $promotions = DB::table('tbl_promotion')
                ->where('startdate', '<=', now())
                ->where('enddate', '>=', now())
                ->where('quantity', '>', 0)
                ->select('code as Ma', 'discount_percent as Giam', 'enddate as HSD')
                ->get();
            $promoInfo = json_encode($promotions, JSON_UNESCAPED_UNICODE);

            // 5. TRUY VẤN TOUR CỰC KỲ TỐI ƯU
            $query = DB::table('tbl_tours')
                ->where('availability', 1)
                ->whereExists(function ($query) use ($targetMonth, $targetYear) {
                    $subQuery = $query->select(DB::raw(1))
                          ->from('tbl_tour_schedules')
                          ->whereColumn('tbl_tour_schedules.tourid', 'tbl_tours.tourid')
                          ->where('startdate', '>=', now()->toDateString())
                          ->where('quantity', '>', 0);
                    
                    if ($targetMonth) {
                        $subQuery->whereMonth('startdate', $targetMonth)
                                 ->whereYear('startdate', $targetYear);
                    }
                });

            if (!empty($targetDestination)) {
                $query->where('destination', 'LIKE', '%' . $targetDestination . '%');
                $query->limit(4); 
            } else {
                $query->limit(2); // Giới hạn chặt để đỡ tốn token nếu khách chỉ "hi"
            }

            $tours = $query->select('tourid', 'title as Ten', 'time as TG')->get();

            foreach ($tours as $tour) {
                // Lấy lịch khởi hành theo tháng đã chọn
                $scheduleQuery = DB::table('tbl_tour_schedules')
                    ->where('tourid', $tour->tourid)
                    ->where('startdate', '>=', now()->toDateString())
                    ->where('quantity', '>', 0);
                
                if ($targetMonth) {
                    $scheduleQuery->whereMonth('startdate', $targetMonth)
                                  ->whereYear('startdate', $targetYear);
                }

                $tour->Lich = $scheduleQuery->select('startdate as Ngay', 'priceadult as GiaNL', 'pricechild as GiaTE', 'quantity as Cho')->limit(3)->get();

                // NẾU KHÁCH YÊU CẦU LỊCH TRÌNH -> MỚI QUERY DB VÀ ĐƯA VÀO JSON
                if ($wantsTimeline) {
                    $timelines = DB::table('tbl_timeline')->where('tourid', $tour->tourid)->select('title')->get();
                    $tour->Trinh = $timelines->pluck('title')->implode(' | ');
                }

                unset($tour->tourid);
            }
            $tourInfo = json_encode($tours, JSON_UNESCAPED_UNICODE);

            // 6. XÂY DỰNG LỊCH SỬ HỘI THOẠI
            $chatHistory = DB::table('tbl_chat')
                ->where('userid', $userid)->orderBy('createdat', 'desc')->limit(6)->get()->reverse();

            $contents = [];
            $lastRole = null;

            foreach ($chatHistory as $msg) {
                if (str_contains($msg->message, 'Admin sẽ vào') || str_contains($msg->message, 'Đã ngắt kết nối') || str_contains($msg->message, 'Đã gửi yêu cầu')) continue;
                $role = ($msg->adminid == 0) ? "user" : "model";
                
                if ($role === $lastRole && count($contents) > 0) {
                    $lastIndex = count($contents) - 1;
                    $contents[$lastIndex]["parts"][0]["text"] .= "\n" . $msg->message;
                } else {
                    $contents[] = ["role" => $role, "parts" => [["text" => $msg->message]]];
                    $lastRole = $role;
                }
            }

            if ($lastRole === "user" && count($contents) > 0) {
                $lastIndex = count($contents) - 1;
                $contents[$lastIndex]["parts"][0]["text"] .= "\n" . $userMessage;
            } else {
                $contents[] = ["role" => "user", "parts" => [["text" => $userMessage]]];
            }

            while (!empty($contents) && $contents[0]['role'] !== 'user') array_shift($contents); 
            if (empty($contents)) $contents[] = ["role" => "user", "parts" => [["text" => $userMessage]]];

            // 7. SYSTEM INSTRUCTION MỚI
            $payload = [
                "system_instruction" => [
                    "parts" => [
                        [
                            "text" => "Bạn là trợ lý du lịch GoViet Travel. Kho dữ liệu:
[TOUR]: {$tourInfo}
[KHUYẾN MÃI]: {$promoInfo}

Quy tắc:
- Dựa vào [TOUR] báo giá người lớn (GiaNL), trẻ em (GiaTE), ngày đi (Ngay), thời gian (TG), số chỗ còn (Cho).
- Nếu [TOUR] rỗng (VD: []), phải xin lỗi và báo không có tour phù hợp. KHÔNG TỰ BỊA TOUR.
- Nếu khách hỏi lịch trình, hãy đọc (Trinh). Nếu không có (Trinh) trong dữ liệu, hãy hỏi lại: 'Bạn có muốn xem lịch trình chi tiết của tour này không?'
- Format giá có dấu chấm (VD: 1.500.000 VNĐ).
- Tính tổng tiền nếu khách cho biết số lượng người.
- Ngắn gọn, thân thiện."
                        ]
                    ]
                ],
                "contents" => $contents,
                "generationConfig" => ["temperature" => 0.2, "maxOutputTokens" => 1200]
            ];
                $geminiApiKey = DB::table('settings')->where('key', 'gemini_api_key')->value('value');
            if (empty($geminiApiKey)) {
                $geminiApiKey = env('GEMINI_API_KEY'); 
            }
            // 8. GỌI API GEMINI (Đã tăng Timeout lên 30s)
            $response = Http::withoutVerifying()->timeout(30)->withHeaders([
                'Content-Type' => 'application/json'
            ])->post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $geminiApiKey,
                $payload
            );

            $data = $response->json();
            if (isset($data['error'])) throw new \Exception($data['error']['message']);

            $aiReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Xin lỗi, bạn nói rõ hơn được không?';
            $aiReply = str_replace(['***', '**', '*', '#', '`'], '', $aiReply);
            $aiReply = trim($aiReply);

        } catch (\Exception $e) {
            Log::error("Gemini Error: " . $e->getMessage());
            $aiReply = "Xin lỗi, hiện tại tôi đang gặp chút trục trặc kỹ thuật nên chưa thể trả lời bạn được. Bạn vui lòng thử lại sau nhé!";
        }

        $this->saveBotMessage($userid, $aiReply);

        return response()->json(['status' => 'success', 'reply' => $aiReply, 'sender' => 'bot']);
    }

    // ==========================================
    // HÀM PHỤ: LƯU TIN NHẮN CỦA BOT VÀO DB
    // ==========================================
    private function saveBotMessage($userid, $message, $isAdmin = false)
    {
        $adminid = $isAdmin ? 1 : 999;
        $senderClass = $isAdmin ? 'msg-admin' : 'msg-bot';
        
        DB::table('tbl_chat')->insert([
            'userid' => $userid,
            'message' => $message,
            'isread' => 'N',
            'adminid' => $adminid,
            'createdat' => now(),
            'ipaddress' => request()->ip() ?? 'NULL',
        ]);
        event(new ChatMessageSent($userid, $message, $senderClass));
    }
}