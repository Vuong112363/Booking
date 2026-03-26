<section class="hero-area bgc-black pt-200 rpt-120 rel z-2">
    <div class="container-fluid">

        <h1 class="hero-title" data-aos="flip-up" data-aos-delay="50" data-aos-duration="1500">
            Tour & Du Lịch
        </h1>

        <div class="main-hero-image bgs-cover"
     style="background-image: url({{ asset(get_setting('hero_banner', 'clients/assets/images/hero/hero.jpg')) }});">
</div>

    </div>

    <!-- FORM SEARCH -->
    <form action="{{ route('Tours') }}" method="GET" class="search-filter-form">

        <div class="container container-1400">

            <div class="search-filter-inner" data-aos="zoom-out-down" data-aos-duration="1500">

                <!-- Điểm đến -->
                <div class="filter-item clearfix">
                    <div class="icon"><i class="fal fa-map-marker-alt"></i></div>
                    <span class="title">Điểm Đến</span>

                    <select name="destination">
                        <option value="">Thành phố hoặc Vùng</option>
                        <option value="Đà Nẵng">Đà Nẵng</option>
                        <option value="Nha Trang">Nha Trang</option>
                        <option value="Phú Quốc">Phú Quốc</option>
                        <option value="Đà Lạt">Đà Lạt</option>
                    </select>
                </div>

                <!-- Ngày khởi hành -->
                <div class="filter-item clearfix">
                    <div class="icon"><i class="fal fa-calendar-alt"></i></div>
                    <span class="title">Ngày Khởi Hành</span>

                    <input type="date" name="start_date">
                </div>

                <!-- Ngày kết thúc -->
                <div class="filter-item clearfix">
                    <div class="icon"><i class="fal fa-calendar-alt"></i></div>
                    <span class="title">Ngày Kết Thúc</span>

                    <input type="date" name="end_date">
                </div>

                <!-- Hành khách -->
                <div class="filter-item clearfix">
                    <div class="icon"><i class="fal fa-users"></i></div>
                    <span class="title">Hành Khách</span>

                    <select name="guests">
                        <option value="">Số người</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4+</option>
                    </select>
                </div>

                <!-- BUTTON -->
                <div class="search-button">

                    <button type="submit" class="theme-btn">

                        <span data-hover="Tìm Kiếm">Tìm Kiếm</span>

                        <i class="fas fa-search"></i>

                    </button>

                </div>

            </div>

        </div>

    </form>
</section>