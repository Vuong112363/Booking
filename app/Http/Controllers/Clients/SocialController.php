<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Clients\Login;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class SocialController extends Controller
{

    private $users;

    public function __construct()
    {
        $this->users = new Login();
    }

    /*
    ========================
    LOGIN GOOGLE
    ========================
    */

    public function google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {

        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = $this->users
            ->where('email', $googleUser->email)
            ->first();

        /* nếu chưa có user thì tạo */
        if (!$user) {
            $user = $this->users->create([
                'username' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(Str::random(16)),
                'provider' => 'google',
                'provider_id' => $googleUser->id,
                'IpAdress' => request()->ip(),
                'isActive' => 1,
                'status' => 1,
                'role' => 0 // Thêm role mặc định là 0 (User) cho chắc chắn
            ]);
        }

        // BỔ SUNG ĐẦY ĐỦ SESSION TẠI ĐÂY
        Session::put('userid', $user->userid); // Đảm bảo tên cột id của bạn là userid
        Session::put('username', $user->username);
        Session::put('role', $user->role ?? 0);
        Session::put('user', $user);

        // Kiểm tra luôn nếu nó là Admin thì redirect thẳng vào trang admin cũng được
        if(Session::get('role') == 1){
            return redirect('/admin/dashboard')->with('success', 'Đăng nhập Google bằng tài khoản Admin thành công');
        }

        return redirect('/')->with('success', 'Đăng nhập Google thành công');

    }


    /*
    ========================
    LOGIN FACEBOOK
    ========================
    */

    public function facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
        try {
            $fbUser = Socialite::driver('facebook')
                ->stateless()
                ->user();
        } catch (\Exception $e) {
            return redirect('/login')
                ->with('error', 'Đăng nhập Facebook thất bại, vui lòng thử lại');
        }

        $email = $fbUser->email ?? $fbUser->id . '@facebook.com';

        $user = $this->users
            ->where('email', $email)
            ->first();

        if (!$user) {
            $user = $this->users->create([
                'username' => $fbUser->name,
                'email' => $email,
                'password' => bcrypt(\Str::random(16)),
                'provider' => 'facebook',
                'provider_id' => $fbUser->id,
                'IpAdress' => request()->ip(),
                'isActive' => 1,
                'status' => 1,
                'role' => 0
            ]);
        }

        // BỔ SUNG ĐẦY ĐỦ SESSION TẠI ĐÂY
        Session::put('userid', $user->userid);
        Session::put('username', $user->username);
        Session::put('role', $user->role ?? 0);
        Session::put('user', $user);

        if(Session::get('role') == 1){
            return redirect('/admin/dashboard')->with('success', 'Đăng nhập Facebook bằng tài khoản Admin thành công');
        }

        return redirect('/')
            ->with('success', 'Đăng nhập Facebook thành công');

    }

}