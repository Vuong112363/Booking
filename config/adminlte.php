<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    */

    'title' => 'GoViet Admin',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    */

    'logo' => '',
    'logo_img' => 'clients/assets/images/logos/logo-two.png',
    'logo_img_class' => 'img-fluid px-5', // Giảm đổ bóng để logo nhìn phẳng hơn
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'GoViet Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    */

    'preloader' => [
        'enabled' => false, 
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'clients/assets/images/logos/logo-tow.png',
            'alt' => 'GoViet Preloader',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true, 
    'usermenu_header_class' => 'bg-info', // Dùng class info (gần nhất với #4CBEE1) cho header của user
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true, 
    'layout_fixed_navbar' => true,  
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    */

    'classes_auth_card' => 'card-outline card-info', // Bo viền màu info
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-info', // Nút bấm login màu info

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes (ĐỘT PHÁ & MÀU CHỦ ĐẠO NẰM Ở ĐÂY 👇)
    |--------------------------------------------------------------------------
    */

    // text-sm: font chữ tinh tế. accent-info: các điểm nhấn (như checkbox, thanh cuộn, link) sẽ ăn theo màu info (#4CBEE1)
    'classes_body' => 'text-sm accent-info', 
    
    // Nền logo màu trắng, chữ màu xám đậm để không bị "chói"
    'classes_brand' => 'bg-white border-bottom border-light', 
    'classes_brand_text' => 'text-dark font-weight-bold', 
    
    'classes_content_wrapper' => 'bg-light', // Nền nội dung xám siêu nhạt
    'classes_content_header' => '',
    'classes_content' => '',
    
    // Sidebar sáng (trắng). Khi active menu sẽ nổi lên màu info (#4CBEE1). elevation-2 để tạo bóng đổ nhẹ nhàng.
    'classes_sidebar' => 'sidebar-light-info elevation-2', 
    
    // Giao diện phẳng (flat), thụt lề rõ ràng, các icon nhỏ gọn (compact)
    'classes_sidebar_nav' => 'nav-flat nav-legacy nav-compact nav-child-indent', 
    
    // Thanh Navbar phía trên cùng: Chuyển sang màu info (gần với #4CBEE1 nhất) và xóa viền dưới.
    'classes_topnav' => 'navbar-info navbar-dark border-bottom-0', 
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-dark', // Do menu trái nền sáng, thanh cuộn nên để dark/xám
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    */

    'use_route_url' => true,
    'dashboard_url' => 'admin.dashboard',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    */

    'menu' => [
        // Navbar items:
        [
            'type' => 'navbar-search',
            'text' => 'Tìm kiếm...',
            'topnav_right' => true,
        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'Tìm kiếm...',
        ],
        [
            'text' => 'Bảng điều khiển',
            'route'  => 'admin.dashboard',
            'icon' => 'fas fa-tachometer-alt',
        ],
        
        ['header' => 'QUẢN LÝ NGHIỆP VỤ'],
        [
            'text' => 'Quản lý Tour',
            'url'  => 'admin/tours',
            'icon' => 'fas fa-map-marked-alt',
        ],
        [
            'text' => 'Quản lý Booking',
            'url' => 'admin/bookings',
            'icon' => 'fas fa-calendar-check'
        ],
        [
            'text' => 'Quản lý User',
            'url' => 'admin/users',
            'icon' => 'fas fa-users'
        ],
        [
            'text' => 'Quản lý đánh giá',
            'route' => 'admin.reviews.index',
            'icon' => 'fas fa-star'
        ],
        [
            'text' => 'Quản lý mã giảm giá',
            'route' => 'admin.promotions.index',
            'icon' => 'fas fa-tags',
        ],
        [
            'text' => 'Quản lý Bài viết',
            'route' => 'admin.blogs.index',
            'icon' => 'fas fa-newspaper',
        ],
        [
            'text' => 'Tin nhắn & Hỗ trợ', 
            'route' => 'admin.chats.index',
            'icon' => 'fas fa-comments',
            'label' => 3, 
            'label_color' => 'danger', // Để màu đỏ cho dễ chú ý tin nhắn mới
        ],

        ['header' => 'CÀI ĐẶT HỆ THỐNG'],
        [
            'text' => 'Cài đặt chung',
            'url' => 'admin/settings', // Route ảo, bạn sửa lại theo thực tế
            'icon' => 'fas fa-cogs',
        ],
        [
            'text' => 'Hồ sơ cá nhân',
            'url' => 'admin/settings',
            'icon' => 'fas fa-fw fa-user',
        ],
        [
            'text' => 'Đổi mật khẩu',
            'url' => 'admin/settings',
            'icon' => 'fas fa-fw fa-lock',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js'],
                ['type' => 'js', 'asset' => false, 'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js'],
                ['type' => 'css', 'asset' => false, 'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css'],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js'],
                ['type' => 'css', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css'],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js'],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8'],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                ['type' => 'css', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css'],
                ['type' => 'js', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js'],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    */

    'livewire' => false,
];