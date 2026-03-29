{{-- ================= CUSTOM FOOTER CSS ================= --}}
<style>
    .custom-footer {
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        position: relative;
        color: #d5d5d5;
        margin-top: 80px; /* Tạo khoảng trống cho khối Newsletter trồi lên */
    }
    
    /* Lớp màng Gradient hiện đại phủ lên ảnh nền */
    .custom-footer::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(15, 32, 39, 0.95) 0%, rgba(32, 58, 67, 0.85) 50%, rgba(44, 83, 100, 0.95) 100%);
        z-index: 1;
    }

    .footer-content-wrapper { position: relative; z-index: 2; }

    /* Khối Đăng ký nhận tin nổi bật (Glassmorphism) */
    .newsletter-premium {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 40px 50px;
        transform: translateY(-50px); /* Đẩy trồi lên trên */
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }

    /* Tinh chỉnh Link Hover */
    .footer-widget.footer-links ul li { margin-bottom: 12px; }
    .footer-widget.footer-links ul li a {
        color: #d5d5d5;
        transition: all 0.3s ease;
        position: relative;
    }
    .footer-widget.footer-links ul li a:hover {
        color: #ff5722; /* Màu cam vàng nổi bật */
        padding-left: 8px;
    }
    .footer-widget.footer-links ul li a::before {
        content: '›';
        position: absolute;
        left: -15px;
        opacity: 0;
        color: #ff5722;
        transition: all 0.3s ease;
    }
    .footer-widget.footer-links ul li a:hover::before {
        left: -10px;
        opacity: 1;
    }

    /* Icon Liên hệ */
    .footer-contact ul li { margin-bottom: 15px; display: flex; align-items: flex-start; }
    .footer-contact ul li i { color: #ff5722; font-size: 18px; margin-right: 15px; margin-top: 5px; }
    .footer-contact ul li a:hover { color: #ff5722; }

 /* ================= CHATBOT CSS - BẢN PHÓNG TO & HIỆN ĐẠI ================= */
    #chat-bot-btn {
        position: fixed;
        bottom: 50px; /* Đưa xuống thấp hơn một chút cho đẹp */
        right: 50px;
        background-color: #ff5722;
        color: #fff;
        width: 65px;
        height: 65px;
        border-radius: 50%;
        text-align: center;
        line-height: 65px;
        font-size: 28px;
        cursor: pointer;
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        z-index: 9999;
        transition: all 0.3s ease;
    }
    #chat-bot-btn:hover { background-color: #ff5722; transform: scale(1.1) rotate(10deg); }

    #chat-bot-box {
        position: fixed;
        bottom: 120px; /* Cách nút bấm một khoảng vừa phải */
        right: 50px;
        width: 420px;  /* Tăng từ 350px lên 420px */
        height: 600px; /* Tăng từ 480px lên 600px */
        background: #fff;
        border-radius: 16px; /* Bo góc tròn hơn nhìn sang trọng */
        box-shadow: 0 15px 50px rgba(0,0,0,0.15);
        z-index: 9998;
        display: none; 
        flex-direction: column; 
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .chat-header {
        background: #ff5722;
        color: #fff;
        padding: 20px; /* Tăng padding cho thoáng */
        font-size: 18px;
        font-weight: 700;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .chat-header .close-chat { 
        cursor: pointer; 
        font-size: 22px; 
        opacity: 0.8;
        transition: 0.2s;
    }
    .chat-header .close-chat:hover { opacity: 1; }

    .chat-body {
        flex: 1; 
        padding: 20px;
        overflow-y: auto;
        background: #fdfdfd; /* Màu nền nhẹ nhàng hơn */
        display: flex;
        flex-direction: column;
        gap: 15px; /* Tăng khoảng cách giữa các tin nhắn */
        scroll-behavior: smooth;
    }

    /* Tùy chỉnh thanh cuộn cho đẹp */
    .chat-body::-webkit-scrollbar { width: 6px; }
    .chat-body::-webkit-scrollbar-thumb { background: #eee; border-radius: 10px; }

    .msg-bubble {
        max-width: 80%;
        padding: 12px 18px; /* Bong bóng tin nhắn lớn hơn */
        border-radius: 18px;
        font-size: 15px; /* Chữ to hơn cho dễ đọc */
        line-height: 1.5;
        word-wrap: break-word;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }

    /* Tin nhắn User: Màu vàng nhạt, chữ đen */
    .msg-user { 
        background: #ff5722; 
        color: #444; 
        align-self: flex-end; 
        border-bottom-right-radius: 4px; 
    }

    /* Tin nhắn Bot: Nền trắng, viền mảnh */
    .msg-bot { 
        background: #ffffff; 
        color: #333; 
        align-self: flex-start; 
        border: 1px solid #f0f0f0; 
        border-bottom-left-radius: 4px; 
    }

    /* Tin nhắn Admin: Màu xanh nổi bật */
    .msg-admin { 
        background: #007bff; 
        color: #fff; 
        align-self: flex-start; 
        border-bottom-left-radius: 4px; 
    }

    .chat-footer-box {
        padding: 15px 20px;
        background: #fff;
        border-top: 1px solid #f5f5f5;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .chat-footer-box input {
        flex: 1;
        padding: 12px 20px;
        border: 1px solid #ececec;
        border-radius: 25px;
        outline: none;
        font-size: 15px;
        transition: 0.3s;
        background: #f9f9f9;
    }
    .chat-footer-box input:focus { 
        border-color: #ff5722; 
        background: #fff;
        box-shadow: 0 0 0 3px rgba(255, 182, 6, 0.1);
    }

    .chat-footer-box button {
        background: #ff5722;
        color: white;
        border: none;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(255, 182, 6, 0.2);
    }
    .chat-footer-box button:hover { 
        background: #ff5722; 
        transform: rotate(-15deg); 
    }

    .typing-indicator { 
        font-size: 13px; 
        color: #aaa; 
        font-style: italic;
        margin-left: 20px;
        margin-bottom: 5px;
        display: none;
    }
    @media (max-width: 480px) {
    #chat-bot-box {
        width: 90%;
        height: 70%;
        right: 5%;
        bottom: 100px;
    }
}
</style>

{{-- ================= HTML FOOTER ================= --}}
<footer class="custom-footer" style="background-image: url('{{ asset('clients/assets/images/backgrounds/footer.jpg') }}');">
    <div class="footer-content-wrapper container">
        
        <div class="newsletter-premium" data-aos="fade-up" data-aos-duration="1000">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="section-title counter-text-wrap">
                        <h2 class="text-white mb-1">Đăng Ký Bản Tin</h2>
                        <p class="mb-0 text-white">Hơn <span class="count-text plus text-warning fw-bold" data-speed="3000" data-stop="34500">0</span> trải nghiệm du lịch tuyệt vời đang chờ đón bạn!</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form class="newsletter-form d-flex" action="#">
                        <input id="news-email" type="email" placeholder="Nhập địa chỉ Email của bạn..." required class="form-control me-2" style="height: 55px; border-radius: 8px;">
                        <button type="submit" class="theme-btn bgc-secondary style-two" style="height: 55px; border-radius: 8px; min-width: 150px;">
                            <span data-hover="Đăng Ký">Đăng Ký</span>
                            <i class="fal fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="widget-area pt-30 pb-45">
            <div class="row justify-content-between">
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-duration="1000">
                    <div class="footer-widget footer-text">
                        <div class="footer-logo mb-3">
                            <a href="{{ route('home') }}"><img src="{{ asset(get_setting('site_logo', 'clients/assets/images/logos/logo.png')) }}" alt="Logo Go Viet" style="max-height: 60px;"></a>
                        </div>
                        <p class="text-light">Chúng tôi thiết kế những hành trình riêng biệt phù hợp với sở thích của bạn, đảm bảo mỗi chuyến đi đều trọn vẹn và đáng nhớ nhất.</p>
                            <div class="social-style-one mt-4">
                        @if(get_setting('social_facebook'))
                            <a href="{{ get_setting('social_facebook') }}" target="_blank" class="rounded-circle"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if(get_setting('social_youtube'))
                            <a href="{{ get_setting('social_youtube') }}" target="_blank" class="rounded-circle"><i class="fab fa-youtube"></i></a>
                        @endif
                        @if(get_setting('social_zalo'))
                            <a href="https://zalo.me/{{ preg_replace('/[^0-9]/', '', get_setting('social_zalo')) }}" target="_blank" class="rounded-circle"><i class="fas fa-comment-dots"></i></a>
                        @endif

                    </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
                    <div class="footer-widget footer-links">
                        <h5 class="footer-title text-white mb-3">Dịch Vụ</h5>
                        <ul class="list-unstyled">
                            <li><a href="#">Hướng Dẫn Viên</a></li>
                            <li><a href="#">Đặt Tour Du Lịch</a></li>
                            <li><a href="#">Đặt Khách Sạn</a></li>
                            <li><a href="#">Đặt Vé Máy Bay</a></li>
                            <li><a href="#">Dịch Vụ Cho Thuê</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
                    <div class="footer-widget footer-links">
                        <h5 class="footer-title text-white mb-3">Công Ty</h5>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('about') }}">Về Chúng Tôi</a></li>
                            <li><a href="{{ route('blogs') }}">Blog Cộng Đồng</a></li>
                            <li><a href="{{ route('contact') }}">Tuyển Dụng</a></li>
                            <li><a href="{{ route('blogs') }}">Tin Tức</a></li>
                            <li><a href="{{ route('contact') }}">Liên Hệ</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                    <div class="footer-widget footer-contact">
                        <h5 class="footer-title text-white mb-3">Thông Tin Liên Hệ</h5>
                        <ul class="list-unstyled text-light">
                            <li>
                            <i class="fal fa-map-marked-alt text-info mt-1"></i> 
                            <span>{{ get_setting('company_address', '123 Đường Lê Lợi, TP. Đà Nẵng, Việt Nam') }}</span>
                        </li>
<li>
                            <i class="fal fa-envelope text-info mt-1"></i> 
                            <a href="mailto:{{ get_setting('contact_email', 'support@goviet.com') }}" class="text-muted hover-info">{{ get_setting('contact_email', 'support@goviet.com') }}</a>
                        </li>
                        <li>
                            <i class="fal fa-clock text-info mt-1"></i> 
                            <span>Hỗ trợ 24/7. Trừ các ngày Lễ, Tết.</span>
                        </li>
                        <li class="mt-4">
                            <i class="fal fa-phone-volume text-warning fa-2x mt-2"></i> 
                            <div>
                                <span class="d-block mb-1 text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Hotline Đặt Tour</span>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', get_setting('hotline', '+84123456789')) }}" class="fw-bold fs-4 text-warning text-decoration-none">
                                    {{ get_setting('hotline', '+84 (123) 456 789') }}
                                </a>
                            </div>
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom border-top border-secondary pt-3 pb-3" style="position: relative; z-index: 2; background: rgba(0,0,0,0.3);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start mb-2 mb-lg-0">
                    <p class="mb-0 text-white">© 2026 Bản quyền thuộc về <a href="{{ route('home') }}" class="text-warning fw-bold">Go Viet</a>. All rights reserved.</p>
                </div>
                <div class="col-lg-6 text-center text-lg-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="#" class="text-light">Điều khoản</a></li>
                        <li class="list-inline-item ms-3"><a href="#" class="text-light">Chính sách bảo mật</a></li>
                        <li class="list-inline-item ms-3"><a href="#" class="text-light">Hỗ trợ</a></li>
                    </ul>
                </div>
            </div>
           <button id="backToTopBtn" class="bgc-secondary text-white shadow-sm" style="border: none; border-radius: 8px; padding: 12px 25px; left: 50%; transform: translateX(-50%); bottom: 30px; position: fixed; z-index: 9990; display: none; cursor: pointer; transition: 0.3s;">
    <i class="fal fa-angle-double-up" style="font-size: 20px;"></i>
</button>
    </div>
</footer>

{{-- ================= CHATBOT HTML ================= --}}
<div id="chat-bot-btn"><i class="fas fa-comments"></i></div>

<div id="chat-bot-box">
    <div class="chat-header">
        <span><i class="fas fa-robot mr-2"></i> Trợ lý GoViet</span>
        <span class="close-chat" id="close-chat-btn"><i class="fas fa-times"></i></span>
    </div>
    <div class="chat-body" id="chat-body">
        <div class="msg-bubble msg-bot">Xin chào! 👋 Mình là trợ lý ảo của GoViet. Mình có thể giúp gì cho bạn?</div>
    </div>
    <div class="typing-indicator" id="chat-typing">Trợ lý đang xử lý...</div>
    <div class="chat-footer-box">
        <input type="text" id="chat-input" placeholder="Nhập tin nhắn..." autocomplete="off">
        <button id="chat-send-btn"><i class="fas fa-paper-plane"></i></button>
    </div>
</div>
{{-- ================= SCRIPTS HỆ THỐNG ================= --}}
<script src="{{ asset('clients/assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('clients/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('clients/assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('clients/assets/js/appear.min.js') }}"></script>
<script src="{{ asset('clients/assets/js/slick.min.js') }}"></script>
<script src="{{ asset('clients/assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('clients/assets/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('clients/assets/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('clients/assets/js/skill.bars.jquery.min.js') }}"></script>
<script src="{{ asset('clients/assets/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('clients/assets/js/aos.js') }}"></script>
<script src="{{ asset('clients/assets/js/script.js') }}"></script>
<script src="{{ asset('clients/assets/js/custom-js.js') }}"></script>

{{-- Thư viện Pusher & SweetAlert2 --}}
<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.3/dist/echo.iife.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // ===== 0. HỆ THỐNG THÔNG BÁO TOÀN CỤC (SweetAlert2) =====
    // Tự động bắt các session('success') hoặc session('error') từ Laravel
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: "{{ session('success') }}",
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Thông báo',
            text: "{{ session('error') }}",
            confirmButtonColor: '#ff5722'
        });
    @endif

    // ===== 1. Cấu hình chung & CSRF =====
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrfToken } });

    const chatBox = $('#chat-bot-box');
    const chatBody = $('#chat-body');
    const chatInput = $('#chat-input');
    const typingIndicator = $('#chat-typing');
    let isSending = false;
    let isHistoryLoaded = false;

    function scrollToBottom() {
        if(chatBody.length) {
            chatBody[0].scrollTop = chatBody[0].scrollHeight;
        }
    }

    function appendMessage(text, className) {
        if (!text) return;
        let textSafe = $('<div>').text(text).html(); 
        chatBody.append(`
            <div class="msg-bubble ${className}">
                ${textSafe.replace(/\n/g, '<br>')}
            </div>
        `);
        scrollToBottom();
    }

    // ===== 2. Khởi tạo Real-time (Laravel Echo) =====
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '9501c7beb77a1a519ef4',
        cluster: 'ap1',
        forceTLS: true
    });

    // Back to Top Logic
    let backToTopBtn = $('#backToTopBtn');
    $(window).scroll(function() {
        if ($(window).scrollTop() > 300) {
            backToTopBtn.fadeIn(300);
        } else {
            backToTopBtn.fadeOut(300);
        }
    });

    backToTopBtn.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 800);
        return false;
    });

    // Chat Real-time Listener
    let currentUserId = "{{ session('userid') }}";
    if (currentUserId && !window.chatInitialized) {
        window.chatInitialized = true;
        window.Echo.channel('chat-room.' + currentUserId)
        .listen('.new-message', (data) => {
            if (data.senderClass !== 'msg-user') {
                typingIndicator.hide();
                appendMessage(data.message, data.senderClass);
            }
        });
    }

    // ===== 3. Hàm tải lịch sử tin nhắn =====
    function loadChatHistory() {
        if (isHistoryLoaded) return;
        $.get("{{ url('/chat/fetch-messages') }}", function(res) {
            if (res.status === 'success') {
                chatBody.find('.msg-bubble').not('#chat-typing').remove();
                res.messages.forEach(msg => {
                    let className = 'msg-bot';
                    if (msg.adminid == 0) className = 'msg-user';
                    else if (msg.adminid != 999) className = 'msg-admin';
                    appendMessage(msg.message, className);
                });
                isHistoryLoaded = true;
                scrollToBottom();
            }
        });
    }

    // ===== 4. Hàm gửi tin nhắn =====
    function sendMessage() {
        let text = chatInput.val().trim();
        if (text === '' || isSending) return;

        isSending = true;
        chatInput.val('').focus();
        appendMessage(text, 'msg-user');
        typingIndicator.show();
        scrollToBottom();

        $.post("{{ url('/chat/send') }}", { message: text })
            .fail(function() {
                typingIndicator.hide();
                appendMessage('Lỗi kết nối! Vui lòng thử lại.', 'msg-bot text-danger');
            })
            .always(function() {
                isSending = false;
            });
    }

    // ===== 5. Đăng ký sự kiện UI =====
    $('#chat-send-btn').on('click', function(e) {
        e.preventDefault();
        sendMessage();
    });

    $('#chat-input').on('keypress', function(e) {
        if (e.which == 13 && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    $('#chat-bot-btn').on('click', function(e) {
        e.preventDefault();
        chatBox.fadeToggle(300, function() {
            if ($(this).is(':visible')) {
                $(this).css('display', 'flex');
                loadChatHistory();
                scrollToBottom();
            }
        });
    });

    $('#close-chat-btn').on('click', function() {
        chatBox.fadeOut(300);
    });

    
});
</script>