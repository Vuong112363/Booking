<?php

use App\Models\Admin\Setting;

if (!function_exists('get_setting')) {
    /**
     * Lấy giá trị cài đặt từ database theo Key
     */
    function get_setting($key, $default = null)
    {
        $setting = Setting::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}