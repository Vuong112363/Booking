<div class="col-lg-3 col-md-6 col-sm-10 rmb-75">
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
                <h6 class="widget-title">Duration</h6>
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
                <h6 class="widget-title">Popular Tours</h6>
                <div class="destination-item tour-grid style-three bgc-lighter">
                    <div class="image">
                        <span class="badge">10% Off</span>
                        <img src="{{ asset('clients/assets/images/widgets/tour1.jpg') }}" alt="Tour">
                    </div>
                    <div class="content">
                        <div class="destination-header">
                            <span class="location"><i class="fal fa-map-marker-alt"></i> Bali, Indonesia</span>
                            <div class="ratting">
                                <i class="fas fa-star"></i>
                                <span>(4.8)</span>
                            </div>
                        </div>
                        <h6><a href="tour-details.html">Relinking Beach, Bali, Indonesia</a></h6>
                    </div>
                </div>
            </div>
            
            <div class="widget widget-cta mt-30" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                <div class="content text-white">
                    <span class="h6">Explore The World</span>
                    <h3>Best Tourist Place</h3>
                    <a href="tour-list.html" class="theme-btn style-two bgc-secondary">
                        <span data-hover="Explore Now">Explore Now</span>
                        <i class="fal fa-arrow-right"></i>
                    </a>
                </div>
                <div class="image">
                    <img src="{{ asset('clients/assets/images/widgets/cta-widget.png') }}" alt="CTA">
                </div>
                <div class="cta-shape"><img src="{{ asset('clients/assets/images/widgets/cta-shape2.png') }}" alt="Shape"></div>
            </div>
            
        </div>
    </form>
</div>
