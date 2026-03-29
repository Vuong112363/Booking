@include('clients.blocks.header')

<section class="page-banner-two rel z-1">
    <div class="container-fluid">
        <hr class="mt-0">
        <div class="container">
            <div class="banner-inner pt-15 pb-25">
                <h2 class="page-title mb-10" data-aos="fade-left" data-aos-duration="1500">Điều Khoản & Chính Sách</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-20" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1500">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Chính sách</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="terms-policy-area pt-50 pb-100">
    {{-- Mẹo: Đổi 'container' thành 'container-fluid' ở dòng dưới nếu bạn muốn nó tràn sát rạt ra mép màn hình máy tính --}}
    <div class="container"> 
        <div class="row">
            {{-- Cho nội dung chiếm trọn 12 cột --}}
            <div class="col-12">
                <div class="policy-content bg-white p-4 p-md-5 shadow-sm rounded border">
                    
                    {{-- MENU ĐIỀU HƯỚNG NHANH NẰM NGANG Ở TRÊN CÙNG --}}
                    <div class="toc mb-5 p-4 bg-light rounded border-start border-4 border-primary">
                        <h5 class="mb-3 text-primary"><i class="fas fa-list-ul me-2"></i> Danh mục điều khoản</h5>
                        <div class="d-flex flex-wrap gap-3 policy-nav">
                            <a class="nav-link text-dark fw-bold border rounded px-3 py-2 bg-white" href="#dieu-khoan-chung">1. Điều khoản chung</a>
                            <a class="nav-link text-dark fw-bold border rounded px-3 py-2 bg-white" href="#tai-khoan">2. Tài khoản & Bảo mật</a>
                            <a class="nav-link text-dark fw-bold border rounded px-3 py-2 bg-white" href="#trach-nhiem">3. Trách nhiệm các bên</a>
                            <a class="nav-link text-dark fw-bold border rounded px-3 py-2 bg-white" href="#giay-to-suc-khoe">4. Giấy tờ & Sức khỏe</a>
                            <a class="nav-link text-dark fw-bold border rounded px-3 py-2 bg-white" href="#chinh-sach-thanh-toan">5. Chính sách thanh toán</a>
                            <a class="nav-link text-dark fw-bold border rounded px-3 py-2 bg-white" href="#quy-dinh-huy-tour">6. Hoàn/hủy tour</a>
                            <a class="nav-link text-dark fw-bold border rounded px-3 py-2 bg-white" href="#so-huu-tri-tue">7. Quyền sở hữu trí tuệ</a>
                            <a class="nav-link text-dark fw-bold border rounded px-3 py-2 bg-white" href="#giai-quyet-tranh-chap">8. Giải quyết tranh chấp</a>
                            <a class="nav-link text-dark fw-bold border rounded px-3 py-2 bg-white" href="#ho-tro">9. Hỗ trợ khách hàng</a>
                        </div>
                    </div>

                    {{-- Mục 1 --}}
                    <div id="dieu-khoan-chung" class="mb-5">
                        <h4 class="text-secondary mb-3">1. Điều khoản chung</h4>
                        <p class="text-justify">Chào mừng Quý khách đến với hệ thống đặt tour trực tuyến <strong>GoViet</strong>. Bằng việc truy cập, đăng ký tài khoản và thực hiện đặt tour trên website, Quý khách được xem là đã đọc, hiểu và đồng ý ràng buộc bởi các Điều khoản dịch vụ và Chính sách thanh toán dưới đây.</p>
                        <p class="text-justify">GoViet bảo lưu quyền thay đổi, chỉnh sửa, thêm hoặc lược bỏ bất kỳ phần nào trong Điều khoản này vào bất kỳ lúc nào. Các thay đổi sẽ có hiệu lực ngay khi được đăng tải trên website mà không cần thông báo trước. Việc Quý khách tiếp tục sử dụng trang web sau khi các thay đổi được đăng tải đồng nghĩa với việc Quý khách chấp nhận những thay đổi đó.</p>
                    </div>

                    {{-- Mục 2 --}}
                    <div id="tai-khoan" class="mb-5">
                        <h4 class="text-secondary mb-3">2. Tài khoản và Bảo mật</h4>
                        <ul class="list-style-three mb-3">
                            <li><strong>Đăng ký tài khoản:</strong> Quý khách cần cung cấp thông tin chính xác, cập nhật và đầy đủ khi đăng ký tài khoản trên GoViet. Quý khách hoàn toàn chịu trách nhiệm về tính xác thực của thông tin này.</li>
                            <li><strong>Bảo mật thông tin:</strong> Quý khách có trách nhiệm tự bảo mật mật khẩu và tài khoản của mình. Mọi giao dịch phát sinh từ tài khoản của Quý khách sẽ được xem là do chính Quý khách thực hiện.</li>
                            <li><strong>Khóa tài khoản:</strong> GoViet có quyền từ chối cung cấp dịch vụ, đóng tài khoản, hoặc hủy đơn hàng nếu phát hiện Quý khách cung cấp thông tin giả mạo, vi phạm pháp luật hoặc có dấu hiệu gian lận thanh toán.</li>
                        </ul>
                    </div>

                    {{-- Mục 3 --}}
                    <div id="trach-nhiem" class="mb-5">
                        <h4 class="text-secondary mb-3">3. Trách nhiệm của các bên</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mt-3 text-dark">Đối với khách hàng:</h6>
                                <ul class="list-style-three mb-3">
                                    <li>Cung cấp thông tin cá nhân chính xác khi đặt tour.</li>
                                    <li>Tuân thủ thời gian tập trung, lịch trình và các quy định an toàn.</li>
                                    <li>Tôn trọng văn hóa địa phương, không mang theo các vật dụng cấm.</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mt-3 text-dark">Đối với GoViet:</h6>
                                <ul class="list-style-three">
                                    <li>Cung cấp đúng và đủ các dịch vụ đã cam kết trong chương trình tour.</li>
                                    <li>Bảo mật tuyệt đối thông tin cá nhân và thanh toán của khách hàng.</li>
                                    <li>Hỗ trợ khách hàng tối đa trong các trường hợp phát sinh sự cố ngoài ý muốn.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Mục 4 --}}
                    <div id="giay-to-suc-khoe" class="mb-5">
                        <h4 class="text-secondary mb-3">4. Quy định về Giấy tờ tùy thân & Sức khỏe</h4>
                        <div class="alert alert-info bg-light border-info">
                            <ul class="mb-0 ps-3">
                                <li class="mb-2"><strong>Giấy tờ tùy thân:</strong> Quý khách phải mang theo CMND/CCCD/Hộ chiếu bản gốc (còn hạn tối thiểu 6 tháng). Đối với trẻ em chưa có CMND, bắt buộc mang theo Giấy khai sinh bản sao có mộc đỏ hoặc bản chính.</li>
                                <li class="mb-2"><strong>Hành khách cao tuổi & Phụ nữ có thai:</strong> Hành khách từ 70 tuổi trở lên hoặc phụ nữ mang thai cần ký giấy cam kết sức khỏe trước khi đi tour. Không nhận hành khách mang thai từ tháng thứ 7 trở lên.</li>
                                <li><strong>Bệnh lý nền:</strong> Quý khách có tiền sử bệnh tim mạch, huyết áp hoặc các bệnh lý nghiêm trọng cần thông báo trước cho GoViet và tự chuẩn bị thuốc đặc trị mang theo.</li>
                            </ul>
                        </div>
                    </div>

                    {{-- Mục 5 --}}
                    <div id="chinh-sach-thanh-toan" class="mb-5">
                        <h4 class="text-secondary mb-3">5. Chính sách thanh toán</h4>
                        <p>Để đảm bảo giữ chỗ và dịch vụ được chuẩn bị chu đáo nhất, Quý khách vui lòng thực hiện thanh toán theo quy định sau:</p>
                        
                        <div class="alert alert-warning bg-light border-warning mt-3">
                            <h6 class="mb-2"><i class="fas fa-wallet text-warning me-2"></i> Phương thức thanh toán chấp nhận:</h6>
                            <ul class="mb-0 ps-3">
                                <li><strong>Thanh toán trực tuyến an toàn:</strong> Qua Cổng thanh toán Ví điện tử MoMo (Quét mã QR, Thẻ ATM nội địa, Thẻ Visa/Mastercard). Giao dịch được mã hóa chuẩn quốc tế.</li>
                                <li><strong>Chuyển khoản ngân hàng:</strong> Trực tiếp vào tài khoản công ty (thông tin tài khoản sẽ được hiển thị khi chốt đơn).</li>
                                <li><strong>Thanh toán tiền mặt:</strong> Tại văn phòng đại diện của GoViet.</li>
                            </ul>
                        </div>

                        <h6 class="mt-4 text-dark">Quy định đặt cọc:</h6>
                        <ul class="list-style-three">
                            <li><strong>Giữ chỗ:</strong> Thanh toán trước tối thiểu <strong>30%</strong> tổng giá trị tour ngay khi đặt.</li>
                            <li><strong>Thanh toán phần còn lại:</strong> Hoàn tất 100% chi phí trước ngày khởi hành tối thiểu <strong>15 ngày</strong>.</li>
                        </ul>
                    </div>

                    {{-- Mục 6 --}}
                    <div id="quy-dinh-huy-tour" class="mb-5">
                        <h4 class="text-secondary mb-3">6. Quy định hoàn / Hủy tour</h4>
                        <p>Trong trường hợp Quý khách có nhu cầu hủy hoặc chuyển đổi tour, phí phạt sẽ được áp dụng dựa trên thời điểm thông báo hủy tính từ ngày khởi hành (không tính Thứ 7, Chủ Nhật và Lễ Tết):</p>
                        
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-striped text-center">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Thời điểm báo hủy</th>
                                        <th>Phí phạt (% Tổng giá tour)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-start ps-3">Ngay sau khi đặt cọc / Trước 15 ngày</td>
                                        <td class="text-danger fw-bold">0%</td>
                                    </tr>

                                    <tr>
                                        <td class="text-start ps-3">Từ 03 - 05 ngày trước khởi hành</td>
                                        <td class="text-danger fw-bold">50%</td>
                                    </tr>
                                    <tr>
                                        <td class="text-start ps-3">Trong vòng 02 ngày trước khởi hành</td>
                                        <td class="text-danger fw-bold">100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Mục 7 & 8 --}}
                    <div class="row mb-5">
                        <div class="col-md-6" id="so-huu-tri-tue">
                            <h4 class="text-secondary mb-3">7. Quyền sở hữu trí tuệ</h4>
                            <p class="text-justify">Mọi nội dung trên website GoViet bao gồm nhưng không giới hạn ở: văn bản, thiết kế, đồ họa, logo, hình ảnh, mã nguồn đều thuộc quyền sở hữu độc quyền của GoViet và được bảo hộ bởi Luật Sở hữu trí tuệ Việt Nam.</p>
                        </div>
                        <div class="col-md-6" id="giai-quyet-tranh-chap">
                            <h4 class="text-secondary mb-3">8. Giải quyết tranh chấp</h4>
                            <p class="text-justify">Trong trường hợp không thể giải quyết thông qua thương lượng trong vòng ba mươi (30) ngày, tranh chấp sẽ được đưa ra giải quyết tại Tòa án có thẩm quyền tại nơi GoViet đặt trụ sở chính (TP. Đà Nẵng, Việt Nam).</p>
                        </div>
                    </div>

                    {{-- Mục 9 --}}
                    <div id="ho-tro" class="mb-0 bg-light p-4 rounded border-start border-4 border-success">
                        <h5 class="text-dark mb-2"><i class="fas fa-headset text-success me-2"></i> 9. Hỗ trợ khách hàng</h5>
                        <p class="mb-1">Nếu có bất kỳ thắc mắc nào về dịch vụ hoặc gặp khó khăn trong quá trình thanh toán, xin vui lòng liên hệ:</p>
                        <ul class="list-unstyled mt-3 mb-0">
                            <li class="mb-2"><i class="fas fa-envelope text-primary me-2"></i> <strong>Email:</strong> support@goviet.vn</li>
                            <li class="mb-2"><i class="fas fa-phone-alt text-primary me-2"></i> <strong>Hotline:</strong> 1900 xxxx (24/7)</li>
                            <li><i class="fas fa-map-marker-alt text-primary me-2"></i> <strong>Văn phòng:</strong> Trung tâm TP. Đà Nẵng, Việt Nam.</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<style>
    html { scroll-behavior: smooth; }
    .policy-nav .nav-link {
        transition: all 0.3s ease;
        font-size: 14px;
    }
    .policy-nav .nav-link:hover {
        background-color: #ff6a00 !important;
        color: white !important;
        border-color: #ff6a00 !important;
    }
    .list-style-three { list-style: none; padding-left: 0; }
    .list-style-three li { position: relative; padding-left: 25px; margin-bottom: 10px; text-align: justify; }
    .list-style-three li::before {
        content: "\f0a1";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        color: #ff6a00;
        position: absolute;
        left: 0;
        top: 2px;
    }
</style>

@include('clients.blocks.footer')