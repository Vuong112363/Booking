@include('Clients.blocks.header_home')
@include('Clients.blocks.banner_home')

<section class="destinations-area bgc-black pt-100 pb-70 rel z-1">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="section-title text-white text-center counter-text-wrap mb-70" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                    <h2>Khám Phá Những Kho Báu Thế Giới Cùng GOVIET</h2>
                    <p>Hơn <span class="count-text plus" data-speed="3000" data-stop="34500">0</span> trải nghiệm phổ biến nhất mà bạn sẽ nhớ mãi</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
    @foreach($tours as $tour)
        @php
            // Xử lý ảnh (Code gốc của bạn)
            $imageName = 'default.jpg';
            if (!empty($tour->images)) {
                $decoded = json_decode($tour->images, true);
                if (is_array($decoded) && count($decoded) > 0) {
                    $imageName = $decoded[0];
                } else {
                    $imageName = str_replace(['"', '[', ']', '\\'], '', $tour->images);
                }
            }

            // Xử lý kiểm tra trạng thái tour
            $isPast = \Carbon\Carbon::parse($tour->startdate)->endOfDay()->isPast();
            $isFull = $tour->quantity <= 0;
            $isClosed = $tour->availability == 0;
            $isUnavailable = $isPast || $isFull || $isClosed;
        @endphp
        
        <div class="col-xxl-3 col-xl-4 col-md-6">
            <div class="destination-item block_tours_home" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                
                <div class="image" style="position: relative;">
@if($isPast)
                        <span class="badge bg-secondary" style="position: absolute; bottom: 15px; left: 15px; z-index: 2; padding: 5px 10px; font-weight: normal;">Đã khởi hành</span>
                    @elseif($isFull)
                        <span class="badge bg-danger" style="position: absolute; bottom: 15px; left: 15px; z-index: 2; padding: 5px 10px; font-weight: normal;">Đã hết chỗ</span>
                    @elseif($isClosed)
                        <span class="badge bg-warning text-dark" style="position: absolute; bottom: 15px; left: 15px; z-index: 2; padding: 5px 10px; font-weight: normal;">Tạm ngưng</span>
                    @endif

                    <div class="ratting"><i class="fas fa-star"></i> 4.8</div>
                    <a href="#" class="heart"><i class="fas fa-heart"></i></a>
                
                        <a href="{{ route('tour-detail', ['id' => $tour->tourid]) }}">
                            <img src="{{ asset('clients/assets/images/gallery-tours/' . $imageName) }}" alt="{{ $tour->title }}" class="img-fluid rounded">
                        </a>
                </div>
                
                <div class="content">
                    <span class="location"><i class="fal fa-map-marker-alt"></i> {{ $tour->destination }}</span>
                    <h5><a href="{{ route('tour-detail', ['id' => $tour->tourid]) }}">{{ Str::limit($tour->title, 45) }}</a></h5>
                    <span class="time">{{ $tour->time }}</span>
                </div>
                
<div class="destination-footer d-flex justify-content-between align-items-center flex-wrap" style="padding-top: 15px; border-top: 1px dashed #eaeaea; gap: 10px;">
    <div class="price-wrap" style="flex: 1; min-width: 120px;">
        <span class="d-block text-uppercase" style="font-size: 11px; font-weight: 600; color: #888; letter-spacing: 0.5px; margin-bottom: 2px;">Giá chỉ từ</span>
        <div class="price-amount" style="color: #ff5722; font-weight: 800; font-size: 1.4rem; line-height: 1.2;">
            {{ number_format($tour->min_price ?? $tour->min_price, 0, ',', '.') }}
            <span style="font-size: 13px; font-weight: 600; text-decoration: underline; margin-left: 2px;">VNĐ</span>
        </div>
    </div>
    
    @if($isUnavailable)
        <a href="{{ route('tour-detail', ['id' => $tour->tourid]) }}" class="read-more flex-shrink-0 text-center" style="color: #888; font-weight: 600; padding: 8px 16px; background: #f8f9fa; border-radius: 5px; text-decoration: none; font-size: 14px;">
            Hết chỗ <i class="fal fa-info-circle"></i>
        </a>
    @else
        <a href="{{ route('tour-detail', ['id' => $tour->tourid]) }}" class="read-more flex-shrink-0 text-center" style="color: #fff; background-color: #ff5722; padding: 8px 16px; border-radius: 6px; font-weight: 600; text-decoration: none; box-shadow: 0 4px 10px rgba(255, 87, 34, 0.25); transition: 0.3s; font-size: 14px;">
            Đặt Ngay <i class="fal fa-angle-right ml-1"></i>
        </a>
    @endif
</div>
                
            </div>
        </div>
    @endforeach
</div>
    </div>
</section>

<section class="goviet-destinations pt-100 pb-90 rel z-1 bg-white">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-xl-8 col-lg-10">
                <div class="section-title counter-text-wrap mb-50" data-aos="fade-up">
                    <span class="sub-title-premium mb-15 text-primary fw-bold text-uppercase" style="letter-spacing: 1px;"><i class="fas fa-map-marked-alt me-2"></i>Hành trình mơ ước</span>
                    <h2 class="fw-800 display-5 mb-3">Điểm Đến Xu Hướng 2026</h2>
                    <p class="lead-text text-muted fs-5">Khám phá <span class="count-text plus text-primary fw-bold" data-speed="3000" data-stop="1500">0</span> hành trình độc đáo được tinh tuyển riêng cho bạn.</p>
                    
                    {{-- Bộ lọc Điểm đến --}}
                    <ul class="destinations-nav-premium mt-4 shadow-sm d-inline-flex p-2" id="destination-filter">
                        <li data-filter="*" class="active">Tất cả</li>
                        <li data-filter=".north">Miền Bắc</li>
                        <li data-filter=".center">Miền Trung</li>
                        <li data-filter=".south">Miền Nam</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row destinations-active g-4" id="destination-grid">
            @foreach($popularDestinations as $dest)
            @php
                $destImg = $dest->image;
                if ($destImg && str_starts_with(trim($destImg), '[')) {
                    $imgArr = json_decode($destImg, true);
                    $destImg = (is_array($imgArr) && count($imgArr) > 0) ? $imgArr[0] : null;
                }
            @endphp
            <div class="col-xl-4 col-md-6 item destination-item {{ $dest->domain == 'b' ? 'north' : ($dest->domain == 't' ? 'center' : 'south') }}">
                <div class="destination-premium-card shadow-sm" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="image-wrapper-parallax">
                        <img loading="lazy" src="{{ $destImg ? asset('clients/assets/images/gallery-tours/' . $destImg) : asset('clients/assets/images/default-tour.jpg') }}" 
                             onerror="this.src='https://images.unsplash.com/photo-1599839619722-39751411ea63?q=80&w=600&auto=format&fit=crop'" 
                             alt="{{ $dest->destination }}">
                        
                        <div class="card-glass-overlay">
                            <div class="top-meta text-end">
                                <span class="badge-premium shadow-sm"><i class="fas fa-fire-alt text-warning me-1"></i> {{ $dest->total_tours ?? 0 }} Chuyến đi</span>
                            </div>
                            <div class="bottom-content text-start">
                                <h4 class="mb-2">
                                    <a href="{{ route('Tours', ['search' => $dest->destination]) }}">{{ $dest->destination }}</a>
                                </h4>
                                <div class="explore-row">
                                    <span class="small-desc text-white">Khám phá ngay</span>
                                    <a href="{{ route('Tours', ['search' => $dest->destination]) }}" class="circle-btn shadow-sm">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="features-area pt-100 pb-70 rel z-1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="section-title text-center mb-60">
                    <h2>Tại Sao Chọn GoViet</h2>
                    <p>Những trải nghiệm du lịch tuyệt vời mà chúng tôi mang lại cho bạn</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="feature-card text-center mb-30">
                    <div class="icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="content">
                        <h5>Điểm đến đa dạng</h5>
                        <p>Khám phá hàng trăm địa điểm du lịch nổi tiếng trên khắp Việt Nam.</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="feature-card text-center mb-30">
                    <div class="icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <div class="content">
                        <h5>Giá tốt nhất</h5>
                        <p>Cam kết mức giá hợp lý và minh bạch cho mọi chuyến đi.</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="feature-card text-center mb-30">
                    <div class="icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="content">
                        <h5>Hỗ trợ 24/7</h5>
                        <p>Đội ngũ chăm sóc khách hàng luôn sẵn sàng hỗ trợ bạn.</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="feature-card text-center mb-30">
                    <div class="icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <div class="content">
                        <h5>Hướng dẫn viên</h5>
                        <p>Hướng dẫn viên chuyên nghiệp và thân thiện.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= SECTION 4: TOUR CẤP THẾ GIỚI ================= --}}
<section class="world-class-tours py-100 position-relative z-1">
    {{-- Hiệu ứng nền chìm (Glow background) --}}
    <div class="dark-glow-bg"></div>

    <div class="container">
        {{-- Tiêu đề --}}
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-white text-center counter-text-wrap mb-60" data-aos="fade-up">
                    <span class="sub-title-premium text-primary fw-bold text-uppercase mb-3 d-inline-block" style="letter-spacing: 2px;">
                        <i class="fas fa-crown me-2 text-warning"></i>Trải nghiệm đỉnh cao
                    </span>
                    <h2 class="display-5 fw-900 mb-3">Khám Phá Tour Cấp Thế Giới</h2>
                    <p class="fs-5 opacity-75">Trang web duy nhất với hơn <span class="count-text plus text-primary fw-bold" data-speed="3000" data-stop="34500">0</span> trải nghiệm tuyệt vời nhất.</p>
                </div>
            </div>
        </div>

        {{-- Lưới 3 Thẻ Dọc Nhỏ Gọn (Compact Cards) --}}
        <div class="row justify-content-center g-4">
            {{-- Đổi take(2) thành take(3) --}}
            @foreach($tours->take(3) as $tour)
                @php
                    $imageName = 'default.jpg';
                    if (!empty($tour->images)) {
                        $decoded = json_decode($tour->images, true);
                        if (is_array($decoded) && count($decoded) > 0) {
                            $imageName = $decoded[0];
                        } else {
                            $imageName = str_replace(['"', '[', ']', '\\'], '', $tour->images);
                        }
                    }
                @endphp
            
            {{-- Chia 3 cột trên màn hình lớn --}}
            <div class="col-lg-4 col-md-6">
                <div class="compact-tour-card bg-white h-100 d-flex flex-column" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
                    
                    {{-- Phần Hình Ảnh --}}
                    <div class="card-img-compact position-relative overflow-hidden">
                        <div class="rating-floating-compact"><i class="fas fa-star text-warning"></i> 4.8</div>
                        
                        {{-- Nút thả tim (Z-index cao hơn để click không bị nhầm) --}}
                        <a href="#" class="heart-floating-compact" style="z-index: 10;"><i class="fas fa-heart"></i></a>
                        
                        {{-- Bọc thẻ a quanh ảnh để click chuyển trang --}}
                        <a href="{{ route('tour-detail', ['id' => $tour->tourid]) }}" class="d-block w-100 h-100">
                            <img loading="lazy" src="{{ asset('clients/assets/images/gallery-tours/' . $imageName) }}" 
                                onerror="this.src='https://images.unsplash.com/photo-1506929562872-bb421503ef21?q=80&w=600'"
                                alt="{{ $tour->title }}" class="w-100 h-100 object-fit-cover transition-transform">
                        </a>
                    </div>

                    {{-- Phần Nội Dung --}}
                    <div class="card-body-compact p-4 d-flex flex-column flex-grow-1">
                        <span class="location-badge-compact mb-2 d-block">
                            <i class="fas fa-map-marker-alt text-primary me-1"></i> {{ Str::limit($tour->destination, 20) }}
                        </span>
                        
                        <h5 class="tour-title-compact mb-3">
                            <a href="{{ route('tour-detail',['id'=>$tour->tourid]) }}">{{ $tour->title }}</a>
                        </h5>
                        
                        {{-- Thông số rút gọn --}}
                        <div class="tour-meta-compact d-flex justify-content-between text-muted small mb-3 pb-3 border-bottom">
                            <span><i class="far fa-clock text-primary me-1"></i> {{ $tour->duration }}</span>
                            <span><i class="far fa-user text-primary me-1"></i> {{ $tour->quantity }} chỗ</span>
                        </div>
                        
                        {{-- Giá & Nút Đặt --}}
                        <div class="mt-auto d-flex align-items-center justify-content-between">
                            <div class="price-wrap">
                                <span class="d-block text-uppercase" style="font-size: 13px; font-weight: 600; color: #888; letter-spacing: 0.5px; margin-bottom: 2px;">Giá chỉ từ</span>
                                <div class="price-amount" style="color: #ff5722; font-weight: 800; font-size: 1.8rem; line-height: 1.2;">
                                    {{ number_format($tour->min_price ?? $tour->min_price, 0, ',', '.') }}
                                    <span style="font-size: 15px; font-weight: 500; text-decoration: underline;">VNĐ</span>
                                    
                                </div>
                            </div>
                            <a href="{{ route('tour-detail',['id'=>$tour->tourid]) }}" class="btn-circle-action">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    
                </div>
            </div>
            @endforeach
        </div>

        {{-- Nút Khám phá thêm --}}
        <div class="text-center mt-5 pt-3" data-aos="zoom-in">
            <a href="{{ route('Tours') }}" class="btn-glow-white rounded-pill">
                Khám phá thêm các tour hấp dẫn <i class="fas fa-long-arrow-alt-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
         
<section class="mobile-app-area py-100 rel z-1">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="mobile-app-content rmb-55">
                    <div class="section-title mb-30">
                        <h2>Đặt Tour Du Lịch Nhanh Chóng Với GoViet</h2>
                    </div>
                    <div class="text">
                        <p>
                            GoViet giúp bạn dễ dàng tìm kiếm và đặt tour du lịch chỉ trong vài phút. 
                            Khám phá hàng trăm điểm đến hấp dẫn với dịch vụ chuyên nghiệp và giá cả hợp lý.
                        </p>
                    </div>
                    <ul class="list-style-two mt-35 mb-45">
                        <li>Hàng trăm tour du lịch hấp dẫn</li>
                        <li>Đặt tour trực tuyến nhanh chóng</li>
                        <li>Giá cả minh bạch, không phát sinh</li>
                        <li>Hỗ trợ khách hàng 24/7</li>
                    </ul>
                    <a href="{{ route('Tours') }}" class="theme-btn style-three">
                        <span data-hover="Khám phá tour">Khám phá tour ngay</span>
                        <i class="fal fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="mobile-app-images">
                    <div class="bg">
                        <img src="{{ asset('clients/assets/images/mobile-app/phone-bg.png') }}" alt="Background">
                    </div>
                    <div class="images">
                        <img src="{{ asset('clients/assets/images/mobile-app/phone2.png') }}" alt="Mobile View 2">
                        <img src="{{ asset('clients/assets/images/mobile-app/phone.png') }}" alt="Mobile View 1">
                        <img src="{{ asset('clients/assets/images/mobile-app/phone3.png') }}" alt="Mobile View 3">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<section class="premium-testimonials-section py-120 rel z-1 overflow-hidden">
    <div class="bg-shape-gradient"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center mb-60" data-aos="fade-up">
                    <span class="upper-title">Hàng ngàn khách hàng hài lòng</span>
                    <h2 class="display-4 fw-bold">Chia Sẻ Từ Những <span class="text-gradient">Nhà Lữ Hành</span></h2>
                </div>
            </div>
        </div>

        <div class="swiper testimonial-swiper" data-aos="fade-up" data-aos-delay="200">
            <div class="swiper-wrapper">
                @forelse($testimonials as $item)
                <div class="swiper-slide">
                    <div class="premium-testimonial-card">
                        <div class="quote-icon"><i class="fas fa-quote-right"></i></div>
                        
                        <div class="card-header-meta">
                            <div class="stars">
                                @for($i=1; $i<=5; $i++)
                                    <i class="fas fa-star {{ $i <= $item->rating ? 'active' : '' }}"></i>
                                @endfor
                            </div>
                            <span class="verified-tag"><i class="fas fa-check-circle"></i> Đã trải nghiệm</span>
                        </div>

                        <div class="main-comment">
                            <p>"{{ $item->comment }}"</p>
                        </div>

                        <div class="card-footer-user">
                            <div class="user-avatar">
                                <img src="{{ $item->avatar ? asset('uploads/users/'.$item->avatar) : asset('assets/images/default-user.jpg') }}" alt="{{ $item->username }}">
                            </div>
                            <div class="user-details">
                                <h6 class="name">{{ $item->username }}</h6>
                                <p class="tour-info">{{ $item->tour_name }} — <span class="location">{{ $item->destination }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-center">Đang cập nhật đánh giá...</p>
                @endforelse
            </div>
            
            <div class="swiper-pagination mt-40"></div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    new Swiper('.testimonial-swiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: { delay: 4000, disableOnInteraction: false },
        pagination: { el: ".swiper-pagination", clickable: true },
        breakpoints: {
            768: { slidesPerView: 2 },
            1200: { slidesPerView: 3 }
        }
    });
</script>

<section class="cta-area pt-100 rel z-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4 col-md-6" data-aos="zoom-in-down" data-aos-duration="1500" data-aos-offset="50">
                <div class="cta-item" style="background-image: url({{ asset('clients/assets/images/cta/cta1.jpg') }});">
                    <span class="category">Cắm trại Lều</span>
                    <h2>Khám phá những điểm du lịch tốt nhất thế giới</h2>
                    <a href="{{ route('Tours') }}" class="theme-btn style-two bgc-secondary">
                        <span data-hover="Khám phá các Tour">Khám phá các Tour </span>
                        <i class="fal fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-xl-4 col-md-6" data-aos="zoom-in-down" data-aos-delay="50" data-aos-duration="1500" data-aos-offset="50">
                <div class="cta-item" style="background-image: url({{ asset('clients/assets/images/cta/cta2.jpg') }});">
                    <span class="category">Bãi biển</span>
                    <h2>Những bãi biển đẹp nhất Việt Nam</h2>
                    <a href="{{ route('Tours') }}" class="theme-btn style-two">
                        <span data-hover="Khám phá các Tour">Khám phá các Tour</span>
                        <i class="fal fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-xl-4 col-md-6" data-aos="zoom-in-down" data-aos-delay="100" data-aos-duration="1500" data-aos-offset="50">
                <div class="cta-item" style="background-image: url({{ asset('clients/assets/images/cta/cta3.jpg') }});">
                    <span class="category">Thác nước Kỳ vĩ</span>
                    <h2>Những thác nước hùng vĩ tại Việt Nam</h2>
                    <a href="{{ route('Tours') }}" class="theme-btn style-two bgc-secondary">
                        <span data-hover="Khám phá các Tour">Khám phá các Tour</span>
                        <i class="fal fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= SECTION 5: BLOG & TIN TỨC ================= --}}
<section class="blog-area py-100 rel z-1 bg-light-gradient">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center mb-60" data-aos="fade-up">
                    <span class="sub-title-premium mb-15 text-primary fw-bold text-uppercase" style="letter-spacing: 2px;">
                        <i class="fas fa-book-open me-2"></i>Cẩm nang du lịch
                    </span>
                    <h2 class="fw-800 display-5 mb-3">Đọc Tin Tức & Blog Mới Nhất</h2>
                    <p class="lead-text text-muted fs-5">Hơn <span class="count-text plus text-primary fw-bold" data-speed="3000" data-stop="34500">0</span> trải nghiệm và mẹo du lịch hữu ích dành cho bạn.</p>
                </div>
            </div>
        </div>

        {{-- Thêm g-4 để chia khoảng cách đều nhau --}}
        <div class="row justify-content-center g-4">
            @foreach($blogs as $blog)
            <div class="col-xl-4 col-lg-4 col-md-6 d-flex">
                {{-- Dùng h-100 và flex-column để ép các thẻ cao bằng nhau --}}
                <div class="premium-blog-card w-100 d-flex flex-column shadow-sm bg-white" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    
                    {{-- 1. HÌNH ẢNH (Đưa lên trên cùng) --}}
                    <div class="blog-image position-relative overflow-hidden">
                        {{-- Thẻ Category nổi trên ảnh --}}
                        <a href="{{ route('blogs', ['category' => $blog->category_name]) }}" class="blog-category-badge">
                            {{ $blog->category_name }}
                        </a>
                        <a href="{{ route('blog.detail', $blog->slug) }}" class="d-block w-100 h-100">
                            <img loading="lazy" src="{{ asset($blog->image ?? 'clients/assets/images/blog/blog1.jpg') }}" 
                                 onerror="this.src='https://images.unsplash.com/photo-1488646953014-85cb44e25828?q=80&w=600'" 
                                 alt="{{ $blog->title }}" class="w-100 h-100 object-fit-cover transition-transform">
                        </a>
                    </div>

                    {{-- 2. NỘI DUNG --}}
                    {{-- flex-grow-1 giúp phần nội dung tự động co giãn đẩy nút bấm xuống sát đáy --}}
                    <div class="blog-content p-4 d-flex flex-column flex-grow-1">
                        
                        {{-- Meta Data (Ngày & View) --}}
                        <div class="blog-meta d-flex justify-content-between text-muted small mb-3">
                            <span class="fw-medium">
                                <i class="far fa-calendar-alt text-primary me-1"></i> 
                                {{ $blog->created_at->format('d/m/Y') }}
                            </span>
                            <span class="fw-medium">
                                <i class="far fa-eye text-primary me-1"></i> 
                                {{ $blog->views ?? 0 }} lượt xem
                            </span>
                        </div>

                        {{-- Tiêu đề (Giới hạn 2 dòng để không bị thò thụt) --}}
                        <h4 class="blog-title mb-4" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;">
                            <a href="{{ route('blog.detail', $blog->slug) }}" class="text-dark text-decoration-none fw-bold">
                                {{ $blog->title }}
                            </a>
                        </h4>

                        {{-- 3. NÚT XEM THÊM (Luôn nằm ở đáy nhờ mt-auto) --}}
                        <div class="mt-auto border-top pt-3">
                            <a href="{{ route('blog.detail', $blog->slug) }}" class="btn-read-more d-flex justify-content-between align-items-center text-decoration-none">
                                <span class="fw-bold">Xem bài viết</span>
                                <span class="circle-icon"><i class="fas fa-arrow-right"></i></span>
                            </a>
                        </div>
                        
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('#destination-filter li');
    
    // SỬA LỖI Ở ĐÂY: Chỉ lấy các item nằm TRONG id="destination-grid", không đụng chạm các section khác của trang Home
    const destItems = document.querySelectorAll('#destination-grid .destination-item');

    if(filterBtns.length > 0 && destItems.length > 0) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Đổi màu nút active
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const filterValue = this.getAttribute('data-filter');

                // Xử lý Lọc
                destItems.forEach(item => {
                    item.style.animation = 'none';
                    item.offsetHeight; // Kích hoạt reflow
                    
                    if (filterValue === '*' || item.classList.contains(filterValue.substring(1))) {
                        item.style.display = 'block';
                        item.style.animation = 'fadeInUp 0.6s ease forwards';
                    } else {
                        item.style.display = 'none';
                    }
                });

                // CẬP NHẬT QUAN TRỌNG: Làm mới lại bộ tính toán tọa độ của AOS để các section bên dưới không bị lỗi khi cuộn chuột
                setTimeout(() => {
                    if (typeof AOS !== 'undefined') {
                        AOS.refresh();
                    }
                }, 300); // Chờ animation chạy xong rồi refresh
            });
        });
    }
});
</script>

@include('Clients.blocks.footer')