<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    // Ép kiểu về số để so sánh cho chính xác
    $isMaintenance = (int) config('app.maintenance_mode');

    if ($isMaintenance === 1 && !$request->is('admin*')) {
        // Hãy chắc chắn bạn đã có file: resources/views/Clients/errors/maintenance.blade.php
        return response()->view('Clients.errors.maintenance', [], 503);
    }

    return $next($request);
}
}
