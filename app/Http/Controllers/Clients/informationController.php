<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Clients\Login;
use Illuminate\Support\Facades\Hash;
use App\Models\Booking;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

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
        $tours_wishlist = DB::table('favorites')
        ->join('tbl_tours', 'favorites.tourid', '=', 'tbl_tours.tourid')
        ->where('favorites.userid', $user->userid)
        ->select('tbl_tours.*')
        ->paginate(6);
        $tourIds = $tours_wishlist->pluck('tourid')->filter();

    if ($tourIds->isNotEmpty()) {
        // 2. Lấy toàn bộ ảnh của các tour này để tránh lỗi Undefined display_image
        $defaultImages = DB::table('tbl_images')
            ->whereIn('tourid', $tourIds)
            ->get()
            ->groupBy('tourid');

        // 3. Lấy thông tin giá nhỏ nhất (giống bên ToursController)
        $schedulesInfo = DB::table('tbl_tour_schedules')
            ->whereIn('tourid', $tourIds)
            ->whereDate('startdate', '>=', now())
            ->select('tourid', DB::raw('MIN(priceadult) as min_price'))
            ->groupBy('tourid')
            ->get()
            ->keyBy('tourid');

        // 4. Vòng lặp gán dữ liệu vào từng tour
        foreach ($tours_wishlist as $tour) {
            // Gán ảnh
            $tourImage = $defaultImages->get($tour->tourid)?->first();
            $tour->display_image = $tourImage ? $tourImage->imageurl : 'default.jpg';

            // Gán giá
            $schedule = $schedulesInfo->get($tour->tourid);
            $tour->min_price = $schedule ? $schedule->min_price : ($tour->priceadult ?? 0);
        }
    }
        return view('Clients.infor', compact('title', 'user', 'bookings', 'tours_wishlist'));
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