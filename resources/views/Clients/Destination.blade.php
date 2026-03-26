@include('Clients.blocks.header')
@include('Clients.blocks.banner_search')

{{-- ================= SECTION 1: ĐIỂM ĐẾN PHỔ BIẾN ================= --}}
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

{{-- ================= SECTION 2: ƯU ĐÃI ĐỘC QUYỀN ================= --}}
<section class="hot-deals-area pt-100 pb-70 bg-light-gradient rel z-1 border-top">
    <div class="container">
        <div class="row align-items-end mb-50">
            <div class="col-lg-7">
                <div class="section-title" data-aos="fade-right">
                    <span class="sub-title-premium mb-10 text-danger fw-bold text-uppercase" style="letter-spacing: 1px;"><i class="fas fa-bolt me-2"></i>Giá tốt nhất</span>
                    <h2 class="fw-800 display-5">Ưu Đãi Đặc Biệt Giờ Chót</h2>
                </div>
            </div>
            <div class="col-lg-5 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('Tours') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold shadow-sm">Xem tất cả ưu đãi <i class="fas fa-long-arrow-alt-right ms-2"></i></a>
            </div>
        </div>

        <div class="row g-4">
            @foreach($hotDeals as $deal)
            @php
                $dealImg = 'default-tour.jpg';
                if (!empty($deal->images)) {
                    if (is_string($deal->images) && str_starts_with(trim($deal->images), '[')) {
                        $imgArr = json_decode($deal->images, true);
                        if (is_array($imgArr) && count($imgArr) > 0) { $dealImg = $imgArr[0]; }
                    } else { $dealImg = $deal->images; }
                }
            @endphp
            <div class="col-lg-4 col-md-6">
                <div class="premium-deal-card shadow-sm d-flex flex-column h-100" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
                    <div class="image-box position-relative">
                        <div class="promo-badge"><i class="fas fa-clock me-1"></i> Giờ chót</div>
                        <img loading="lazy" src="{{ asset('clients/assets/images/gallery-tours/' . $dealImg) }}" 
                             onerror="this.src='https://images.unsplash.com/photo-1528127269322-539801943592?q=80&w=600'" 
                             alt="{{ $deal->title }}">
                        
                        <div class="deal-price-floating text-end">
                            <small class="text-muted text-through d-block mb-1" style="font-size: 13px;">{{ number_format(($deal->min_price ?? 0) * 1.2) }}đ</small>
                            <span class="main-price text-primary fw-900" style="font-size: 20px; line-height: 1;">{{ number_format($deal->min_price ?? 0) }}đ</span>
                        </div>
                    </div>
                    
                    <div class="content-box p-4 bg-white d-flex flex-column flex-grow-1">
                        <div class="meta-tags mb-3 d-flex justify-content-between align-items-center">
                            <span class="tag-item fw-bold text-dark small"><i class="fas fa-map-marker-alt text-primary me-1"></i> {{ Str::limit($deal->destination, 18) }}</span>
                            <span class="tag-item fw-bold text-dark small"><i class="far fa-clock text-primary me-1"></i> {{ $deal->duration ?? '2N1Đ' }}</span>
                        </div>
                        
                        <h5 class="mb-4 title-link" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">
                            <a href="{{ route('tour-detail', $deal->tourid) }}" class="text-dark text-decoration-none fw-bold fs-6">{{ $deal->title }}</a>
                        </h5>
                        
                        <div class="footer-action mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                            <div class="rating-box text-warning small fw-bold">
                                @php
    $reviews = rand(80, 250);
@endphp

<i class="fas fa-star"></i> 4.9 
<span class="text-muted ms-1 fw-medium">
    ({{ number_format($reviews) }} đánh giá)
</span>
                            </div>
                            <a href="{{ route('tour-detail', $deal->tourid) }}" class="btn-action-premium text-decoration-none fw-bold small">Chi tiết <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ================= SECTION 3: NEWSLETTER ================= --}}
<section class="newsletter-area-premium py-80 bg-dark-modern text-white position-relative mt-5 mb-5 overflow-hidden">
    <div class="abstract-shape"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 text-center newsletter-inner" data-aos="zoom-in">
                <div class="icon-hld mb-4 shadow-lg"><i class="fas fa-paper-plane fa-2x text-primary"></i></div>
                <h2 class="mb-3 fw-800 text-white">Đăng ký nhận cẩm nang du lịch</h2>
                <p class="mb-5 opacity-75">Ưu đãi ẩn và mẹo du lịch độc quyền chỉ dành cho thành viên của GoViet.</p>
                <form class="newsletter-form-premium mx-auto">
                    <div class="input-group-premium shadow p-2">
                        <input type="email" placeholder="Email của bạn..." required>
                        <button type="submit" class="btn-submit-premium">Đăng ký</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('#destination-filter li');
    const destItems = document.querySelectorAll('.destination-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const filterValue = this.getAttribute('data-filter');

            destItems.forEach(item => {
                item.style.animation = 'none';
                item.offsetHeight; 
                if (filterValue === '*' || item.classList.contains(filterValue.substring(1))) {
                    item.style.display = 'block';
                    item.style.animation = 'fadeInUp 0.6s ease forwards';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>

<style>
/* Reset triệt để khung đen của template */
.destination-item { padding: 12px !important; background: transparent !important; }

/* ---------- Thẻ Điểm Đến (XÓA KHUNG ĐEN) ---------- */
.destination-premium-card { 
    border-radius: 20px !important; 
    overflow: hidden !important; 
    position: relative !important; 
    height: 400px !important; 
    background: #ffffff !important; 
    padding: 0 !important;
    border: 1px solid #f0f0f0 !important;
}

.image-wrapper-parallax { 
    width: 100% !important; 
    height: 100% !important; 
    position: absolute !important;
    top: 0; left: 0;
}

.image-wrapper-parallax img { 
    width: 100% !important; 
    height: 100% !important; 
    object-fit: cover !important; 
    display: block !important;
    transition: 1s cubic-bezier(0.19, 1, 0.22, 1); 
}

.destination-premium-card:hover img { transform: scale(1.1); }

/* Lớp phủ trong suốt - Chỉ làm tối nhẹ ở chân ảnh để nổi chữ */
.card-glass-overlay { 
    position: absolute !important; 
    inset: 0 !important; 
    padding: 25px !important; 
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.1) 40%, transparent 100%) !important; 
    display: flex; 
    flex-direction: column; 
    justify-content: space-between;
}

.badge-premium { 
    background: rgba(255, 255, 255, 0.95); 
    color: #ff5722; 
    padding: 6px 15px; 
    border-radius: 50px; 
    font-size: 12px; 
    font-weight: 700;
}

.bottom-content h4 a { 
    color: #ffffff !important; 
    text-decoration: none; 
    font-size: 24px; 
    font-weight: 800; 
    text-shadow: 0 2px 8px rgba(0,0,0,0.8);
}

.explore-row { 
    display: flex; align-items: center; justify-content: space-between; 
    margin-top: 10px; border-top: 1px solid rgba(255,255,255,0.3); padding-top: 10px;
    opacity: 0; transform: translateY(10px); transition: 0.3s;
}

.destination-premium-card:hover .explore-row { opacity: 1; transform: translateY(0); }
.small-desc { font-size: 12px; font-weight: 700; text-transform: uppercase; }

.circle-btn { 
    width: 36px; height: 36px; background: #ff5722; color: #fff; 
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
}

/* ---------- Thẻ Ưu Đãi ---------- */
.premium-deal-card { border-radius: 16px; overflow: hidden; background: #fff; border: 1px solid #eee; }
.premium-deal-card .image-box { height: 230px; overflow: hidden; position: relative; }
.premium-deal-card .image-box img { width: 100%; height: 100%; object-fit: cover; }

.deal-price-floating { 
    position: absolute; bottom: 12px; right: 12px; 
    background: #fff; padding: 8px 15px; border-radius: 10px; 
    box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
}

.promo-badge { 
    position: absolute; top: 12px; left: 12px; 
    background: #dc3545; color: #fff; padding: 4px 12px; 
    border-radius: 6px; font-size: 11px; font-weight: 700; 
}

/* Newsletter & Nav */
.destinations-nav-premium li { padding: 10px 25px; cursor: pointer; font-weight: 700; border-radius: 50px; transition: 0.3s; }
.destinations-nav-premium li.active { background: #ff5722; color: #fff; }
.bg-dark-modern { background: #1a1a1a; border-radius: 24px; margin: 0 15px; }
.input-group-premium { background: #fff; border-radius: 50px; display: flex; }
.input-group-premium input { flex: 1; border: none; padding: 10px 20px; outline: none; border-radius: 50px; }
.btn-submit-premium { background: #ff5722; color: #fff; border: none; padding: 10px 25px; border-radius: 50px; font-weight: 700; }

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

@include('Clients.blocks.footer')