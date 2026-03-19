<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{



// danh sách user
public function index()
{
    $users = DB::table('tbl_users')->get();

    return view('admin.users.index',compact('users'));
}



// khóa user
public function block($id)
{
    DB::table('tbl_users')
    ->where('userid',$id)
    ->update(['status'=>0]);

    return redirect()->back();
}


// mở user
public function active($id)
{
    DB::table('tbl_users')
    ->where('userid',$id)
    ->update(['status'=>1]);

    return redirect()->back();
}

public function makeAdmin($id)
{
    DB::table('tbl_users')
        ->where('userid', $id)
        ->update(['role' => 1]);

    // nếu user đang login chính là người vừa được cấp quyền
    if (session('user') && session('user')->userid == $id) {
        $user = DB::table('tbl_users')->where('userid', $id)->first();
        session(['user' => $user]);
    }

    return back()->with('success', 'Đã cấp quyền Admin');
}   
public function removeAdmin($id)
{
    DB::table('tbl_users')
        ->where('userid', $id)
        ->update(['role' => 0]);

    // nếu chính user đó đang đăng nhập → cập nhật lại session
    if (session('user') && session('user')->userid == $id) {
        $user = DB::table('tbl_users')->where('userid', $id)->first();
        session(['user' => $user]);
    }

    return back()->with('success', 'Đã thu hồi quyền Admin');
}

// xóa user
public function delete($id)
{
    DB::table('tbl_users')->where('userid',$id)->delete();

    return redirect()->back();
}

}