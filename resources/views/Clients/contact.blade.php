@include('Clients.blocks.header')
@include('Clients.blocks.banner', ['title' => 'Liên Hệ'])

<section class="contact-info-area pt-100 rel z-1">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4">
                <div class="contact-info-content mb-30 rmb-55" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                    <div class="section-title mb-30">
                        <h2>Trò Chuyện Cùng Chuyên Gia Tư Vấn Du Lịch</h2>
                    </div>
                    <p>Đội ngũ hỗ trợ tận tâm của chúng tôi luôn sẵn sàng giúp đỡ bạn với bất kỳ câu hỏi hay vấn đề nào, mang đến các giải pháp nhanh chóng và cá nhân hóa để đáp ứng nhu cầu của bạn.</p>
                    <div class="features-team-box mt-40">
                        <h6>Hơn 85+ thành viên đội ngũ chuyên gia</h6>
                        <!--
                        <div class="feature-authors">
                            <img src="{{ asset('assets/images/features/feature-author1.jpg') }}" alt="Tác giả">
                            <img src="{{ asset('assets/images/features/feature-author2.jpg') }}" alt="Tác giả">
                            <img src="{{ asset('assets/images/features/feature-author3.jpg') }}" alt="Tác giả">
                            <img src="{{ asset('assets/images/features/feature-author4.jpg') }}" alt="Tác giả">
                            <img src="{{ asset('assets/images/features/feature-author5.jpg') }}" alt="Tác giả">
                            <img src="{{ asset('assets/images/features/feature-author6.jpg') }}" alt="Tác giả">
                            <img src="{{ asset('assets/images/features/feature-author7.jpg') }}" alt="Tác giả">
                            <span>+</span>
                        </div>
                    -->
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="contact-info-item" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50" data-aos-delay="50">
                            <div class="icon"><i class="fas fa-envelope"></i></div>
                            <div class="content">
                                <h5>Hỗ trợ & Trợ giúp</h5>
                                <a href="mailto:{{ get_setting('contact_email', 'support@goviet.com') }}" class="text-muted hover-info">{{ get_setting('contact_email', 'support@goviet.com') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-info-item" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50" data-aos-delay="100">
                            <div class="icon"><i class="fas fa-phone"></i></div>
                            <div class="content">
                                <h5>Liên hệ Khẩn cấp</h5>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', get_setting('hotline', '+84123456789')) }}" class="fw-bold fs-4 text-warning text-decoration-none">
                                    {{ get_setting('hotline', '+84 (123) 456 789') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-info-item" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50" data-aos-delay="50">
                            <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="content">
                                <h5>Chi nhánh Việt Nam</h5>
                                <div class="text"><i class="fal fa-map-marker-alt"></i> Đà Nẵng, Việt Nam</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-info-item" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50" data-aos-delay="100">
                            <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="content">
                                <h5>Trụ sở chính</h5>
                                <span>{{ get_setting('company_address', '123 Đường Lê Lợi, TP. Đà Nẵng, Việt Nam') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact-form-area py-70 rel z-1">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="comment-form bgc-lighter z-1 rel mb-30 rmb-55">
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="section-title">
                            <h2>Gửi Tin Nhắn Cho Chúng Tôi</h2>
                        </div>
                        <p>Địa chỉ email của bạn sẽ được bảo mật. Các trường bắt buộc được đánh dấu *</p>
                        <div class="row mt-35">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Họ và Tên *</label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Ví dụ: Nguyễn Văn A" required data-error="Vui lòng nhập tên của bạn">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_number">Số Điện Thoại *</label>
                                    <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="Nhập số điện thoại" required data-error="Vui lòng nhập số điện thoại">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Địa chỉ Email *</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="email@vi-du.com" required data-error="Vui lòng nhập email">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="message">Lời nhắn của bạn *</label>
                                    <textarea name="message" id="message" class="form-control" rows="5" placeholder="Bạn cần chúng tôi giúp đỡ điều gì?" required data-error="Vui lòng nhập nội dung tin nhắn"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-0">
                                    <ul class="radio-filter mb-25">
                                        <li>
                                            <input class="form-check-input" type="checkbox" name="terms-condition" id="terms-condition">
                                            <label for="terms-condition">Lưu thông tin của tôi cho những lần gửi thông tin tiếp theo.</label>
                                        </li>
                                    </ul>
                                    <button type="submit" class="theme-btn style-two">
                                        <span data-hover="Gửi ngay">Gửi tin nhắn</span>
                                        <i class="fal fa-arrow-right"></i>
                                    </button>
                                    <div id="msgSubmit" class="hidden"></div>
                                </div>
                            </div>
                        </div>
                        @if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
                    </form>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="contact-images-part" data-aos="fade-right" data-aos-duration="1500" data-aos-offset="50">
                    <div class="row">
                        <div class="col-12">
                            <img src="{{ asset('clients/assets/images/contact/contact1.jpg') }}" alt="Liên hệ 1">
                        </div>
                        <div class="col-6">
                            <img src="{{ asset('clients/assets/images/contact/contact2.jpg') }}" alt="Liên hệ 2">
                        </div>
                        <div class="col-6">
                            <img src="{{ asset('clients/assets/images/contact/contact3.jpg') }}" alt="Liên hệ 3">
                        </div>
                    </div>
                    <div class="circle-logo">
                        <img src="{{ asset('clients/assets/images/logos/logo.png') }}" alt="Logo">
                        <span class="title h2">GoViet</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--
<div class="contact-map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m12!1m3!1d3724.60334803975!2d105.803738!3d21.012521!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjHCsDAwJzQ1LjEiTiAxMDXCsDQ4JzEzLjUiRQ!5e0!3m2!1svi!2s!4v1647412500000!5m2!1svi!2s" style="border:0; width: 100%; height: 450px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
-->

@include('Clients.blocks.footer')