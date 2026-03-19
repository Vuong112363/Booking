<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { color: white; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; }
        /* Đổi màu header theo trạng thái */
        .bg-success { background-color: #28a745; }
        .bg-danger { background-color: #dc3545; }
        
        .content { padding: 20px; }
        .order-info { background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin-top: 20px; border-left: 5px solid #28a745; }
        .cancel-info { background-color: #fff3cd; padding: 15px; border-radius: 5px; margin-top: 20px; border-left: 5px solid #ffc107; }
        .price { color: #e53935; font-weight: bold; font-size: 1.1rem; }
        .footer { text-align: center; margin-top: 20px; font-size: 0.8em; color: #777; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        {{-- HEADER ĐỘNG --}}
        <div class="header {{ $bookingDetail->bookingstatus == 'cancelled' ? 'bg-danger' : 'bg-success' }}">
            <h2>{{ $bookingDetail->bookingstatus == 'cancelled' ? 'THÔNG BÁO HỦY TOUR' : 'XÁC NHẬN ĐẶT TOUR' }}</h2>
        </div>

        <div class="content">
            <p>Chào <strong>{{ $bookingDetail->username }}</strong>,</p>

            @if($bookingDetail->bookingstatus == 'cancelled')
                {{-- GIAO DIỆN KHI HỦY TOUR --}}
                <p>Yêu cầu hủy đơn hàng <strong>#{{ $bookingDetail->bookingid }}</strong> của Quý khách đã được xử lý thành công.</p>
                
                <div class="cancel-info">
                    <h4 style="margin-top:0; color: #856404;">Thông tin hoàn tiền</h4>
                    <p><strong>Số tiền đã cọc:</strong> {{ number_format($bookingDetail->paid_amount, 0, ',', '.') }} VNĐ</p>
                    <p><strong>Số tiền hoàn trả:</strong> <span class="price">{{ number_format($bookingDetail->refund_calculated, 0, ',', '.') }} VNĐ</span></p>
                    @if($bookingDetail->paid_amount > 0)
                        <p><strong>Phương thức nhận:</strong> {{ $bookingDetail->refund_info }}</p>
                        <p style="font-size: 0.9em; color: #666;"><i>* Tiền sẽ được chuyển khoản trong vòng 3-5 ngày làm việc.</i></p>
                    @endif
                </div>
                
                <p style="margin-top: 20px;">Rất tiếc vì Quý khách không thể tham gia chuyến đi lần này. Hy vọng sẽ được phục vụ Quý khách trong những hành trình tiếp theo.</p>

            @else
                {{-- GIAO DIỆN KHI ĐẶT TOUR THÀNH CÔNG --}}
                <p>Cảm ơn Quý khách đã tin tưởng sử dụng dịch vụ GoViet. Dưới đây là thông tin chi tiết cho chuyến đi của bạn:</p>
                
                <div class="order-info">
                    <h3>Chi tiết đơn hàng #{{ $bookingDetail->bookingid }}</h3>
                    <p><strong>Tên Tour:</strong> {{ $bookingDetail->title }}</p>
                    <p><strong>Ngày khởi hành:</strong> {{ date('d/m/Y', strtotime($bookingDetail->startdate)) }}</p>
                    <p><strong>Số lượng:</strong> {{ $bookingDetail->numadults }} NL, {{ $bookingDetail->numchildren }} TE</p>
                    <hr>
                    <p><strong>Tổng giá trị:</strong> {{ number_format($bookingDetail->totalprice, 0, ',', '.') }} VNĐ</p>
                    <p><strong>Đã thanh toán (MoMo):</strong> <span style="color: #28a745; font-weight:bold;">{{ number_format($bookingDetail->paid_amount, 0, ',', '.') }} VNĐ</span></p>
                    <p><strong>Còn lại:</strong> <span class="price">{{ number_format($bookingDetail->totalprice - $bookingDetail->paid_amount, 0, ',', '.') }} VNĐ</span></p>
                </div>

                <p style="margin-top: 20px;">Vui lòng thanh toán số tiền còn lại cho Hướng dẫn viên vào ngày khởi hành. Chúc bạn có một chuyến đi thật tuyệt vời!</p>
            @endif

            <p>Nếu có bất kỳ thắc mắc nào, hãy liên hệ ngay với chúng tôi qua Hotline hoặc Email này.</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} <strong>GoViet Tours</strong>. Mọi quyền được bảo lưu.<br>
            Địa chỉ: [Địa chỉ của bạn] | Website: [Link web]
        </div>
    </div>
</body>
</html>