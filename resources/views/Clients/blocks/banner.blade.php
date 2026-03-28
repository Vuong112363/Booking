@php
    // Lấy ảnh từ database, nếu không có thì dùng ảnh mặc định image.png
    $bannerUrl = get_setting('hero_banner', 'clients/assets/images/logos/image.png');
@endphp

<section class="page-banner-area pt-50 pb-35 rel z-1 bgs-cover" 
         style="background-image: url('{{ asset(get_setting('hero_banner', 'clients/assets/images/banner/image.png')) }}');">
    <div class="container-fluid px-lg-5">
        <div class="banner-inner text-white">
            <h2 class="page-title mb-10" data-aos="fade-left" data-aos-duration="1500" data-aos-offset="50">{{$title}}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-20" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1500" data-aos-offset="50">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">{{$title}}</li>
                </ol>           
            </nav>
        </div>
    </div>
</section>