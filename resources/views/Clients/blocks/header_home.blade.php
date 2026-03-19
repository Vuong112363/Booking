<!DOCTYPE html>
<html lang="vi"> 
<head>
<meta charset="utf-8">
<meta name="description" content="Go Viet - Đặt Tour & Du Lịch Chuyên Nghiệp">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>Go Viet - Đặt Tour & Du Lịch Chuyên Nghiệp</title>
<link rel="shortcut icon" href="{{ asset('clients/assets/images/logos/logo.png') }}" type="image/x-icon">

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('clients/assets/css/flaticon.min.css') }}">
<link rel="stylesheet" href="{{ asset('clients/assets/css/fontawesome-5.14.0.min.css') }}">

<link rel="stylesheet" href="{{ asset('clients/assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('clients/assets/css/magnific-popup.min.css') }}">
<link rel="stylesheet" href="{{ asset('clients/assets/css/nice-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('clients/assets/css/aos.css') }}">
<link rel="stylesheet" href="{{ asset('clients/assets/css/slick.min.css') }}">
<link rel="stylesheet" href="{{ asset('clients/assets/css/style.css') }}">


<style>
.custom-user-dropdown { position: relative; display: inline-block; }
.custom-user-menu {
    display: none; position: absolute; right: 0; top: 100%;
    background-color: #ffffff; min-width: 200px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.1);
    z-index: 999; border-radius: 8px; overflow: hidden;
    padding: 0; margin: 0; list-style: none;
}
.custom-user-menu li { border-bottom: 1px solid #f1f1f1; }
.custom-user-menu li:last-child { border-bottom: none; }
.custom-user-menu a {
    color: #333333; padding: 12px 20px; text-decoration: none;
    display: block; font-size: 15px; transition: 0.3s;
}
.custom-user-menu a:hover { background-color: #f8f9fa; color: #ff5722; }
.custom-user-dropdown:hover .custom-user-menu { display: block; }
.user-avatar{
    width:56px;
    height:56px;
    border-radius:50%;
    object-fit:cover;
    border:2px solid #ffffff;
    cursor:pointer;
    transition:0.3s;
}

.user-avatar:hover{
    transform:scale(1.1);
}

</style>
</head>
<body>

<div class="page-wrapper">

<header class="main-header header-one white-menu menu-absolute">
    <div class="header-upper py-30 rpy-0">
        <div class="container-fluid clearfix">

            <div class="header-inner rel d-flex align-items-center">
                <div class="logo-outer">
                    <div class="logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('clients/assets/images/logos/logo.png') }}" alt="Logo" title="Logo"></a>
                    </div>
                </div>

                <div class="nav-outer mx-lg-auto ps-xxl-5 clearfix">
                    <nav class="main-menu navbar-expand-lg">
                        <div class="navbar-header">
                            <div class="mobile-logo">
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('clients/assets/images/logos/logo.png') }}" alt="Logo" title="Logo">
                                </a>
                            </div>
                            <button type="button" class="navbar-toggle" data-bs-toggle="collapse" data-bs-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <div class="navbar-collapse collapse clearfix">
                            <ul class="navigation clearfix">
                                <li class="current"><a href="{{ route('home') }}">Trang Chủ</a></li>
                                <li><a href="{{ route('about') }}">Giới Thiệu</a></li>
                                <li class="dropdown"><a href="#">Chuyến Du Lịch</a>
                                    <ul>
                                        <li><a href="{{ route('Tours') }}">Danh Sách Tour</a></li>
                                        <li><a href="{{ route('travel-guides') }}">Hướng Dẫn Viên</a></li>
                                    </ul>
                                </li>
                                <li class="current"><a href="{{ route('destination') }}">Điểm Đến</a></li>
                                <li class="current"><a href="{{ route('contact') }}">Liên Hệ</a></li>
                                <li><a href="{{ route('blogs') }}">Tin Tức</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                
                <div class="d-flex align-items-center py-10">
                    <!-- Nút Tìm kiếm -->
<div class="nav-search me-3">
    <button class="far fa-search" id="toggle-search-btn"></button>
    
    <form action="{{ route('Tours') }}" method="GET" id="search-form" class="hide">
        <input type="text" name="destination" placeholder="Tìm kiếm điểm đến..." class="searchbox" required="">
        <button type="submit" class="searchbutton far fa-search"></button>
    </form>
</div>
                    <a href="{{ route('contact') }}" class="theme-btn style-two bgc-secondary me-3">
                        <span data-hover="Đặt Ngay">Đặt Ngay</span>
                        <i class="fal fa-arrow-right"></i>
                    </a>
                    
                    <div class="user-account-area custom-user-dropdown ms-3">

                        @if(Session::has('user'))
                            <a href="#" class="bg-transparent border-0 rounded text-white text-decoration-none fw-bold p-2">
                                <img src="{{ asset('clients/assets/images/avatars/' . Session::get('user')->avatar) }}" class="user-avatar me-2">
                            </a>

                            <ul class="custom-user-menu">
                                <li>
                                    <a href="{{ route('infor') }}">
                                        <i class="fa-solid fa-address-card me-2"></i>
                                        Thông tin tài khoản
                                    </a>
                                </li>

                                {{-- CHỈ ADMIN MỚI THẤY --}}
                                @if(Session::get('user')->role == 1)
                                    <li>
                                        <a href="/admin/users">
                                            <i class="fa-solid fa-user-shield me-2"></i>
                                            Trang quản trị
                                        </a>
                                    </li>
                                @endif

                                <li>
                                    <a href="{{ route('logout') }}" class="text-danger">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i>
                                        Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        @else
                            <a href="{{ route('login') }}" class="bg-transparent border-0 rounded p-2 text-white text-decoration-none fw-bold">
                                <i class="fa-solid fa-user fs-5 me-1"></i>
                                Tài khoản
                            </a>

                            <ul class="custom-user-menu">
                                <li>
                                    <a href="{{ route('login') }}">
                                        <i class="fa-solid fa-right-to-bracket me-2"></i>
                                        Đăng nhập
                                    </a>
                                </li>
                            </ul>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
</header>