<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckMaintenanceMode
{
    public function handle($request, Closure $next)
    {
        // 1. Lấy giá trị trực tiếp từ Database
        // Giả sử bảng của bạn là 'tbl_settings' và cột là 'key', 'value'
        $maintenance = DB::table('settings')
                        ->where('key', 'maintenance_mode')
                        ->value('value');

        // 2. Kiểm tra điều kiện
        // Nếu bật bảo trì (== 1) VÀ KHÔNG PHẢI là trang Admin
        if ((int)$maintenance === 1 && !$request->is('admin*') && !$request->is('login*')) {
            
            // Ngoại lệ: Nếu bạn muốn Admin đang đăng nhập vẫn xem được web, hãy thêm dòng này:
            if (session()->has('user') && session('user')->role == 1) {
                return $next($request);
            }

            // Trả về giao diện bảo trì
            return response()->view('Clients.errors.maintenance', [], 503);
        }

        return $next($request);
    }
}