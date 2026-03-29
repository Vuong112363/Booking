<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * 1. Danh sách User với Tìm kiếm, Lọc và Thống kê nhanh
     */
    public function index(Request $request)
    {
        $query = DB::table('tbl_users');

        // Lọc theo từ khóa (Tên, Email, SĐT)
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('username', 'LIKE', "%$search%")
                  ->orWhere('email', 'LIKE', "%$search%")
                  ->orWhere('phoneNumber', 'LIKE', "%$search%");
            });
        }

        // Lọc theo vai trò (Admin/User)
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('userid', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * 2. Xem chi tiết hồ sơ (Profile 360 độ)
     * Hiển thị đầy đủ thông tin, lịch sử đặt tour, đánh giá và lịch sử hoạt động.
     */
    public function show($id)
    {
        $user = DB::table('tbl_users')->where('userid', $id)->first();
        if (!$user) return redirect()->route('admin.users.index')->with('error', 'Không tìm thấy người dùng.');

        // Lấy lịch sử Booking của user
        $bookings = DB::table('tbl_bookings')
            ->join('tbl_tours', 'tbl_bookings.tourid', '=', 'tbl_tours.tourid')
            ->where('userid', $id)
            ->select('tbl_bookings.*', 'tbl_tours.title as tour_name')
            ->orderBy('bookingdate', 'desc')
            ->get();

        // Lấy lịch sử Đánh giá
        $reviews = DB::table('tbl_reviews')
            ->join('tbl_tours', 'tbl_reviews.tourid', '=', 'tbl_tours.tourid')
            ->where('userid', $id)
            ->select('tbl_reviews.*', 'tbl_tours.title as tour_name')
            ->get();

        // Lấy Lịch sử hoạt động hệ thống
        $activities = DB::table('tbl_history')
            ->where('userid', $id)
            ->orderBy('timestamp', 'desc')
            ->limit(10)
            ->get();

        return view('admin.users.show', compact('user', 'bookings', 'reviews', 'activities'));
    }

    /**
     * 3. Chỉnh sửa thông tin nhanh
     */
public function update(Request $request, $id)
    {
        $user = DB::table('tbl_users')->where('userid', $id)->first();
        if (!$user) return back()->with('error', 'Người dùng không tồn tại.');

        $updateData = [
            'username'    => $request->username,
            'phoneNumber' => $request->phoneNumber,
            'address'     => $request->address,
            'role'        => $request->role,
            'status'      => $request->status,
        ];

        // Xử lý Upload Avatar vào thư mục bạn yêu cầu
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Đường dẫn XAMPP bạn cung cấp
            $destinationPath = public_path('clients/assets/images/avatars');
            $file->move($destinationPath, $fileName);
            
            $updateData['avatar'] = $fileName;

            // Xóa ảnh cũ
            if ($user->avatar && file_exists($destinationPath . '/' . $user->avatar)) {
                @unlink($destinationPath . '/' . $user->avatar);
            }
        }

        DB::table('tbl_users')->where('userid', $id)->update($updateData);
        $this->logAdminActivity("Cập nhật hồ sơ User ID: $id");

        return redirect()->back()->with('success', 'Thông tin đã được cập nhật!');
    }

    /**
     * 4. Reset mật khẩu về mặc định (Trường hợp user quên hoặc cần cấp lại)
     */
    public function resetPassword($id)
    {
        $defaultPassword = Hash::make('GoViet@123'); // Mật khẩu mặc định mới
        
        DB::table('tbl_users')->where('userid', $id)->update([
            'password' => $defaultPassword
        ]);

        $this->logAdminActivity("Reset mật khẩu cho User ID: $id");

        return redirect()->back()->with('success', 'Mật khẩu đã được đặt lại thành: GoViet@123');
    }

    /**
     * 5. Khóa/Mở tài khoản
     */
    public function toggleStatus($id)
    {
        $user = DB::table('tbl_users')->where('userid', $id)->first();
        $newStatus = ($user->status == 1) ? 0 : 1;
        
        DB::table('tbl_users')->where('userid', $id)->update(['status' => $newStatus]);
        
        $action = $newStatus == 1 ? "Mở khóa" : "Khóa";
        $this->logAdminActivity("$action tài khoản User ID: $id");

        return redirect()->back()->with('success', "Đã $action tài khoản thành công.");
    }

    /**
     * 6. Cấp/Gỡ quyền Admin (Có bảo vệ)
     */
    public function toggleAdmin($id)
    {
        // Chống tự gỡ quyền của bản thân
        if (session('user') && session('user')->userid == $id) {
            return redirect()->back()->with('error', 'Bạn không thể tự thay đổi quyền của chính mình!');
        }

        $user = DB::table('tbl_users')->where('userid', $id)->first();
        $newRole = ($user->role == 1) ? 0 : 1;

        DB::table('tbl_users')->where('userid', $id)->update(['role' => $newRole]);

        $text = ($newRole == 1) ? "Cấp quyền Admin" : "Hạ cấp xuống Thành viên";
        $this->logAdminActivity("$text cho User ID: $id");

        return redirect()->back()->with('success', "Đã $text thành công.");
    }

    /**
     * 7. Xóa vĩnh viễn (Kèm dọn dẹp dữ liệu liên quan)
     */
    public function delete($id)
    {
        if (session('user') && session('user')->userid == $id) {
            return redirect()->back()->with('error', 'Không thể xóa tài khoản đang đăng nhập!');
        }

        try {
            // Xóa các bảng liên quan trước để tránh lỗi khóa ngoại
            DB::table('tbl_history')->where('userid', $id)->delete();
            DB::table('tbl_chat')->where('userid', $id)->delete();
            
            // Thực hiện xóa user
            DB::table('tbl_users')->where('userid', $id)->delete();
            
            return redirect()->route('admin.users.index')->with('success', 'Đã xóa toàn bộ dữ liệu người dùng.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Không thể xóa do user có dữ liệu Booking quan trọng.');
        }
    }
    

    /**
     * Hàm phụ: Ghi nhật ký Admin
     */
    private function logAdminActivity($action)
    {
        $adminId = session('user')->userid ?? 0;
        DB::table('tbl_history')->insert([
            'userid'     => $adminId,
            'actionType' => "ADMIN_ACTION: $action",
            'timestamp'  => now()
        ]);
    }
    
}