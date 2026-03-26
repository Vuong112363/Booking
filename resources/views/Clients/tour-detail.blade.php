<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@include('Clients.blocks.header')

        <section class="page-banner-two rel z-1">
            <div class="container-fluid">
                <hr class="mt-0">
                <div class="container">
                    <div class="banner-inner pt-15 pb-25">
                        <h2 class="page-title mb-10" data-aos="fade-left" data-aos-duration="1500" data-aos-offset="50">{{ $tourDetail->destination }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center mb-20" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1500" data-aos-offset="50">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active">{{ $tourDetail->title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <div class="tour-gallery">
            <div class="container-fluid">
                <div class="row gap-10 justify-content-center rel">
                    <div class="col-lg-4 col-md-6">
                        <div class="gallery-item">
                           <img src="{{ asset('clients/assets/images/gallery-tours/' . ($tourDetail->images[0] ?? 'default.jpg')) }}" alt="Destination">
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('clients/assets/images/gallery-tours/' . ($tourDetail->images[1] ?? 'default.jpg')) }}" alt="Destination">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="gallery-item gallery-between">
                            <img src="{{ asset('clients/assets/images/gallery-tours/' . ($tourDetail->images[2] ?? 'default.jpg')) }}" alt="Destination">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="gallery-item">
                            <img src="{{ asset('clients/assets/images/gallery-tours/' . ($tourDetail->images[3] ?? 'default.jpg')) }}" alt="Destination">
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('clients/assets/images/gallery-tours/' . ($tourDetail->images[4] ?? 'default.jpg')) }}" alt="Destination">
                        </div>
                    </div>
                    <div class="col-lg-12">
                       <div class="gallery-more-btn">
                            <a href="{{ route('contact') }}" class="theme-btn style-two bgc-secondary">
                                <span data-hover="See All Photos">See All Photos</span>
                                <i class="fal fa-arrow-right"></i>
                            </a>
                       </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="tour-header-area pt-70 rel z-1">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-xl-6 col-lg-7">
                        <div class="tour-header-content mb-15" data-aos="fade-left" data-aos-duration="1500" data-aos-offset="50">
                            <span class="location d-inline-block mb-10"><i class="fal fa-map-marker-alt"></i> {{ $tourDetail->destination }}</span>
                            <div class="section-title pb-5">
                                <h2>{{ $tourDetail->title  }}</h2>
                            </div>
                            <div class="ratting">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5 text-lg-end" data-aos="fade-right" data-aos-duration="1500" data-aos-offset="50">
                        <div class="tour-header-social mb-10">
                            <a href="#"><i class="far fa-share-alt"></i>Share tours</a>
                            <a href="#"><i class="fas fa-heart bgc-secondary"></i>Wish list</a>
                        </div>
                    </div>
                </div>
                <hr class="mt-50 mb-70">
            </div>
        </section>
        <section class="tour-details-page pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="tour-details-content">
                            <h3>Khám Phá Tour</h3>
                            <p>{!! $tourDetail->description !!}</p>
                            <div class="row pb-55">
                                <div class="col-md-6">
                                    <div class="tour-include-exclude mt-30">
                                        <h5>Dịch vụ bao gồm</h5>
                                        <ul class="list-style-one check mt-25">
                                            <li><i class="far fa-check"></i> Đưa đón tận nơi</li>
                                            <li><i class="far fa-check"></i> 1 bữa ăn mỗi ngày</li>
                                            <li><i class="far fa-check"></i> Tiệc tối trên du thuyền & chương trình âm nhạc</li>
                                            <li><i class="far fa-check"></i> Tham quan 7 địa điểm nổi bật trong thành phố</li>
                                            <li><i class="far fa-check"></i> Nước suối miễn phí trên xe</li>
                                            <li><i class="far fa-check"></i> Xe du lịch cao cấp</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="tour-include-exclude mt-30">
                                        <h5>Không bao gồm</h5>
                                        <ul class="list-style-one mt-25">
                                            <li><i class="far fa-times"></i> Tiền tip (boa)</li>
                                            <li><i class="far fa-times"></i> Đưa đón tại khách sạn</li>
                                            <li><i class="far fa-times"></i> Ăn trưa, đồ ăn & thức uống ngoài chương trình</li>
                                            <li><i class="far fa-times"></i> Nâng cấp tùy chọn (dịch vụ bổ sung)</li>
                                            <li><i class="far fa-times"></i> Các dịch vụ phát sinh thêm</li>
                                            <li><i class="far fa-times"></i> Bảo hiểm du lịch</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <h3>Lịch trình</h3>
                        <div class="tour-activities mt-30 mb-45">
                            <div class="tour-activity-item">
                                <i class="flaticon-hiking"></i>
                                <b>Hiking</b>
                            </div>
                            <div class="tour-activity-item">
                                <i class="flaticon-fishing"></i>
                                <b>Fishing</b>
                            </div>
                            <div class="tour-activity-item">
                                <i class="flaticon-man"></i>
                                <b>Kayak shooting</b>
                            </div>
                            <div class="tour-activity-item">
                                <i class="flaticon-kayak-1"></i>
                                <b>Kayak</b>
                            </div>
                            <div class="tour-activity-item">
                                <i class="flaticon-bonfire"></i>
                                <b>Campfire</b>
                            </div>
                            <div class="tour-activity-item">
                                <i class="flaticon-flashlight"></i>
                                <b>Night Exploring</b>
                            </div>
                            <div class="tour-activity-item">
                                <i class="flaticon-cycling"></i>
                                <b>Biking</b>
                            </div>
                            <div class="tour-activity-item">
                                <i class="flaticon-meditation"></i>
                                <b>Yoga</b>
                            </div>
                        </div>

                        <h3>Lịch trình chi tiết</h3>
                        <div class="accordion-two mt-25 mb-60" id="faq-accordion-two">
                            @php
                                $day = 1;
                            @endphp
                            @foreach($tourDetail->timeline as $index => $timeline)
                            <div class="accordion-item">
                                <h5 class="accordion-header">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo{{ $timeline->timelineID }}" aria-expanded="false" aria-controls="collapseTwo{{ $timeline->timelineID}}">
                                       Ngày {{ $day++ }}- {{ $timeline->title }}
                                    </button>
                                </h5>
                                <div id="collapseTwo{{ $timeline->timelineID }}" class="accordion-collapse collapse" data-bs-parent="#faq-accordion-two">
                                    <div class="accordion-body">
                                        <p>{!! $timeline->description !!}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>


                        <h3>Maps</h3>
                        <div class="tour-map mt-30 mb-50">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d96777.16150026117!2d-74.00840582560909!3d40.71171357405996!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1706508986625!5m2!1sen!2sbd" style="border:0; width: 100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                        <h3>Clients Reviews</h3>
                        <div class="clients-reviews bgc-black mt-30 mb-60">
                            <div class="left">
                                <b>{{ $averageRating }}</b>
                                <span>({{ $totalReviews }} reviews)</span>
                                <div class="ratting">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($averageRating))
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            
                            <div class="right">
                                @for($i = 5; $i >= 1; $i--)
                                <div class="ratting-item">
                                    <span class="title">{{ $i }} Sao</span>
                                    
                                    <span class="line"><span style="width: {{ $ratingPercentages[$i] ?? 0 }}%;"></span></span>
                                    
                                    <div class="ratting text-white" style="font-size: 14px; margin-left: 10px;">
                                        ({{ $ratingCounts[$i] ?? 0 }})
                                    </div>
                                </div>
                                @endfor
                            </div>
                        </div>
                        <h3>Clients Comments ({{ $totalReviews }})</h3>
                        <div class="comments mt-30 mb-60">
                            
                            @forelse($reviews as $review)
                                <div class="comment-body" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                        <div class="author-thumb">
                            <img src="{{ isset($review->user->avatar) && $review->user->avatar ? asset('clients/assets/images/avatars/' . $review->user->avatar) : asset('clients/assets/images/avatars/default.png') }}" alt="Author">
                        </div>
                                    <div class="content">
                                        <h6>{{ $review->user->name ?? $review->user->username ?? 'Khách hàng' }}</h6>
                                        
                                        <div class="ratting">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        
                                        <span class="time">{{ \Carbon\Carbon::parse($review->createdat)->format('d/m/Y H:i') }}</span>
                                        
                                        <p>{{ $review->comment }}</p>
                                        @if(!empty($review->admin_reply))
                            <div class="admin-reply-box mt-10 p-3" style="background-color: #f8f9fa; border-left: 3px solid #ff6a00; border-radius: 5px;">
                                <h6 style="color: #ff6a00; font-size: 14px; margin-bottom: 5px;"><i class="fas fa-headset"></i> Phản hồi từ quản trị viên:</h6>
                                <p class="mb-0" style="font-size: 14px;">{{ $review->admin_reply }}</p>
                            </div>
                        @endif
                                        
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info">
                                    Chưa có đánh giá nào cho tour này. Hãy là người đầu tiên để lại nhận xét!
                                </div>
                            @endforelse

                        </div>
                        
                        <hr class="mt-50 mb-40">

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <h3>Add Reviews</h3>

                        @if(session()->has('userid'))
                            @if($hasBooked)
                                <form action="{{ route('review.store') }}" method="post" class="mt-30">
                                    @csrf
                                    <input type="hidden" name="tourid" value="{{ $tourDetail->tourid }}">
                                    
                                    <div class="comment-review-wrap">
                                        <div class="comment-ratting-item">
                                            <span class="title">Đánh giá tour</span>
                                            <div class="form-group">
                                                <select name="rating" class="form-control" required>
                                                    <option value="5">⭐⭐⭐⭐⭐ (5 sao)</option>
                                                    <option value="4">⭐⭐⭐⭐ (4 sao)</option>
                                                    <option value="3">⭐⭐⭐ (3 sao)</option>
                                                    <option value="2">⭐⭐ (2 sao)</option>
                                                    <option value="1">⭐ (1 sao)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <hr class="mt-30 mb-40">
                                    <h5>Leave Feedback</h5>
                                    <div class="row gap-20 mt-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" value="{{ session('username') ?? '' }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" value="{{ session('email') ?? '' }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Comments</label>
                                                <textarea name="comment" class="form-control" rows="5" placeholder="Chia sẻ trải nghiệm của bạn về tour này..." required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-0">
                                                <button type="submit" class="theme-btn bgc-secondary style-two">
                                                    <span data-hover="Submit reviews">Submit reviews</span>
                                                    <i class="fal fa-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <div class="alert alert-info mt-30">
                                    <i class="fas fa-info-circle"></i> Bạn cần đặt và trải nghiệm tour này để có thể viết đánh giá.
                                </div>
                            @endif

                        @else
                            <div class="alert alert-warning mt-30">
                                <i class="fas fa-exclamation-triangle"></i> Vui lòng <a href="{{ route('login') }}" style="text-decoration: underline; font-weight: bold;">đăng nhập</a> để đánh giá tour.
                            </div>
                        @endif

                    </div>
                    
                    <div class="col-lg-4 col-md-8 col-sm-10 rmt-75">
                        <div class="blog-sidebar tour-sidebar">
                            
                            <div class="widget widget-tour-info mb-40 shadow-sm p-4 rounded bg-white" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
    <h5 class="widget-title mb-3">Thông tin chung</h5>
    <ul class="list-unstyled mb-0">
        @if(!empty($tourDetail->title))
        <li class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2 hover-bg p-2 rounded">
            <div class="d-flex align-items-center">
                <i class="far fa-clock text-primary me-2 fs-5"></i>
                <strong>Tên tour:</strong>&nbsp; {{ $tourDetail->title }}
            </div>
            <span class="badge bg-success">Hot</span>
        </li>
        @endif

        @if(!empty($tourDetail->tourid))
        <li class="d-flex align-items-center mb-3 border-bottom pb-2 hover-bg p-2 rounded">
            <i class="far fa-calendar-alt text-primary me-2 fs-5"></i>
            <strong>Mã tour:</strong> {{ $tourDetail->tourid }}
        </li>
        @endif

        @if(!empty($tourDetail->time))
        <li class="d-flex align-items-center mb-3 border-bottom pb-2 hover-bg p-2 rounded">
            <i class="far fa-clock text-primary me-2 fs-5"></i>
            <strong>Thời gian:</strong> {{ $tourDetail->time }}
        </li>
        @endif

        @if(!empty($tourDetail->destination))
        <li class="d-flex align-items-center mb-3 border-bottom pb-2 hover-bg p-2 rounded">
            <i class="far fa-map-marker-alt text-primary me-2 fs-5"></i>
            <strong>Điểm đến:</strong> {{ $tourDetail->destination }}
        </li>
        @endif

        @if(!empty($tourDetail->quantity))
        <li class="d-flex align-items-center mb-3 hover-bg p-2 rounded">
            <i class="far fa-users text-primary me-2 fs-5"></i>
            <strong>Quy mô tour:</strong> Tối đa {{ $tourDetail->quantity }} khách
        </li>
        @endif
    </ul>
</div>

<style>
.hover-bg:hover {
    background-color: #f8f9fa;
    transition: 0.3s;
}
</style>
                            
                            <div class="widget widget-booking" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                                <h5 class="widget-title">Đặt Tour</h5>
                                <form id="booking-form" action="{{ route('booking.index', ['id' => $tourDetail->tourid]) }}" method="get">
                                    
                                    <div class="form-group mb-20">
                                        <label class="fw-bold mb-2"><i class="fas fa-calendar-alt"></i> Chọn lịch khởi hành:</label>
                                        <select name="schedule_id" id="schedule_id" class="form-control" required style="max-height: 200px; overflow-y: auto; padding: 10px;">
                                            <option value="" disabled selected>-- Vui lòng chọn ngày --</option>
                                            @forelse($schedules as $schedule)
                                                <option value="{{ $schedule->schedule_id }}" 
                                                        data-price-adult="{{ $schedule->priceadult }}" 
                                                        data-price-child="{{ $schedule->pricechild }}"
                                                        data-quantity="{{ $schedule->quantity }}">
                                                    Khởi hành: {{ date('d/m', strtotime($schedule->startdate)) }} - Về: {{ date('d/m/Y', strtotime($schedule->enddate)) }}
                                                </option>
                                            @empty
                                                <option value="" disabled>Hiện tại đã hết lịch khởi hành</option>
                                            @endforelse
                                        </select>
                                        <small class="text-muted mt-2 d-block"><i class="fas fa-info-circle"></i> Vui lòng chọn ngày để xem giá vé tương ứng.</small>
                                    </div>

                                    <hr>
                                    <ul class="tickets clearfix mb-25">
                                        <li class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-bold">Giá vé Người lớn:</span> 
                                            <span class="price text-danger fw-bold fs-5" id="display_price_adult">0 VND</span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">Giá vé Trẻ em:</span> 
                                            <span class="price text-danger fw-bold fs-5" id="display_price_child">0 VND</span>
                                        </li>
                                    </ul>

                                    @php
                                        $nextSchedule = $schedules->where('quantity', '>', 0)->sortBy('startdate')->first();
                                        $isPast = $nextSchedule && \Carbon\Carbon::parse($nextSchedule->startdate)->endOfDay()->isPast();
                                        $isFull = !$nextSchedule; 
                                        $isClosed = $tourDetail->availability == 0;
                                    @endphp

                                    @if($isPast || $isFull || $isClosed)
                                        <div class="alert alert-danger text-center py-2" style="font-size: 13px;">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            @if($isPast) Tour đã khởi hành @elseif($isFull) Đã hết chỗ @else Đang tạm ngưng @endif
                                        </div>
                                        <a href="tel:0352789556" class="theme-btn w-100 style-two bg-secondary text-center">Liên hệ tư vấn</a>
                                    @else
                                        @if(session()->has('userid'))
    <button type="submit" class="theme-btn style-two w-100 text-center">Tiếp tục đặt tour</button>
@else
                                            <button type="button" onclick="showLoginNotification()" class="theme-btn style-two w-100 text-center">Tiếp tục đặt tour</button>
                                        @endif
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
        </section>
        <div id="login-warning" style="
display:none;
position:fixed;
top:100px;
right:20px;
background:#dc3545;
color:white;
padding:18px 25px;
border-radius:8px;
box-shadow:0 4px 10px rgba(0,0,0,0.2);
z-index:9999;
">
⚠ Vui lòng đăng nhập để đặt tour
</div>

<script>
function showLoginNotification(){
    const box = document.getElementById("login-warning");
    box.style.display = "block";
    setTimeout(function(){
        box.style.display = "none";
    },5000);
}

document.addEventListener("DOMContentLoaded", function() {
    const scheduleSelect = document.getElementById("schedule_id");
    const priceAdultDisplay = document.getElementById("display_price_adult");
    const priceChildDisplay = document.getElementById("display_price_child");

    function formatMoney(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount) + ' VND';
    }

    // Hàm chỉ cập nhật hiển thị giá vé (không tính tổng)
    function updateBookingSummary() {
        if (!scheduleSelect.value) return; // Không làm gì nếu chưa chọn ngày
        
        const selectedOption = scheduleSelect.options[scheduleSelect.selectedIndex];
        
        // Lấy giá từ data attributes của option vừa được chọn
        const priceAdult = parseInt(selectedOption.getAttribute("data-price-adult")) || 0;
        const priceChild = parseInt(selectedOption.getAttribute("data-price-child")) || 0;
        
        // Cập nhật hiển thị đơn giá
        priceAdultDisplay.innerText = priceAdult > 0 ? formatMoney(priceAdult) : '0 VND';
        priceChildDisplay.innerText = priceChild > 0 ? formatMoney(priceChild) : '0 VND';
    }

    // Lắng nghe sự kiện thay đổi ngày để đổi giá
    scheduleSelect.addEventListener("change", updateBookingSummary);

    // Xử lý cho thư viện NiceSelect nếu template có dùng
    if (window.jQuery) {
        $(scheduleSelect).on('change', function() {
            updateBookingSummary();
        });
    }

    // Nếu lúc load trang mà có sẵn ngày được chọn thì cập nhật giá luôn
    if(scheduleSelect.value){
        updateBookingSummary();
    }
});
</script>  
        
@include('clients.blocks.new_letter')
@include('clients.blocks.footer')