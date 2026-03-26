<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clients\Login;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    private $users;

    public function __construct()
    {
        $this->users = new Login();
    }

    /*
    =============================
    HIỂN THỊ LOGIN PAGE
    =============================
    */

public function index()
    {
        // 1. KIỂM TRA NGAY LÚC TRUY CẬP TRANG
        if (Session::has('userid')) {
            // Nếu có session (đã đăng nhập) -> Đá về trang chủ ngay lập tức
            return redirect('/')->with('error', 'Bạn đã đăng nhập rồi, không thể vào lại trang này!');
        }

        // 2. NẾU CHƯA ĐĂNG NHẬP -> Mới hiển thị View
        return view('Clients.login');
    }

    /*
    =============================
    REGISTER
    =============================
    */

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:tbl_users,email',
            'pass' => 'required|min:6',
            're_pass' => 'required|same:pass'
        ],[
            'name.required' => 'Vui lòng nhập tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được đăng ký',
            'pass.required' => 'Vui lòng nhập mật khẩu',
            'pass.min' => 'Mật khẩu phải ít nhất 6 ký tự',
            're_pass.same' => 'Mật khẩu nhập lại không khớp'
        ]);


        $data = [

            'username' => $request->name,

            'email' => $request->email,

            'password' => Hash::make($request->pass),

            'phoneNumber' => '',

            'address' => '',

            'IpAdress' => $request->ip(),

            'isActive' => 1,

            'status' => 1,
            'role' => 0 // mặc định là user

        ];


        $this->users->insertUser($data);


        return redirect()->back()->with('success','Đăng ký thành công');

    }



    /*
    =============================
    LOGIN
    =============================
    */

    public function login(Request $request)
    {
        
        $request->validate([

            'email' => 'required|email',

            'password' => 'required'

        ],[

            'email.required' => 'Vui lòng nhập email',

            'password.required' => 'Vui lòng nhập mật khẩu'

        ]);


        $user = $this->users->getUserByEmail($request->email);


        if(!$user)
        {
            return back()->with('error','Email không tồn tại');
        }


        if(!Hash::check($request->password,$user->password))
        {
            return back()->with('error','Sai mật khẩu');
        }
        if($user->status != 1){
                return back()->with('error','Tài khoản đã bị khóa');
            }




        Session::put('userid',$user->userid);
        Session::put('username',$user->username);
        Session::put('role',$user->role);
        Session::put('user',$user);



        $this->users->updateLoginIp($user->userid);

        if($user->role == 1){
            return redirect('/')
            ->with('success','Đăng nhập Admin thành công');
        }

        return redirect('/')
        ->with('success','Đăng nhập thành công');



    }



    /*
    =============================
    LOGOUT
    =============================
    */

public function logout()
{
    Session::forget('bot_has_greeted'); // Xóa riêng cờ lời chào
    Session::flush();

    return redirect('/')->with('success','Đã đăng xuất');
}


    /*
    =============================
    FORGOT PASSWORD
    =============================
    */

public function sendReset(Request $request)
{

    $request->validate([
        'email' => 'required|email'
    ]);

    $user = $this->users->getUserByEmail($request->email);

    if(!$user){
        return back()->with('error','Email không tồn tại');
    }

    // token + timestamp
    $token = Str::random(40).'_'.time();

    $this->users->saveResetToken($request->email,$token);

    $link = url('/reset-password/'.$token);

    Mail::raw("Click vào link để đặt lại mật khẩu: ".$link, function($message) use ($request){
        $message->to($request->email)
        ->subject('Reset Password - GoViet');
    });

    return back()->with('success','Đã gửi link reset mật khẩu về Mail của bạn');

}



    /*
    =============================
    RESET PAGE
    =============================
    */

    public function resetPage($token)
    {

        $user = $this->users->getUserByToken($token);

        if(!$user){
            return redirect('/login')->with('error','Link không hợp lệ');
        }

        $parts = explode('_',$token);
        $time = $parts[1] ?? 0;

        if(time() - $time > 900){
            return redirect('/login')->with('error','Link reset đã hết hạn');
        }

        return view('Clients.reset-password',compact('token'));

    }


    /*
    =============================
    UPDATE PASSWORD
    =============================
    */

    public function updatePassword(Request $request)
    {

        $request->validate([
            'password' => 'required|min:6|confirmed'
        ],[
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải ít nhất 6 ký tự',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp'
        ]);


        $this->users->updatePassword($request->token,$request->password);


        return redirect('/login')->with('success','Đổi mật khẩu thành công');

    }
}