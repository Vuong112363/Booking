<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Setting; 
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan; // Thêm để xóa cache

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('Admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // 1. Xử lý riêng Chế độ bảo trì (Fix lỗi tự động bật lại)
        // Nếu không có trong request (do bỏ tích) thì gán là 0, ngược lại là 1
        $maintenanceMode = $request->has('maintenance_mode') ? 1 : 0;
        Setting::updateOrCreate(['key' => 'maintenance_mode'], ['value' => $maintenanceMode]);

        // 2. Loại bỏ các trường file và checkbox bảo trì (đã xử lý ở trên) để loop các text còn lại
        $data = $request->except(['_token', 'hero_banner', 'site_logo', 'site_favicon', 'maintenance_mode']);
        
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // 3. Xử lý lưu ảnh Banner (Thư mục: clients/assets/images/banner)
        if ($request->hasFile('hero_banner')) {
            $this->uploadFile($request, 'hero_banner', 'clients/assets/images/banner', 'hero_');
        }

        // 4. Xử lý lưu LOGO (Thư mục: clients/assets/images/logos)
        if ($request->hasFile('site_logo')) {
            $this->uploadFile($request, 'site_logo', 'clients/assets/images/logos', 'logo_');
        }

        // 5. Xử lý lưu FAVICON (Thư mục: clients/assets/images/logos)
        if ($request->hasFile('site_favicon')) {
            $this->uploadFile($request, 'site_favicon', 'clients/assets/images/logos', 'favicon_');
        }

        // --- QUAN TRỌNG: Xóa cache cấu hình để Laravel nhận diện giá trị mới ngay lập tức ---
        Artisan::call('config:clear');

        return back()->with('success', 'Cập nhật cài đặt hệ thống thành công!');
    }

    /**
     * Hàm phụ trợ để xử lý upload file, xóa file cũ và lưu DB
     */
    private function uploadFile($request, $key, $folder, $prefix)
    {
        $oldSetting = Setting::where('key', $key)->first();
        if ($oldSetting && $oldSetting->value) {
            $oldPath = public_path($oldSetting->value);
            if (File::exists($oldPath)) {
                File::delete($oldPath); 
            }
        }

        $file = $request->file($key);
        $fileName = $prefix . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($folder), $fileName);
        
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $folder . '/' . $fileName]
        );
    }
}