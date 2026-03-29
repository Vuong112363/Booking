<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    */

    'title' => 'GoViet Admin',
    'title_prefix' => '',
    'title_postfix' => '| GoViet',

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
    'logo_img_class' => 'brand-image ', 
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
            'path' => 'clients/assets/images/logos/logo-two.png',
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
            'path' => 'clients/assets/images/logos/logo-two.png',
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
    'usermenu_header_class' => 'bg-info', 
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

    'classes_auth_card' => 'card-outline card-info shadow-lg',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-info', 

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    */

    'classes_body' => 'text-sm accent-info', 
    'classes_brand' => 'bg-white border-bottom border-light', 
    'classes_brand_text' => 'text-dark font-weight-bold', 
    'classes_content_wrapper' => 'bg-light', 
    'classes_content_header' => '',
    'classes_content' => '',
    
    // Nâng cấp: Sidebar sáng, đổ bóng sâu (elevation-4), màu nhấn là Info
    'classes_sidebar' => 'sidebar-light-info elevation-4', 
    
    // Nâng cấp: nav-pills (bo tròn menu active), nav-child-indent (thụt lề menu con chuyên nghiệp)
    'classes_sidebar_nav' => 'nav-pills nav-sidebar flex-column nav-child-indent nav-compact', 
    
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
    'sidebar_collapse_remember' => true,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-dark',
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
    | Menu Items (ĐÃ ĐƯỢC TỐI ƯU PHÂN CẤP)
    |--------------------------------------------------------------------------
    */

    'menu' => [
        // Navbar
        [
            'type' => 'navbar-search',
            'text' => 'Tìm kiếm...',
            'topnav_right' => true,
        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar
        [
            'type' => 'sidebar-menu-search',
            'text' => 'Tìm kiếm nhanh...',
        ],
        [
            'text' => 'Bảng điều khiển',
            'route'  => 'admin.dashboard',
            'icon' => 'fas fa-chart-line',
            'label' => 'HOT',
            'label_color' => 'success',
        ],
        
        ['header' => 'QUẢN LÝ NGHIỆP VỤ'],
        [
            'text'    => 'Vận hành Tours',
            'icon'    => 'fas fa-map-marked-alt',
            'submenu' => [
                [
                    'text' => 'Danh sách Tour',
                    'url'  => 'admin/tours',
                    'icon' => 'fas fa-list-ul',
                ],
                [
                    'text' => 'Quản lý Booking',
                    'url' => 'admin/bookings',
                    'icon' => 'fas fa-calendar-check',
                ],
                [
                    'text' => 'Đánh giá khách hàng',
                    'route' => 'admin.reviews.index',
                    'icon' => 'fas fa-star',
                ],
            ],
        ],
        [
            'text'    => 'Marketing & Sale',
            'icon'    => 'fas fa-bullhorn',
            'submenu' => [
                [
                    'text' => 'Mã giảm giá',
                    'route' => 'admin.promotions.index',
                    'icon' => 'fas fa-tags',
                ],
                [
                    'text' => 'Bài viết/Blog',
                    'route' => 'admin.blogs.index',
                    'icon' => 'fas fa-newspaper',
                ],
            ],
        ],

        ['header' => 'KHÁCH HÀNG & HỖ TRỢ'],
        [
            'text' => 'Quản lý Người dùng',
            'url' => 'admin/users',
            'icon' => 'fas fa-users-cog',
        ],
        [
            'text' => 'Tin nhắn hỗ trợ', 
            'route' => 'admin.chats.index',
            'icon' => 'fas fa-comments',
            'label' => 3, 
            'label_color' => 'danger',
        ],

        ['header' => 'CÀI ĐẶT HỆ THỐNG'],
        [
            'text' => 'Cấu hình chung',
            'url' => 'admin/settings',
            'icon' => 'fas fa-tools',
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
            'active' => true,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js'],
                ['type' => 'js', 'asset' => false, 'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js'],
                ['type' => 'css', 'asset' => false, 'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css'],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js'],
                ['type' => 'css', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css'],
            ],
        ],
        'Chartjs' => [
            'active' => true,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js'],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
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