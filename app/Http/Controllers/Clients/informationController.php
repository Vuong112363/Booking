<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Clients\Login;
use Illuminate\Support\Facades\Hash;
use App\Models\Booking;
use Illuminate\Support\Facades\File;

class informationController extends Controller
{
    public function index()
    {
        $user = Session::get('user');
        if (!$user) return redirect('/login');

        $title = "Hồ sơ cá nhân - " . $user->username;
        
        // Lấy lịch sử đặt tour kèm phân trang (nếu sau này nhiều tour)
        $bookings = Booking::where('userid', $user->userid)
                    ->orderBy('bookingdate', 'desc')
                    ->get();

        return view('Clients.infor', compact('title', 'user', 'bookings'));
    }

    public function update(Request $request)
    {
        $user = Session::get('user');
        
        $request->validate([
            'username' => 'required|string|max:255',
            'phoneNumber' => 'nullable|numeric|digits_between:10,11',
            'address' => 'nullable|string|max:500',
        ], [
            'username.required' => 'Vui lòng nhập họ tên',
            'phoneNumber.numeric' => 'Số điện thoại phải là chữ số',
            'phoneNumber.digits_between' => 'Số điện thoại không hợp lệ'
        ]);

        $data = [
            'username' => $request->username,
            'phoneNumber' => $request->phoneNumber,
            'address' => $request->address
        ];

        Login::where('userid', $user->userid)->update($data);

        // Cập nhật lại Session object
        $user->username = $request->username;
        $user->phoneNumber = $request->phoneNumber;
        $user->address = $request->address;
        Session::put('user', $user);

        return back()->with('success', 'Thông tin cá nhân đã được cập nhật!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|different:old_password',
            'confirm_password' => 'required|same:new_password',
        ], [
            'new_password.min' => 'Mật khẩu mới phải từ 6 ký tự',
            'new_password.different' => 'Mật khẩu mới phải khác mật khẩu cũ',
            'confirm_password.same' => 'Xác nhận mật khẩu không khớp'
        ]);

        $user = Session::get('user');
        $dbUser = Login::where('userid', $user->userid)->first();

        if (!Hash::check($request->old_password, $dbUser->password)) {
            return back()->with('error', 'Mật khẩu hiện tại không chính xác');
        }

        Login::where('userid', $user->userid)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Session::get('user');
        $dbUser = Login::where('userid', $user->userid)->first();

        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu không phải ảnh mặc định
            if ($dbUser->avatar && $dbUser->avatar != 'Noavatar.png') {
                $oldPath = public_path('clients/assets/images/avatars/' . $dbUser->avatar);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('avatar');
            $name = 'avatar_' . $user->userid . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('clients/assets/images/avatars'), $name);

            Login::where('userid', $user->userid)->update(['avatar' => $name]);

            $user->avatar = $name;
            Session::put('user', $user);

            return back()->with('success', 'Ảnh đại diện đã được cập nhật');
        }

        return back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại');
    }
}