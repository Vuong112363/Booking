@include('Clients.blocks.header')
@include('Clients.blocks.banner_home')

{{-- ================= SECTION 1: LỢI ÍCH & CẨM NANG ================= --}}
<section class="benefit-area py-5 bg-light">
    <div class="container py-4">
        <div class="row align-items-center">
            {{-- Cột Hình ảnh --}}
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="position-relative pe-lg-4" data-aos="fade-right" data-aos-duration="1000">
                    <img src="{{ asset('clients/assets/images/benefit/benefit1.png') }}" onerror="this.src='{{ asset('clients/assets/images/default-tour.jpg') }}'" class="img-fluid rounded-4 shadow" alt="Lợi ích">
                    <img src="{{ asset('clients/assets/images/benefit/benefit2.png') }}" onerror="this.src='{{ asset('clients/assets/images/default-tour.jpg') }}'" class="img-fluid rounded-4 shadow position-absolute" style="width: 50%; bottom: -10%; right: 0; border: 5px solid #fff;" alt="Lợi ích">
                </div>
            </div>
            
            {{-- Cột Nội dung --}}
            <div class="col-lg-6 ps-lg-5">
                <div class="benefit-content" data-aos="fade-left" data-aos-duration="1000">
                    <h2 class="fw-bold mb-4">Cẩm Nang Khám Phá Tuyệt Đỉnh – Hướng Dẫn Hành Trình Trọn Vẹn</h2>
                    <p class="text-muted mb-4">Chúng tôi đồng hành cùng bạn để thấu hiểu mọi mong muốn, từ đó đưa ra những giải pháp du lịch tùy chỉnh nhằm tối ưu hóa trải nghiệm, mang lại sự hài lòng và những kỷ niệm bền vững.</p>
                    
                    <div class="skillbar-box mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-semibold text-dark">Mức Độ Hài Lòng Của Khách Hàng</span>
                            <span class="text-primary fw-bold">93%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 93%" aria-valuenow="93" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <ul class="list-unstyled mb-4">
                        <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Đại lý du lịch giàu kinh nghiệm</li>
                        <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Đội ngũ hướng dẫn viên chuyên nghiệp</li>
                        <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Hỗ trợ khách hàng 24/7</li>
                    </ul>
                    
                    <a href="{{ route('about') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold shadow-sm">
                        Xem Hướng Dẫn <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= SECTION 2: ĐỘI NGŨ ================= --}}
<section class="team-area py-5 bg-white">
    <div class="container py-4">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center" data-aos="fade-up" data-aos-duration="1000">
                <h2 class="fw-bold">Gặp Gỡ Đội Ngũ Hướng Dẫn Viên</h2>
                <p class="text-muted">Đồng hành cùng hơn <span class="text-primary fw-bold">150+</span> chuyên gia bản địa</p>
            </div>
        </div>
        
        <div class="row">
            @php
                $dummyTeam = [
                    ['name' => 'Nguyễn Văn Hùng', 'role' => 'Chuyên Gia Tour Leo Núi', 'img' => 'guide1.jpg'],
                    ['name' => 'Lê Thị Mai', 'role' => 'Hướng Dẫn Viên Văn Hóa', 'img' => 'guide2.jpg'],
                    ['name' => 'Trần Hoàng Nam', 'role' => 'Chuyên Gia Ẩm Thực', 'img' => 'guide3.jpg'],
                    ['name' => 'Phạm Minh Đức', 'role' => 'Hướng Dẫn Viên Xuyên Việt', 'img' => 'guide4.jpg'],
                ];
            @endphp

            @foreach($dummyTeam as $index => $member)
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-4">
                <div class="card border-0 shadow-sm h-100 team-card-clean" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" data-aos-duration="1000">
                    <img src="{{ asset('clients/assets/images/team/' . $member['img']) }}" onerror="this.src='{{ asset('clients/assets/images/default-tour.jpg') }}'" class="card-img-top object-fit-cover" style="height: 250px;" alt="{{ $member['name'] }}">
                    <div class="card-body text-center">
                        <h6 class="card-title fw-bold mb-1">{{ $member['name'] }}</h6>
                        <small class="text-muted d-block mb-3">{{ $member['role'] }}</small>
                        <div class="social-links">
                            <a href="#" class="text-muted mx-1"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-muted mx-1"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-muted mx-1"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <a href="#" class="btn btn-outline-primary px-4 py-2 rounded-pill fw-semibold">
                Xem Tất Cả Đội Ngũ <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- ================= SECTION 3: ĐÁNH GIÁ ================= --}}
<section class="testimonials-area py-5 bg-light">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="position-relative" data-aos="fade-right" data-aos-duration="1000">
                    <img src="{{ asset('clients/assets/images/testimonials/testimonial-left2.png') }}" class="img-fluid rounded-4 shadow" alt="Đánh giá">
                    <div class="position-absolute bottom-0 start-0 bg-dark text-white p-3 m-3 rounded-3 shadow-sm">
                        <h6 class="mb-1">Đánh giá tích cực</h6>
                        <div class="text-warning small">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 ps-lg-5">
                <div class="testimonial-content" data-aos="fade-left" data-aos-duration="1000">
                    <h2 class="fw-bold mb-4">Hơn <span class="text-primary">5280</span> Khách Hàng Nói Gì</h2>
                    
                    <div class="card border-0 shadow-sm p-4 rounded-4">
                        <i class="fas fa-quote-left text-primary fs-3 mb-3 opacity-50"></i>
                        <h5 class="fw-bold">Dịch Vụ Chất Lượng</h5>
                        <div class="text-warning small mb-3">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="text-muted fst-italic">"Chuyến đi của chúng tôi thực sự hoàn hảo nhờ công ty du lịch này! Họ chăm chút từng chi tiết nhỏ, từ chỗ ở đến các trải nghiệm thực tế tuyệt vời."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<style>
    /* ==========================================================================
   GOVIET CLEAN UI - TRANG CHỦ
   ========================================================================== */
.team-card-clean {
    transition: all 0.3s ease;
    overflow: hidden;
}

.team-card-clean:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.team-card-clean .social-links a {
    display: inline-block;
    width: 30px;
    height: 30px;
    line-height: 30px;
    border-radius: 50%;
    background-color: #f8f9fa;
    transition: all 0.3s;
}

.team-card-clean .social-links a:hover {
    background-color: #0d6efd;
    color: #fff !important;
}

.benefit-area .position-relative {
    padding-bottom: 10%; /* Chừa chỗ cho ảnh nhỏ đè lên */
}
</style>
@include('Clients.blocks.footer')