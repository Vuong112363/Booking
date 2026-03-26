<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập / Đăng ký | Go Viet</title>

    <link rel="stylesheet" href="{{ asset('clients/assets/css/CSS-login/fonts/material-icon/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('clients/assets/css/CSS-login/style.css') }}">

    <style>
        /* ==========================================================================
           GOVIET PREMIUM LOGIN/REGISTER UI 2026
           ========================================================================== */
        :root {
            --gv-primary: #ff5722;
            --gv-primary-hover: #e64a19;
            --gv-text-dark: #0f172a;
        }

        body {
            /* Lớp phủ gradient làm tối nền ảnh để Form nổi bật hơn */
            background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.8)),
                        url('{{ asset("clients/assets/images/banner/banner.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            font-family: 'Outfit', sans-serif;
        }

        .main {
            padding-top: 120px;
            padding-bottom: 50px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Hiệu ứng Kính mờ (Glassmorphism) cho Container */
        .container {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border-radius: 24px !important;
            box-shadow: 0 30px 60px rgba(0,0,0,0.4) !important;
            border: 1px solid rgba(255,255,255,0.5) !important;
            overflow: hidden;
            width: 900px;
            max-width: 95%;
            transition: all 0.4s ease;
        }

        /* Ẩn mặc định */
        #signup-section, #forgot-section { display: none; }

        /* Animation chuyển tab mượt mà */
        .fade-in { animation: smoothSlideIn 0.5s cubic-bezier(0.165, 0.84, 0.44, 1) forwards; }

        @keyframes smoothSlideIn {
            from { opacity: 0; transform: translateY(30px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* --- NÂNG CẤP FORM INPUTS --- */
        .form-title {
            color: var(--gv-text-dark) !important;
            font-weight: 900 !important;
            font-size: 32px !important;
            margin-bottom: 30px !important;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px !important;
        }

        .form-group label {
            position: absolute !important;
            left: 20px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            color: #888 !important;
            font-size: 18px !important;
        }

        .form-group input:not([type="checkbox"]) {
            width: 100% !important;
            background: #f8f9fa !important;
            border: 1px solid #e2e8f0 !important;
            padding: 16px 20px 16px 50px !important; /* Dịch chữ sang phải chừa chỗ cho icon */
            border-radius: 50px !important;
            font-size: 15px !important;
            font-family: 'Outfit', sans-serif !important;
            color: #333 !important;
            transition: all 0.3s ease !important;
            box-sizing: border-box !important;
        }

        .form-group input:not([type="checkbox"]):focus {
            background: #ffffff !important;
            border-color: var(--gv-primary) !important;
            box-shadow: 0 0 0 4px rgba(255, 87, 34, 0.15) !important;
            outline: none !important;
        }

        /* --- NÂNG CẤP NÚT BẤM (BUTTONS) --- */
        .form-submit {
            background: linear-gradient(135deg, var(--gv-primary), #ff7a50) !important;
            color: #fff !important;
            border: none !important;
            padding: 16px 30px !important;
            border-radius: 50px !important;
            font-weight: 800 !important;
            font-size: 16px !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            width: 100% !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 10px 20px rgba(255, 87, 34, 0.3) !important;
        }

        .form-submit:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 15px 25px rgba(255, 87, 34, 0.4) !important;
        }

        /* --- MẠNG XÃ HỘI (SOCIAL LOGIN) --- */
        .social-login {
            margin-top: 30px !important;
            display: flex !important;
            gap: 15px !important;
            justify-content: center !important;
        }

        .social-login a {
            flex: 1 !important; /* Chia đều 2 nút */
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 12px 20px !important;
            border-radius: 50px !important;
            color: white !important;
            text-decoration: none !important;
            font-weight: 700 !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
        }

        .social-login a i { margin-right: 8px !important; font-size: 18px !important; }
        .social-login .google { background: #db4437 !important; }
        .social-login .facebook { background: #1877f2 !important; }
        .social-login a:hover { transform: translateY(-3px) !important; filter: brightness(1.1) !important; }

        /* --- CẢNH BÁO (ALERTS) --- */
        .alert-container { width: 100%; max-width: 900px; margin: 0 auto 20px auto; }
        .alert {
            text-align: center; margin-bottom: 15px; padding: 15px 20px;
            border-radius: 12px; font-weight: 700; font-size: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            animation: slideDown 0.5s ease-out;
        }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        
        .alert-success { color: #065f46; background: #d1fae5; border: 1px solid #a7f3d0; }
        .alert-error { color: #991b1b; background: #fee2e2; border: 1px solid #fecaca; }

        /* --- LINK QUY ĐỊNH CHUNG --- */
        .signup-image-link {
            color: #475569 !important; font-weight: 600 !important; font-size: 15px !important;
            text-decoration: none !important; transition: 0.3s !important;
            display: inline-block !important; margin-top: 20px !important;
        }
        .signup-image-link:hover, #link-to-forgot:hover { color: var(--gv-primary) !important; text-decoration: underline !important; }

    </style>
</head>

<body>

    @include('Clients.blocks.header')

    <div class="main">
        <div style="width: 100%; display: flex; flex-direction: column; align-items: center;">
            
            {{-- THÔNG BÁO --}}
            <div class="alert-container">
                @if(session('success'))
                    <div class="alert alert-success"><i class="zmdi zmdi-check-circle me-2"></i> {{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error"><i class="zmdi zmdi-close-circle me-2"></i> {{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">
                        <i class="zmdi zmdi-alert-triangle me-2"></i> Có lỗi xảy ra:
                        <ul style="margin: 5px 0 0 20px; padding: 0; text-align: left;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- ================= SECTION ĐĂNG KÝ ================= --}}
            <section class="signup fade-in" id="signup-section">
                <div class="container">
                    <div class="signup-content">
                        <div class="signup-form">
                            <h2 class="form-title">Tạo Tài Khoản</h2>
                            <form method="POST" action="{{ route('register.post') }}">
                                @csrf
                                <div class="form-group">
                                    <label><i class="zmdi zmdi-account"></i></label>
                                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Tên người dùng" required>
                                </div>
                                <div class="form-group">
                                    <label><i class="zmdi zmdi-email"></i></label>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Địa chỉ Email" required>
                                </div>
                                <div class="form-group">
                                    <label><i class="zmdi zmdi-lock"></i></label>
                                    <input type="password" name="pass" placeholder="Mật khẩu" required>
                                </div>
                                <div class="form-group">
                                    <label><i class="zmdi zmdi-lock-outline"></i></label>
                                    <input type="password" name="re_pass" placeholder="Nhập lại mật khẩu" required>
                                </div>
                                <div class="form-group form-button">
                                    <button type="submit" class="form-submit">Đăng ký ngay</button>
                                </div>
                            </form>
                        </div>
                        <div class="signup-image">
                            <figure><img src="{{ asset('clients/assets/images/logos/login.png') }}" alt="Đăng ký"></figure>
                            <a href="#" class="signup-image-link" id="link-to-signin">Đã có tài khoản? <strong>Đăng nhập tại đây</strong></a>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ================= SECTION ĐĂNG NHẬP ================= --}}
            <section class="sign-in fade-in" id="signin-section" style="display: block;">
                <div class="container">
                    <div class="signin-content">
                        <div class="signin-image">
                            <figure><img src="{{ asset('clients/assets/images/logos/login.png') }}" alt="Đăng nhập"></figure>
                            <a href="#" class="signup-image-link" id="link-to-signup">Người dùng mới? <strong>Tạo tài khoản</strong></a>
                        </div>
                        <div class="signin-form">
                            <h2 class="form-title">Đăng Nhập</h2>
                            <form method="POST" action="{{ route('login.post') }}">
                                @csrf
                                <div class="form-group">
                                    <label><i class="zmdi zmdi-email"></i></label>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Địa chỉ Email" required>
                                </div>
                                <div class="form-group">
                                    <label><i class="zmdi zmdi-lock"></i></label>
                                    <input type="password" name="password" placeholder="Mật khẩu" required>
                                </div>
                                <div class="form-group d-flex justify-content-between align-items-center" style="margin-bottom: 30px !important;">
                                    <div>
                                        <input type="checkbox" name="remember" id="remember-me" class="custom-checkbox">
                                        <label for="remember-me" style="position: static !important; transform: none !important; margin-left: 5px; cursor: pointer; color: #475569 !important;">Ghi nhớ tôi</label>
                                    </div>
                                    <a href="#" id="link-to-forgot" style="color: #475569; text-decoration: none; font-weight: 600; font-size: 14px; transition: 0.3s;">Quên mật khẩu?</a>
                                </div>
                                <div class="form-group form-button">
                                    <button type="submit" class="form-submit">Đăng nhập</button>
                                </div>
                            </form>
                            
                            {{-- Mạng xã hội --}}
                            <div class="social-login">
                                <a href="{{ url('/auth/google') }}" class="google"><i class="zmdi zmdi-google"></i> Google</a>
                                <a href="{{ url('/auth/facebook') }}" class="facebook"><i class="zmdi zmdi-facebook"></i> Facebook</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ================= SECTION QUÊN MẬT KHẨU ================= --}}
            <section class="sign-in fade-in" id="forgot-section">
                <div class="container">
                    <div class="signin-content">
                        <div class="signin-image">
                            <figure><img src="{{ asset('clients/assets/images/login/signin-image.jpg') }}" onerror="this.src='{{ asset('clients/assets/images/logos/login.png') }}'" alt="Quên mật khẩu"></figure>
                            <a href="#" class="signup-image-link" id="back-login"><i class="zmdi zmdi-arrow-left me-1"></i> Quay lại đăng nhập</a>
                        </div>
                        <div class="signin-form">
                            <h2 class="form-title">Khôi Phục Mật Khẩu</h2>
                            <p style="margin-bottom: 25px; color: #64748b; line-height: 1.5;">Vui lòng nhập địa chỉ email đã đăng ký. Chúng tôi sẽ gửi một liên kết an toàn để bạn đặt lại mật khẩu mới.</p>
                            <form method="POST" action="{{ route('password.send') }}">
                                @csrf
                                <div class="form-group">
                                    <label><i class="zmdi zmdi-email"></i></label>
                                    <input type="email" name="email" placeholder="Nhập email của bạn" required>
                                </div>
                                <div class="form-group form-button">
                                    <button type="submit" class="form-submit">Gửi liên kết khôi phục</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const signup = document.getElementById('signup-section');
            const signin = document.getElementById('signin-section');
            const forgot = document.getElementById('forgot-section');

            // Hàm dùng chung để chuyển đổi mượt mà
            function switchTab(showElement) {
                // Remove fade-in to reset animation
                [signup, signin, forgot].forEach(el => {
                    el.classList.remove('fade-in');
                    el.style.display = 'none';
                });
                
                // Show requested element and trigger animation
                showElement.style.display = 'block';
                // Trigger reflow
                void showElement.offsetWidth; 
                showElement.classList.add('fade-in');
            }

            // Xử lý giữ form Đăng ký nếu có lỗi validation từ server
            @if ($errors->any() && old('name'))
                switchTab(signup);
            @else
                switchTab(signin); // Mặc định hiển thị Đăng nhập
            @endif

            // Gán sự kiện
            document.getElementById('link-to-signup').addEventListener('click', function(e) {
                e.preventDefault(); switchTab(signup);
            });
            document.getElementById('link-to-signin').addEventListener('click', function(e) {
                e.preventDefault(); switchTab(signin);
            });
            document.getElementById('link-to-forgot').addEventListener('click', function(e) {
                e.preventDefault(); switchTab(forgot);
            });
            document.getElementById('back-login').addEventListener('click', function(e) {
                e.preventDefault(); switchTab(signin);
            });
        });
        
    </script>

</body>
</html>