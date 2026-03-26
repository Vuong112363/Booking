<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schedule;

// --- Clients Controllers ---
use App\Http\Controllers\Clients\{
    HomeController, AboutController, ServicesController, ToursController,
    DestinationController, TravelGuidesController, TestimonialController,
    ContactController, TourdetailController, BlogsController, SearchController,
    InformationController, LoginController, SocialController, ReviewController,
    ChatController as ClientsChatController,
    BookingController as ClientsBookingController
};

// --- Admin Controllers ---
use App\Http\Controllers\Admin\{
    TourController, UserController, DashboardController,
    BookingController as AdminBookingController,
    ReviewController as AdminReviewController,
    BlogController as AdminBlogController,
    SettingController as AdminSettingController,
    PromotionController,
    ChatController as AdminChatController
};

use App\Http\Controllers\Invoice\InvoiceController;

/*
|--------------------------------------------------------------------------
| 1. CLIENT ROUTES (Bị ảnh hưởng bởi Chế độ bảo trì)
|--------------------------------------------------------------------------
*/
Route::middleware(['check.maintenance'])->group(function () {

    // --- Public Routes ---
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [AboutController::class, 'index'])->name('about');
    Route::get('/services', [ServicesController::class, 'index'])->name('services');
    Route::get('/Tours', [ToursController::class, 'index'])->name('Tours');
    Route::get('/destination', [DestinationController::class, 'index'])->name('destination');
    Route::get('/tour-detail/{id}', [TourdetailController::class, 'index'])->name('tour-detail');
    Route::get('/travel-guides', [TravelGuidesController::class, 'index'])->name('travel-guides');
    Route::get('/testimonial', [TestimonialController::class, 'index'])->name('testimonial');
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/contact', fn() => view('Clients.contact'))->name('contact');
    Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
    Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');

    // --- Authentication & Password Reset ---
    Route::controller(LoginController::class)->group(function () {
        Route::get('/logout', 'logout')->name('logout');
        Route::post('/forgot-password', 'sendReset')->name('password.send');
        Route::get('/reset-password/{token}', 'resetPage')->name('password.reset.page');
        Route::post('/reset-password', 'updatePassword')->name('password.update');
    });

    Route::middleware('guest')->controller(LoginController::class)->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::post('/login', 'login')->name('login.post');
        Route::post('/register', 'register')->name('register.post');
    });

    // --- Social Login ---
    Route::controller(SocialController::class)->group(function () {
        Route::get('/auth/google', 'google');
        Route::get('/auth/google/callback', 'googleCallback');
        Route::get('/auth/facebook', 'facebook');
        Route::get('/auth/facebook/callback', 'facebookCallback');
    });

    // --- User Profile ---
    Route::middleware('user')->controller(InformationController::class)->group(function () {
        Route::get('/user-profile', 'index')->name('infor');
        Route::post('/user-profile', 'update')->name('user.update');
        Route::post('/change-password', 'changePassword')->name('user.password');
        Route::post('/upload-avatar', 'uploadAvatar')->name('user.avatar');
    });

    // --- Booking & Payment (Yêu cầu đăng nhập) ---
    Route::middleware('user')->group(function () {
        Route::controller(ClientsBookingController::class)->group(function () {
            Route::get('/booking/{id}', 'index')->name('booking.index');
            Route::post('/booking/{id}', 'store')->name('booking.store');
            Route::get('/booking-history', 'history')->name('booking-history');
            Route::get('/booking/detail/{id}', 'detail')->name('booking.detail');
            Route::post('/booking-cancel/{id}', 'cancel')->name('booking.cancelled');
            Route::get('/booking-cancel/{id}', 'cancel')->name('booking.cancel'); // Route GET hỗ trợ
            Route::post('/booking/rebook/{id}', 'rebook')->name('booking.rebook');
            Route::post('/check-coupon', 'checkCoupon')->name('coupon.check');
            
            // Thanh toán Momo
            Route::get('/momo-payment/{id}', 'momo_payment');
            Route::get('/momo-return/{id}', 'momo_return');
        });

        // Chat khách hàng
        Route::controller(ClientsChatController::class)->group(function () {
            Route::post('/chat/send', 'sendMessage');
            Route::get('/chat/fetch-messages', 'fetchMessages');
            Route::get('/chat/fetch', 'fetchMessages'); // Alias cho chatbot
        });
    });

    // --- Blogs ---
    Route::prefix('blogs')->controller(BlogsController::class)->group(function () {
        Route::get('/', 'index')->name('blogs');
        Route::get('/{slug}', 'show')->name('blog.detail');
        Route::get('/search/ajax', 'search');
    });

    // --- Invoices ---
    Route::get('/export-invoice/{bookingid}', [InvoiceController::class, 'exportPDF'])->name('invoice.export');

}); // Kết thúc nhóm Maintenance

/*
|--------------------------------------------------------------------------
| 2. ADMIN ROUTES (Luôn truy cập được để quản trị)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    
    // Hệ thống & Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Quản lý Tours
    Route::prefix('tours')->name('tours.')->controller(TourController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'delete')->name('delete');
        Route::post('/schedule/add', 'addSchedule')->name('schedule.add');
        Route::delete('/schedule/delete/{id}', 'deleteSchedule')->name('schedule.delete');
    });

    // Quản lý Bookings
    Route::prefix('bookings')->name('bookings.')->controller(AdminBookingController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/{id}/status', 'updateStatus')->name('update_status');
        Route::get('/confirm-cash/{id}', 'confirmCash')->name('confirm_cash');
    });

    // Quản lý Users
    Route::prefix('users')->name('users.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index'); 
        Route::get('/delete/{id}', 'delete')->name('delete');
        Route::get('/block/{id}', 'block')->name('block');
        Route::get('/active/{id}', 'active')->name('active');
        Route::get('/make-admin/{id}', 'makeAdmin')->name('makeAdmin'); 
        Route::get('/remove-admin/{id}', 'removeAdmin')->name('removeAdmin'); 
    });

    // Quản lý Reviews & Promotions
    Route::prefix('reviews')->name('reviews.')->controller(AdminReviewController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/toggle-status/{id}', 'toggleStatus')->name('toggle');
        Route::post('/reply/{id}', 'reply')->name('reply');
    });

    Route::prefix('promotions')->name('promotions.')->controller(PromotionController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::post('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'destroy')->name('destroy');
    });

    // Admin Chat & Blogs
    Route::prefix('chats')->name('chats.')->controller(AdminChatController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/fetch/{userid}', 'fetchMessages')->name('fetch');
        Route::post('/send', 'sendMessage')->name('send');
    });

    Route::resource('blogs', AdminBlogController::class);
    Route::post('blogs/upload-image', [AdminBlogController::class, 'uploadImage'])->name('blogs.upload');
    Route::get('categories-data', [AdminBlogController::class, 'getCategories'])->name('categories.get');
    Route::post('categories-store', [AdminBlogController::class, 'storeCategory'])->name('categories.store');
    Route::delete('categories-delete', [AdminBlogController::class, 'destroyCategory'])->name('categories.delete');
});

/*
|--------------------------------------------------------------------------
| 3. SYSTEM ROUTES
|--------------------------------------------------------------------------
*/
// Error Page
Route::get('/404', fn() => view('Clients.errors.404'))->name('clients.404');

// Automation
Schedule::command('mail:send-tour-reminders')->dailyAt('08:00');
