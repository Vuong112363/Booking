<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB; // Nhớ import thư viện DB

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {

        // 1. Nếu chưa có session (chưa đăng nhập)
        if(!session()->has('userid')){
            return redirect('/login')->with('error','Vui lòng đăng nhập để tiếp tục');
        }

        /*
        |--------------------------------------------------------------------------
        | KIỂM TRA QUYỀN TRỰC TIẾP TỪ DATABASE (REAL-TIME)
        |--------------------------------------------------------------------------
        | Lấy dữ liệu mới nhất của user từ DB thay vì dùng session cũ
        */
        $user = DB::table('tbl_users')
            ->where('userid', session('userid'))
            ->first();

        // 2. Nếu tài khoản không tồn tại, bị khóa (status = 0), hoặc role không phải 1
        if(!$user || $user->status != 1 || $user->role != 1){
            
            // Tùy chọn: Đồng bộ lại session role cho đúng thực tế hiện tại
            if($user) {
                session(['role' => $user->role]);
            }

            abort(403,'Bạn không có quyền truy cập trang Quản trị');
        }

        return $next($request);
    }
}