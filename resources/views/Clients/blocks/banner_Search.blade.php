<!-- Banner  -->

<section class="page-banner-area pt-50 pb-35 rel z-1 bgs-cover" 
         style="background-image: url('{{ asset(get_setting('hero_banner', 'clients/assets/images/logos/image.png')) }}');">
    <div class="container">
        <div class="banner-inner text-white mb-50">
            <h2 class="page-title mb-10" data-aos="fade-left" data-aos-duration="1500" data-aos-offset="50">Điểm Đến</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-20" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1500" data-aos-offset="50">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Điểm Đến</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<div class="container container-1400">
    <form action="{{ route('Tours') }}" method="GET" class="search-filter-inner">
        <input type="hidden" name="search" value="1">

    <!-- Điểm đến -->
    <div class="filter-item clearfix">
        <div class="icon"><i class="fal fa-map-marker-alt"></i></div>
        <span class="title">Điểm Đến</span>

        <input type="text"
               name="destination"
               value="{{ request('destination') }}"
               placeholder="Bạn muốn đi đâu?"
               class="form-control border-0 shadow-none bg-transparent px-0 text-muted">
    </div>

    <!-- Ngày khởi hành -->
    <div class="filter-item clearfix">
        <div class="icon"><i class="fal fa-calendar-alt"></i></div>
        <span class="title">Ngày Khởi Hành</span>

        <input type="date"
               name="start_date"
               value="{{ request('start_date') }}"
               class="form-control border-0 shadow-none bg-transparent px-0 text-muted">
    </div>

    <!-- Ngày kết thúc -->
    <div class="filter-item clearfix">
        <div class="icon"><i class="fal fa-calendar-check"></i></div>
        <span class="title">Ngày Kết Thúc</span>

        <input type="date"
               name="end_date"
               value="{{ request('end_date') }}"
               class="form-control border-0 shadow-none bg-transparent px-0 text-muted">
    </div>

    <!-- Hành khách -->
    <div class="filter-item clearfix">
        <div class="icon"><i class="fal fa-users"></i></div>
        <span class="title">Hành Khách</span>

        <select name="guests" class="form-control border-0 shadow-none bg-transparent px-0 text-muted">
            <option value="">Số lượng</option>
            <option value="1" {{ request('guests') == 1 ? 'selected' : '' }}>1 Người</option>
            <option value="2" {{ request('guests') == 2 ? 'selected' : '' }}>2 Người</option>
            <option value="3" {{ request('guests') == 3 ? 'selected' : '' }}>3 Người</option>
            <option value="4" {{ request('guests') == 4 ? 'selected' : '' }}>4+ Người</option>
        </select>
    </div>

    <div class="search-button">
        <button type="submit" class="theme-btn">
            <span>Tìm Kiếm</span>
            <i class="far fa-search"></i>
        </button>
    </div>

</form>
</div>

<style>
    /* CSS giúp các ô input không bị viền xanh khi click vào */
    .search-filter-inner .filter-item .form-control {
        background-color: transparent !important;
        font-size: 0.95rem;
    }
    .search-filter-inner .filter-item .form-control:focus {
        box-shadow: none;
        outline: none;
    }
    .cursor-pointer { cursor: pointer; }
</style>