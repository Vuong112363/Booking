<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; line-height: 1.6; color: #444; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #17a2b8, #117a8b); color: white; padding: 30px 20px; text-align: center; }
        .content { padding: 30px; }
        .box { background-color: #f0f9fa; padding: 20px; border-radius: 8px; border-left: 5px solid #17a2b8; margin: 20px 0; }
        .pickup-box { background-color: #fff3cd; padding: 15px; border-radius: 8px; border: 1px solid #ffeeba; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; font-size: 0.85em; color: #777; background: #f9f9f9; border-top: 1px solid #eee; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #17a2b8; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 10px; }
        .label { font-weight: bold; color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0; font-size: 22px;">Sẵn sàng cho hành trình của bạn!</h1>
            <p style="margin:5px 0 0 0; opacity: 0.9;">GoViet Travel cùng bạn khám phá</p>
        </div>

        <div class="content">
            <p>Chào <strong>{{ $bookingDetail->username }}</strong>,</p>
            <p>Chỉ còn <strong>2 ngày nữa</strong> là chuyến đi của bạn sẽ bắt đầu. GoViet Travel xin nhắc lại một số thông tin quan trọng để bạn có sự chuẩn bị chu đáo nhất:</p>
            
            <div class="box">
                <p><span class="label">Tour:</span> {{ $bookingDetail->title }}</p>
                <p><span class="label">Khởi hành:</span> <span style="color:#d9534f; font-weight:bold;">{{ date('d/m/Y', strtotime($bookingDetail->startdate)) }}</span></p>
                <p><span class="label">Mã đặt chỗ:</span> #{{ $bookingDetail->bookingid }}</p>
            </div>

            {{-- PHẦN QUAN TRỌNG NHẤT: ĐIỂM ĐÓN --}}
            <div class="pickup-box">
                <h4 style="margin:0 0 10px 0; color: #856404;">📍 Thông tin đón khách</h4>
                <p style="margin:0;">Điểm đón: <strong>{{ $bookingDetail->pickup_name ?? 'Tại điểm hẹn' }}</strong></p>
                <p style="margin:0;">Thời gian: <strong style="font-size: 1.1rem; color: #d9534f;">{{ $bookingDetail->pickup_time ? date('H:i', strtotime($bookingDetail->pickup_time)) : 'Theo lịch trình' }}</strong></p>
                <small><i>* Quý khách vui lòng có mặt trước 15-20 phút để ổn định chỗ ngồi.</i></small>
            </div>

            <h3>📝 Lưu ý chuẩn bị:</h3>
            <ul style="padding-left: 20px;">
                <li>Mang theo <strong>CCCD/Hộ chiếu</strong> bản gốc (bắt buộc).</li>
                <li>Kiểm tra lại trạng thái thanh toán (Hiện tại: <strong>{{ $bookingDetail->paymentstatus == 'paid' ? 'Đã hoàn tất' : 'Chờ thanh toán phần còn lại' }}</strong>).</li>
                <li>Trang phục phù hợp và các vật dụng cá nhân cần thiết.</li>
            </ul>

            <p style="text-align: center;">
                <a href="{{ url('/') }}" class="btn">Xem chi tiết hành trình</a>
            </p>
        </div>

        <div class="footer">
            <p style="font-weight: bold; margin-bottom: 5px;">GoViet Travel</p>
            <p>Hotline: {{ $settings['hotline'] ?? '039.884.6587' }} | Email: {{ $settings['contact_email'] ?? 'contact@goviet.vn' }}</p>
            <p>&copy; {{ date('Y') }} GoViet Travel. Chúc bạn một chuyến đi tuyệt vời!</p>
        </div>
    </div>
</body>
</html>