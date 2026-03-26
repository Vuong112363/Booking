@include('Clients.blocks.header')
@include('Clients.blocks.banner', ['title' => 'Về Chúng Tôi'])

{{-- CSS NÂNG CẤP MASTERPIECE --}}
<style>
    /* Typography & Color */
    .text-gradient {
        background: linear-gradient(135deg, #ff5722 0%, #ff9800 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }
    .bg-gradient-primary { background: linear-gradient(135deg, #ff5722 0%, #ff9800 100%); }
    
    /* Tạo Không Gian Thở (Whitespace) Sang Trọng */
    .py-spacing {
        padding-top: 100px;
        padding-bottom: 100px;
    }
    @media (max-width: 991px) {
        .py-spacing {
            padding-top: 70px;
            padding-bottom: 70px;
        }
    }

    /* Hiệu ứng Glassmorphism (Kính mờ) */
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    /* Hình ảnh chồng lấp (Overlapping Images) */
    .about-image-grid { position: relative; padding-bottom: 10%; }
    .img-main { width: 80%; border-radius: 1.5rem; box-shadow: 0 20px 40px rgba(0,0,0,0.1); z-index: 1; position: relative; }
    .img-sub { width: 50%; border-radius: 1.5rem; border: 8px solid #fff; box-shadow: 0 20px 40px rgba(0,0,0,0.15); position: absolute; bottom: 0; right: 0; z-index: 2; transform: translateY(15%); }
    
    /* Animation Floating */
    .floating-element { animation: float-up-down 4s ease-in-out infinite; }
    @keyframes float-up-down {
        0% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0); }
    }

    /* Timeline Lịch sử */
    .timeline-container { position: relative; padding-left: 3rem; border-left: 2px dashed #ff9800; }
    .timeline-item { position: relative; margin-bottom: 2.5rem; }
    .timeline-item::before {
        content: ''; position: absolute; left: -3.45rem; top: 0;
        width: 20px; height: 20px; border-radius: 50%;
        background: #ff5722; border: 4px solid #fff; box-shadow: 0 0 0 3px rgba(255,87,34,0.2);
    }

    /* Card Giá trị cốt lõi hover */
    .core-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border-bottom: 4px solid transparent;
        overflow: hidden;
    }
    .core-card::before {
        content: ''; position: absolute; top: -100%; left: 0; width: 100%; height: 100%;
        background: linear-gradient(135deg, rgba(255,87,34,0.05), transparent);
        transition: all 0.4s ease; z-index: 0;
    }
    .core-card:hover { transform: translateY(-10px); border-bottom: 4px solid #ff5722; box-shadow: 0 1.5rem 3rem rgba(0,0,0,.1) !important; }
    .core-card:hover::before { top: 0; }
    .core-card > div { position: relative; z-index: 1; }

    /* Team Hover mượt mà */
    .team-card .social-links { position: absolute; bottom: -50px; left: 0; width: 100%; transition: all 0.4s ease; opacity: 0; }
    .team-card:hover .social-links { bottom: 20px; opacity: 1; }
    .team-card:hover img { transform: scale(1.05); transition: transform 0.5s ease; filter: brightness(0.8); }

    /* Nút Play Video */
    .btn-play-video {
        width: 80px; height: 80px; border-radius: 50%;
        background: #fff; color: #ff5722; font-size: 24px;
        display: flex; align-items: center; justify-content: center;
        animation: pulse-white 2s infinite; cursor: pointer;
    }
    @keyframes pulse-white {
        0% { box-shadow: 0 0 0 0 rgba(255,255,255,0.7); }
        70% { box-shadow: 0 0 0 20px rgba(255,255,255,0); }
        100% { box-shadow: 0 0 0 0 rgba(255,255,255,0); }
    }
</style>

{{-- PHẦN 1: HERO ABOUT (OVERLAPPING LAYOUT) --}}
<section class="about-hero py-spacing bg-white rel z-1 overflow-hidden">
    <div class="container">
        <div class="row align-items-center g-5">
            
            {{-- Cột Hình Ảnh Phức Tạp --}}
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="about-image-grid" data-aos="fade-right" data-aos-duration="1500">
                    <img src="{{ asset('clients/assets/images/about/about2.png') }}" alt="GoViet Main" class="img-main">
                    <img src="{{ asset('clients/assets/images/about/about1.png') }}" alt="GoViet Sub" class="img-sub">
                    
                    
                </div>
            </div>
            
            {{-- Cột Nội Dung --}}
            <div class="col-lg-6 ps-lg-5">
                <div data-aos="fade-left" data-aos-duration="1500">
                    <h6 class="text-primary fw-bold text-uppercase tracking-wider mb-3" style="letter-spacing: 2px;">Về GoViet Travel</h6>
                    <h2 class="fw-bold mb-4 display-5 lh-sm text-dark">Kiến tạo kỷ niệm,<br><span class="text-gradient">Chạm đến trái tim.</span></h2>
                    
                    <p class="text-muted mb-5 fs-6" style="line-height: 1.8;">
                        Không chỉ là những chuyến đi, <strong>GoViet</strong> là cầu nối văn hóa mang bạn đến gần hơn với nhịp đập thực sự của vùng đất. Chúng tôi thiết kế những trải nghiệm độc bản, nơi mỗi bước chân đều là một câu chuyện đáng nhớ.
                    </p>
                    
                    <div class="row g-4 mb-5">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-3">
                                <i class="fas fa-shield-check text-primary fs-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Uy tín tuyệt đối</h6>
                                    <p class="text-muted small mb-0">Hơn 15,000+ khách hàng tin tưởng mỗi năm.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-3">
                                <i class="fas fa-headset text-primary fs-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Hỗ trợ 24/7</h6>
                                    <p class="text-muted small mb-0">Đội ngũ chuyên gia luôn sẵn sàng đồng hành.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('Tours') }}" class="btn btn-dark rounded-pill px-5 py-3 fw-bold hover-lift">
                        Bắt Đầu Hành Trình <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</section>

{{-- PHẦN 2: GIÁ TRỊ CỐT LÕI (HOVER CARD) --}}
<section class="core-values py-spacing bg-light">
    <div class="container">
        <div class="text-center mb-5 pb-4" data-aos="fade-up">
            <h2 class="fw-bold display-6">Tại sao chọn GoViet?</h2>
            <p class="text-muted mx-auto mt-3" style="max-width: 600px;">Chúng tôi đặt tiêu chuẩn cao nhất cho mọi dịch vụ, đảm bảo mỗi chuyến đi của bạn đều hoàn hảo đến từng chi tiết.</p>
        </div>
        
        <div class="row g-4">
    <div class="col-lg-3 col-md-6">
        <div class="card core-card bg-white p-4 h-100 rounded-4 shadow-sm text-center" data-aos="fade-up" data-aos-delay="100">
            <div>
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px; font-size: 32px; background-color: rgba(13, 110, 253, 0.1); color: #0d6efd;">
                    <i class="fas fa-route"></i>
                </div>
                <h5 class="fw-bold mb-3">Lịch trình Độc quyền</h5>
                {{-- Đổi thẻ p thành div và ép CSS cứng --}}
                <div style="color: #6b7280 !important; font-size: 14.5px !important; display: block !important; line-height: 1.6;">Khám phá những điểm đến bí ẩn mà không có trong các tour đại trà.</div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card core-card bg-white p-4 h-100 rounded-4 shadow-sm text-center" data-aos="fade-up" data-aos-delay="200">
            <div>
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px; font-size: 32px; background-color: rgba(25, 135, 84, 0.1); color: #198754;">
                    <i class="fas fa-tag"></i>
                </div>
                <h5 class="fw-bold mb-3">Giá trị Thực</h5>
                <div style="color: #6b7280 !important; font-size: 14.5px !important; display: block !important; line-height: 1.6;">Cam kết không ẩn phí, mang lại trải nghiệm vượt xa số tiền bạn bỏ ra.</div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card core-card bg-white p-4 h-100 rounded-4 shadow-sm text-center" data-aos="fade-up" data-aos-delay="300">
            <div>
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px; font-size: 32px; background-color: rgba(255, 193, 7, 0.15); color: #ffc107;">
                    <i class="fas fa-bed"></i>
                </div>
                <h5 class="fw-bold mb-3">Dịch vụ Cao cấp</h5>
                <div style="color: #6b7280 !important; font-size: 14.5px !important; display: block !important; line-height: 1.6;">Lưu trú tại các resort/khách sạn từ 4 sao trở lên được tuyển chọn kỹ lưỡng.</div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card core-card bg-white p-4 h-100 rounded-4 shadow-sm text-center" data-aos="fade-up" data-aos-delay="400">
            <div>
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px; font-size: 32px; background-color: rgba(220, 53, 69, 0.1); color: #dc3545;">
                    <i class="fas fa-users"></i>
                </div>
                <h5 class="fw-bold mb-3">HDV Bản địa</h5>
                <div style="color: #6b7280 !important; font-size: 14.5px !important; display: block !important; line-height: 1.6;">Đội ngũ hướng dẫn viên giàu kinh nghiệm, nhiệt tình như người nhà.</div>
            </div>
        </div>
    </div>
</div>
    </div>
</section>

{{-- PHẦN 3: TIMELINE (HÀNH TRÌNH PHÁT TRIỂN) & STATS --}}
{{-- PHẦN 3: TIMELINE (HÀNH TRÌNH PHÁT TRIỂN) & STATS --}}
<section class="journey-section py-spacing bg-white">
    <div class="container">
        <div class="row g-5 align-items-center">
            
            <div class="col-lg-6" data-aos="fade-right">
                <h6 class="text-primary fw-bold text-uppercase mb-3">Câu chuyện của chúng tôi</h6>
                <h2 class="fw-bold mb-5 display-6">Hành trình vươn xa</h2>
                
                <div class="timeline-container mt-4">
                    <div class="timeline-item">
                        <h5 class="fw-bold text-dark">2024 - Những bước chân đầu tiên</h5>
                        {{-- Thay <p> bằng <div> --}}
                        <div style="color: #6b7280 !important; font-size: 14.5px !important; display: block !important; line-height: 1.6;">GoViet ra đời với mong muốn mang lại các tour phượt mạo hiểm vùng Tây Bắc cho giới trẻ.</div>
                    </div>
                    <div class="timeline-item">
                        <h5 class="fw-bold text-dark">2025 - Số hóa hệ thống</h5>
                        {{-- Thay <p> bằng <div> --}}
                        <div style="color: #6b7280 !important; font-size: 14.5px !important; display: block !important; line-height: 1.6;">Ra mắt nền tảng đặt tour trực tuyến, tiếp cận hơn 5,000+ khách hàng trên toàn quốc.</div>
                    </div>
                    <div class="timeline-item">
                        <h5 class="fw-bold text-gradient">2026 - Định hình chuẩn mực mới</h5>
                        {{-- Thay <p> bằng <div> --}}
                        <div style="color: #6b7280 !important; font-size: 14.5px !important; display: block !important; line-height: 1.6; margin-bottom: 0;">Trở thành đối tác chiến lược của nhiều thương hiệu lớn, mở rộng mạng lưới tour nghỉ dưỡng cao cấp.</div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 ps-lg-5" data-aos="fade-left">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="bg-light p-4 rounded-4 shadow-sm text-center hover-lift border-bottom border-primary border-4 h-100">
                            <h2 class="display-5 fw-bold text-dark mb-0">15<span class="text-primary">k+</span></h2>
                            {{-- Thay <p> bằng <div> --}}
                            <div style="color: #6b7280 !important; font-weight: 500 !important; text-transform: uppercase !important; font-size: 14px !important; display: block !important; margin-top: 1rem;">Khách Hàng</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="bg-light p-4 rounded-4 shadow-sm text-center hover-lift border-bottom border-success border-4 h-100 mt-sm-5">
                            <h2 class="display-5 fw-bold text-dark mb-0">120<span class="text-success">+</span></h2>
                            {{-- Thay <p> bằng <div> --}}
                            <div style="color: #6b7280 !important; font-weight: 500 !important; text-transform: uppercase !important; font-size: 14px !important; display: block !important; margin-top: 1rem;">Tour Độc Bản</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="bg-light p-4 rounded-4 shadow-sm text-center hover-lift border-bottom border-warning border-4 h-100 mt-sm-n5">
                            <h2 class="display-5 fw-bold text-dark mb-0">4.9<span class="text-warning"><i class="fas fa-star fs-4"></i></span></h2>
                            {{-- Thay <p> bằng <div> --}}
                            <div style="color: #6b7280 !important; font-weight: 500 !important; text-transform: uppercase !important; font-size: 14px !important; display: block !important; margin-top: 1rem;">Đánh Giá</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="bg-light p-4 rounded-4 shadow-sm text-center hover-lift border-bottom border-danger border-4 h-100">
                            <h2 class="display-5 fw-bold text-dark mb-0">36<span class="text-danger">+</span></h2>
                            {{-- Thay <p> bằng <div> --}}
                            <div style="color: #6b7280 !important; font-weight: 500 !important; text-transform: uppercase !important; font-size: 14px !important; display: block !important; margin-top: 1rem;">Tỉnh Thành</div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
{{-- PHẦN 4: ĐỘI NGŨ CHUYÊN GIA (MODERN CARD) --}}
<section class="team-section py-spacing bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5 pb-3" data-aos="fade-up">
            <div>
                <h6 class="text-primary fw-bold text-uppercase mb-3">Đội ngũ của chúng tôi</h6>
                <h2 class="fw-bold display-6 mb-0">Những người dẫn đường<br>tận tâm nhất</h2>
            </div>
            <a href="#" class="btn btn-outline-dark rounded-pill px-4 d-none d-md-inline-flex pb-2 pt-2">Gia nhập GoViet</a>
        </div>
        
        <div class="row g-4">
            @php
                $team = [
                    ['name' => 'Nguyễn Văn Hùng', 'role' => 'Trưởng Nhóm Điều Hành', 'img' => 'guide1.jpg'],
                    ['name' => 'Lê Thị Mai', 'role' => 'Chuyên Gia Trải Nghiệm', 'img' => 'guide2.jpg'],
                    ['name' => 'Trần Minh Nam', 'role' => 'Giám Đốc Hình Ảnh', 'img' => 'guide3.jpg'],
                    ['name' => 'Phạm Quang Đức', 'role' => 'HDV Xuyên Việt', 'img' => 'guide4.jpg'],
                ];
            @endphp
            
            @foreach($team as $index => $member)
            <div class="col-lg-3 col-md-6">
                <div class="card team-card border-0 rounded-4 overflow-hidden shadow-sm bg-white" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="position-relative overflow-hidden" style="height: 380px;">
                        <img src="{{ asset('clients/assets/images/team/'.$member['img']) }}" onerror="this.src='https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=600&auto=format&fit=crop'" alt="{{ $member['name'] }}" class="w-100 h-100 object-fit-cover">
                        
                        <div class="social-links d-flex justify-content-center gap-2">
                            <a href="#" class="btn btn-light btn-sm rounded-circle shadow" style="width:38px; height:38px; line-height:24px;"><i class="fab fa-facebook-f text-primary"></i></a>
                            <a href="#" class="btn btn-light btn-sm rounded-circle shadow" style="width:38px; height:38px; line-height:24px;"><i class="fab fa-instagram text-danger"></i></a>
                            <a href="#" class="btn btn-light btn-sm rounded-circle shadow" style="width:38px; height:38px; line-height:24px;"><i class="fab fa-linkedin-in text-info"></i></a>
                        </div>
                    </div>
                    <div class="card-body text-center p-4">
                        <h5 class="fw-bold text-dark mb-2">{{ $member['name'] }}</h5>
                        <p class="text-muted small mb-0">{{ $member['role'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PHẦN 5: VIDEO PARALLAX CỰC MẠNH --}}
<section class="video-parallax position-relative py-spacing" style="background: url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=1600&auto=format&fit=crop') no-repeat center center / cover; background-attachment: fixed; min-height: 600px; display: flex; align-items: center;">
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.65;"></div>
    
    <div class="container position-relative z-1 text-center">
        <div data-aos="zoom-in" data-aos-duration="1500">
            <a href="https://www.youtube.com/watch?v=9Y7ma241N8k" class="mfp-iframe btn-play-video mx-auto mb-5 text-decoration-none">
                <i class="fas fa-play ms-1"></i>
            </a>
            <h2 class="display-4 fw-bold text-white mb-4">Khám phá dải đất chữ S<br>qua lăng kính GoViet</h2>
            <p class="text-white-50 fs-5 mb-0">Hơn cả một chuyến đi, đó là sự trở về với thiên nhiên.</p>
        </div>
    </div>
</section>

{{-- PHẦN 6: ĐỐI TÁC THANH TOÁN & ĐỒNG HÀNH --}}
<section class="partner-area py-5 bg-white border-bottom">
    <div class="container py-4">
        <h6 class="text-center text-muted text-uppercase fw-bold tracking-wider mb-5" style="letter-spacing: 2px;">Hệ Sinh Thái Đối Tác Uy Tín</h6>
        <hr class="border-secondary">
        <div class="row justify-content-center align-items-center g-4 opacity-75">
            {{-- Chèn logo của bạn vào đây. Mình dùng ảnh giả lập nếu ko có src --}}
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 text-center" data-aos="fade-up" data-aos-delay="100">
                <img src="{{ asset('clients/assets/images/checkout/momo.png') }}" alt="Momo" class="img-fluid partner-logo" style="max-height: 45px;">
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 text-center" data-aos="fade-up" data-aos-delay="200">
                <img src="{{ asset('clients/assets/images/checkout/vnpay.png') }}" alt="VNPay" class="img-fluid partner-logo" style="max-height: 45px;">
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 text-center" data-aos="fade-up" data-aos-delay="300">
                <img src="{{ asset('clients/assets/images/checkout/zalo.png') }}"alt="ZaloPay" class="img-fluid partner-logo" style="max-height: 45px;">
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 text-center" data-aos="fade-up" data-aos-delay="400">
                <img src="{{ asset('clients/assets/images/checkout/visa.png') }}" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png'" alt="Visa" class="img-fluid partner-logo" style="max-height: 45px;">
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 text-center" data-aos="fade-up" data-aos-delay="500">
                <img src="{{ asset('clients/assets/images/checkout/mastercard.png') }}" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png'" alt="MasterCard" class="img-fluid partner-logo" style="max-height: 45px;">
            </div>
        </div>
    </div>
</section>

@include('Clients.blocks.footer')