<?php

use Illuminate\Support\Facades\Route;
// Clients Controllers
use App\Http\Controllers\Clients\HomeController;
use App\Http\Controllers\Clients\AboutController;
use App\Http\Controllers\Clients\ServicesController;
use App\Http\Controllers\Clients\ToursController;
use App\Http\Controllers\Clients\DestinationController;
use App\Http\Controllers\Clients\TravelGuidesController;
use App\Http\Controllers\Clients\TestimonialController;
use App\Http\Controllers\Clients\BookingController as ClientsBookingController;     
use App\Http\Controllers\Clients\ContactController;
use App\Http\Controllers\Clients\TourdetailController;
use App\Http\Controllers\Clients\BlogsController;
use App\Http\Controllers\Clients\BlogDetailsController;
use App\Http\Controllers\Clients\InformationController; // Sửa viết hoa chữ I cho chuẩn
use App\Http\Controllers\Clients\LoginController;
use App\Http\Controllers\Clients\SocialController;
use App\Http\Controllers\Clients\SearchController;
use App\Http\Controllers\Clients\ReviewController;

// Admin Controllers
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;


use Illuminate\Support\Facades\Schedule; 

// Middleware (Nếu bạn dùng class trực tiếp thay vì alias)
// use App\Http\Middleware\AdminMiddleware;


/* =======================================================
   1. PUBLIC ROUTES (Giao diện khách hàng)
======================================================= */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/services', [ServicesController::class, 'index'])->name('services');
Route::get('/Tours', [ToursController::class, 'index'])->name('Tours');
Route::get('/destination', [DestinationController::class, 'index'])->name('destination');
Route::get('/tour-detail/{id}', [TourdetailController::class, 'index'])->name('tour-detail');
Route::get('/travel-guides', [TravelGuidesController::class, 'index'])->name('travel-guides');
Route::get('/testimonial', [TestimonialController::class, 'index'])->name('testimonial');
Route::get('/blogs', [BlogsController::class, 'index'])->name('blogs');
Route::get('/blog-details', [BlogDetailsController::class, 'index'])->name('blog-details');
Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');

Route::get('/contact', function () {
    return view('Clients.contact');
})->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');


/* =======================================================
   2. AUTHENTICATION & PROFILE
======================================================= */
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/register', 'register')->name('register.post');
    Route::get('/logout', 'logout')->name('logout');
    Route::post('/forgot-password', 'sendReset')->name('password.send');
    Route::get('/reset-password/{token}', 'resetPage')->name('password.reset.page');
    Route::post('/reset-password', 'updatePassword')->name('password.update');
});

// User Profile (Đã gom chung Controller)
Route::controller(InformationController::class)->group(function () {
    Route::get('/user-profile', 'index')->name('infor');
    Route::post('/user-profile', 'update')->name('user.update');
    Route::post('/change-password', 'changePassword')->name('user.password');
    Route::post('/upload-avatar', 'uploadAvatar')->name('user.avatar');
});


/* =======================================================
   3. CLIENT BOOKING (Bảo vệ bởi middleware 'user')
======================================================= */
Route::middleware('user')->controller(ClientsBookingController::class)->group(function () {
    Route::get('/booking/{id}', 'index')->name('booking.index');
    Route::post('/booking/{id}', 'store')->name('booking.store');
    Route::get('/booking-history', 'history')->name('booking-history');
    Route::post('/booking-cancel/{id}', 'cancel')->name('booking.cancelled');
    Route::post('/booking/rebook/{id}', 'rebook')->name('booking.rebook');
    Route::get('/booking/detail/{id}', 'detail')->name('booking.detail');
    
    // Momo
    Route::get('/momo-payment/{id}', 'momo_payment');
    Route::get('/momo-return/{id}', 'momo_return');

    Route::get('/booking-cancel/{id}', [App\Http\Controllers\Clients\BookingController::class, 'cancel'])->name('booking.cancel');
});


/* =======================================================
   4. ADMIN DASHBOARD (Bảo vệ bởi middleware 'admin')
======================================================= */
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Quản lý Tours
    Route::prefix('tours')->name('tours.')->controller(TourController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });

    // Quản lý Bookings
    Route::prefix('bookings')->name('bookings.')->controller(AdminBookingController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/{id}/status', 'updateStatus')->name('update_status');
    });

    // Quản lý Users (Đã sửa lỗi double /admin)
    Route::prefix('users')->name('users.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index'); 
        Route::get('/delete/{id}', 'delete')->name('delete');
        Route::get('/block/{id}', 'block')->name('block');
        Route::get('/active/{id}', 'active')->name('active');
        Route::get('/make-admin/{id}', 'makeAdmin')->name('makeAdmin'); 
        Route::get('/remove-admin/{id}', 'removeAdmin')->name('removeAdmin'); 
    });

});


/* =======================================================
   5. SOCIAL LOGIN & ERRORS
======================================================= */
Route::controller(SocialController::class)->group(function () {
    Route::get('/auth/google', 'google');
    Route::get('/auth/google/callback', 'googleCallback');
    Route::get('/auth/facebook', 'facebook');
    Route::get('/auth/facebook/callback', 'facebookCallback');
});
/* =======================================================
   6. Tự Dộng nhắc lịch
======================================================= */
Schedule::command('mail:send-tour-reminders')->dailyAt('08:00');

Route::get('/404', function () {
    return view('Clients.errors.404');
})->name('clients.404');