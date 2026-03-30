<div class="sidebar-wrapper rmb-75">
    <form method="GET" action="{{ route('Tours') }}" id="filterForm">
        
        @if(request('destination')) <input type="hidden" name="destination" value="{{ request('destination') }}"> @endif
        @if(request('start_date')) <input type="hidden" name="start_date" value="{{ request('start_date') }}"> @endif
        @if(request('end_date')) <input type="hidden" name="end_date" value="{{ request('end_date') }}"> @endif
        @if(request('guests')) <input type="hidden" name="guests" value="{{ request('guests') }}"> @endif

        <div class="shop-sidebar">
            
            <div class="widget widget-price" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                <h6 class="widget-title">Mức Giá</h6>
                <ul class="radio-filter">
                    <li>
                        <input class="form-check-input" type="radio" name="price" id="price_all" value="" {{ !request('price') ? 'checked' : '' }} onchange="this.form.submit()">
                        <label for="price_all">Tất cả mức giá</label>
                    </li>
                    <li>
                        <input class="form-check-input" type="radio" name="price" id="price1" value="0-2000000" {{ request('price') == '0-2000000' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label for="price1">Dưới 2.000.000 VNĐ</label>
                    </li>
                    <li>
                        <input class="form-check-input" type="radio" name="price" id="price2" value="2000000-5000000" {{ request('price') == '2000000-5000000' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label for="price2">2.000.000 - 5.000.000 VNĐ</label>
                    </li>
                    <li>
                        <input class="form-check-input" type="radio" name="price" id="price3" value="5000000-10000000" {{ request('price') == '5000000-10000000' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label for="price3">5.000.000 - 10.000.000 VNĐ</label>
                    </li>
                    <li>
                        <input class="form-check-input" type="radio" name="price" id="price4" value="10000000-500000000" {{ request('price') == '10000000-500000000' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label for="price4">Trên 10.000.000 VNĐ</label>
                    </li>
                </ul>
            </div>

            <div class="widget widget-activity" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                <h6 class="widget-title">Vùng Miền</h6>
                <ul class="radio-filter">
                    <li>
                        <input class="form-check-input" type="radio" name="filter_domain" id="domain_all" value="" {{ !request('filter_domain') ? 'checked' : '' }} onchange="this.form.submit()">
                        <label for="domain_all">Tất cả</label>
                    </li>
                    <li>
                        <input class="form-check-input" type="radio" name="filter_domain" id="domain_b" value="b" {{ request('filter_domain') == 'b' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label for="domain_b">Miền Bắc</label>
                    </li>
                    <li>
                        <input class="form-check-input" type="radio" name="filter_domain" id="domain_t" value="t" {{ request('filter_domain') == 't' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label for="domain_t">Miền Trung</label>
                    </li>
                    <li>
                        <input class="form-check-input" type="radio" name="filter_domain" id="domain_n" value="n" {{ request('filter_domain') == 'n' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label for="domain_n">Miền Nam</label>
                    </li>
                </ul>
            </div>
            
            <div class="widget widget-reviews" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                <h6 class="widget-title">By Reviews</h6>
                <ul class="radio-filter">
                    <li>
                        <input class="form-check-input" type="radio" {{ !request('ByReviews') ? 'checked' : '' }} name="ByReviews" value="" id="review_all" onchange="this.form.submit()">
                        <label for="review_all">Tất cả</label>
                    </li>
                    <li>
                        <input class="form-check-input" type="radio" {{ request('ByReviews') == '5' ? 'checked' : '' }} name="ByReviews" value="5" id="review1" onchange="this.form.submit()">
                        <label for="review1">
                            <span class="ratting">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </span>
                        </label>
                    </li>
                </ul>
            </div>
            
            <div class="widget widget-languages" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                <h6 class="widget-title">By Languages</h6>
                <ul class="radio-filter">
                    <li>
                        <input class="form-check-input" type="radio" {{ !request('ByLanguages') ? 'checked' : '' }} name="ByLanguages" value="" id="language_all" onchange="this.form.submit()">
                        <label for="language_all">Tất cả</label>
                    </li>
                    <li>
                        <input class="form-check-input" type="radio" {{ request('ByLanguages') == 'Vietnamese' ? 'checked' : '' }} name="ByLanguages" value="Vietnamese" id="language5" onchange="this.form.submit()">
                        <label for="language5">Vietnamese</label>
                    </li>
                    <li>
                        <input class="form-check-input" type="radio" {{ request('ByLanguages') == 'English' ? 'checked' : '' }} name="ByLanguages" value="English" id="language2" onchange="this.form.submit()">
                        <label for="language2">English</label>
                    </li>
                </ul>
            </div>
            
            <div class="widget widget-duration" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                <h6 class="widget-title">Thời gian</h6>
                <ul class="radio-filter">
                    <li>
                        <input class="form-check-input" type="radio" name="filter_duration" id="duration_all" value="" {{ !request('filter_duration') ? 'checked' : '' }} onchange="this.form.submit()">
                        <label for="duration_all">Tất cả</label>
                    </li>
                    <li>
                        <input class="form-check-input" type="radio" name="filter_duration" id="duration1" value="0-2" {{ request('filter_duration') == '0-2' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label for="duration1">1 - 2 ngày</label>
                    </li>
                    <li>
                        <input class="form-check-input" type="radio" name="filter_duration" id="duration2" value="3-4" {{ request('filter_duration') == '3-4' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label for="duration2">3 - 4 ngày</label>
                    </li>
                    <li>
                        <input class="form-check-input" type="radio" name="filter_duration" id="duration3" value="5-8" {{ request('filter_duration') == '5-8' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label for="duration3">5 - 8 ngày</label>
                    </li>
                    <li>
                        <input class="form-check-input" type="radio" name="filter_duration" id="duration4" value="9-999" {{ request('filter_duration') == '9-999' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label for="duration4">Trên 8 ngày</label>
                    </li>
                </ul>
            </div>
            
            <div class="widget widget-tour" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
    <h6 class="widget-title border-bottom pb-2 mb-4">Tour Nổi Bật</h6>
    
    {{-- Lặp qua danh sách tour nổi bật được truyền từ Controller --}}
    @forelse($popularWidgetTours as $tour)
        <div class="destination-item tour-grid style-three bgc-lighter mb-4 shadow-sm" style="border-radius: 12px; overflow: hidden;">
            <div class="image position-relative">
                {{-- Badge dán nhãn HOT --}}
                <span class="badge bg-danger position-absolute top-0 start-0 m-2 z-1">🔥 HOT</span>
                
                {{-- Ảnh Tour động --}}
                <a href="{{ route('tour-detail', $tour->tourid) }}">
                    <img src="{{ asset('clients/assets/images/gallery-tours/' . ($tour->images ?? 'default.jpg')) }}" 
                         onerror="this.src='https://images.unsplash.com/photo-1599839619722-39751411ea63?q=80&w=400&auto=format&fit=crop'"
                         alt="{{ $tour->title }}"
                         style="height: 180px; width: 100%; object-fit: cover; transition: transform 0.3s;"
                         class="hover-zoom">
                </a>
            </div>
            
            <div class="content p-3 bg-white">
                <div class="destination-header d-flex justify-content-between align-items-center mb-2">
                    <span class="location text-muted small">
                        <i class="fal fa-map-marker-alt text-primary"></i> {{ $tour->destination }}
                    </span>
                    <div class="ratting text-warning small">
                        <i class="fas fa-star"></i>
                        <span class="text-dark fw-bold">(4.8)</span> {{-- Bạn có thể gắn $tour->rating thực tế nếu DB có --}}
                    </div>
                </div>
                
                <h6 class="mb-2" style="font-size: 15px; line-height: 1.4;">
                    <a href="{{ route('tour-detail', $tour->tourid) }}" class="text-dark text-decoration-none title-hover">
                        {{ $tour->title }}
                    </a>
                </h6>
                
                {{-- Hiển thị giá tiền (Tìm giá min trong các lịch khởi hành) --}}
                @php
                    $minPrice = $tour->schedules ? $tour->schedules->min('priceadult') : 0;
                @endphp
                
                <div class="price-wrap mt-2 pt-2 border-top">
                    @if($minPrice > 0)
                        <span class="small text-muted">Chỉ từ:</span>
                        <span class="text-danger fw-bold ms-1">{{ number_format($minPrice, 0, ',', '.') }} đ</span>
                    @else
                        <span class="text-success fw-bold small">Liên hệ ngay</span>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted small">Chưa có tour nổi bật nào.</p>
    @endforelse
</div>

{{-- Thêm chút CSS cho ảnh có hiệu ứng thu phóng khi rê chuột --}}
<style>
    .tour-grid .image { overflow: hidden; }
    .tour-grid .image img.hover-zoom:hover { transform: scale(1.08); }
    .title-hover:hover { color: #ff6a00 !important; }
</style>
            
            
        </div>
    </form>
</div>