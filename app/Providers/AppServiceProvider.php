<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Clients\Tours;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use App\Models\Admin\Setting;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

        //
    
public function boot(): void
{
    \Illuminate\Pagination\Paginator::useBootstrapFive();

    try {
        // Đảm bảo dùng đúng tên bảng 'settings'
        $settings = \DB::table('settings')->pluck('value', 'key');

        if ($settings->isNotEmpty()) {
            // Lấy driver từ DB, nếu trống thì mặc định là 'smtp'
            $driver = $settings['mail_driver'] ?? 'smtp';
            if (empty($driver)) $driver = 'smtp';

            config([
                'mail.default' => $driver, // QUAN TRỌNG: Phải có dòng này
                'mail.mailers.smtp.host'       => $settings['mail_host'] ?? 'smtp.gmail.com',
                'mail.mailers.smtp.port'       => (int)($settings['mail_port'] ?? 587),
                'mail.mailers.smtp.username'   => $settings['mail_username'] ?? '',
                'mail.mailers.smtp.password'   => str_replace(' ', '', $settings['mail_password'] ?? ''),
                'mail.mailers.smtp.encryption' => $settings['mail_encryption'] ?? 'tls',
                'mail.from.address'            => $settings['mail_username'] ?? '',
                'mail.from.name'               => $settings['site_name'] ?? 'GoViet Travel',
            ]);
        }
    } catch (\Exception $e) {
        // Tránh lỗi khi chạy migrate
    }
    // TỰ ĐỘNG TRUYỀN BIẾN CHO SIDEBAR TOUR
        View::composer(
        ['Clients.blocks.sidebar-tour', 'clients.blocks.sidebar-tour', 'clients.blocks.sidebar_tour'], 
        function ($view) {
            $popularWidgetTours = \App\Models\Clients\Tours::where('availability', 1)
                                      ->with('schedules')
                                      ->inRandomOrder() 
                                      ->take(1)
                                      ->get();

            $view->with('popularWidgetTours', $popularWidgetTours);
        }
    );
    }
}

