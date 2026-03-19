<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { background-color: #17a2b8; color: white; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
        .box { background-color: #f8f9fa; padding: 15px; border-left: 4px solid #17a2b8; margin: 20px 0; }
        .footer { text-align: center; margin-top: 20px; font-size: 0.9em; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Chuyến đi của bạn sắp bắt đầu!</h2>
        </div>
        <div class="content">
            <p>Chào <strong>{{ $bookingDetail->username }}</strong>,</p>
            <p>Chỉ còn vài ngày nữa là chuyến đi tuyệt vời của bạn sẽ bắt đầu. Chúng tôi xin gửi email này để nhắc nhở và giúp bạn chuẩn bị tốt nhất cho chuyến đi.</p>
            
            <div class="box">
                <p><strong>Tên Tour:</strong> {{ $bookingDetail->title }}</p>
                <p><strong>Ngày khởi hành:</strong> <span style="color:#d9534f; font-weight:bold; font-size:1.1rem;">{{ date('d/m/Y', strtotime($bookingDetail->startdate)) }}</span></p>
                <p><strong>Mã vé (Booking ID):</strong> #{{ $bookingDetail->bookingid }}</p>
                <p><strong>Trạng thái thanh toán:</strong> 
                    @if($bookingDetail->paymentstatus == 'paid')
                        Đã thanh toán 100%
                    @else
                        Đã đặt cọc (Vui lòng thanh toán phần còn lại cho HDV)
                    @endif
                </p>
            </div>

            <h3>🎒 Một số lưu ý quan trọng:</h3>
            <ul>
                <li>Vui lòng mang theo Giấy tờ tùy thân (CMND/CCCD/Hộ chiếu) bản gốc.</li>
                <li>Có mặt tại điểm đón trước ít nhất 15-30 phút so với giờ hẹn.</li>
                <li>Chuẩn bị trang phục phù hợp với thời tiết tại điểm đến.</li>
            </ul>

            <p>Chúc bạn có một chuyến đi vui vẻ và tràn đầy kỷ niệm đáng nhớ!</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Hệ thống đặt Tour du lịch. Trân trọng.
        </div>
    </div>
</body>
</html>