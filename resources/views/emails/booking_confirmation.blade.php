<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; line-height: 1.6; color: #444; background-color: #f8f9fa; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1); border: 1px solid #eee; }
        .header { padding: 25px; text-align: center; color: white; }
        .bg-success { background: linear-gradient(135deg, #28a745, #1e7e34); }
        .bg-danger { background: linear-gradient(135deg, #dc3545, #bd2130); }
        .bg-info { background: linear-gradient(135deg, #17a2b8, #117a8b); }
        .content { padding: 30px; }
        .badge { display: inline-block; padding: 5px 12px; border-radius: 50px; font-size: 12px; font-weight: bold; text-transform: uppercase; margin-bottom: 15px; }
        .badge-paid { background: #d4edda; color: #155724; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .info-card { background: #fdfdfd; border: 1px solid #eee; border-radius: 10px; padding: 20px; margin-bottom: 20px; }
        .info-title { font-size: 14px; font-weight: bold; color: #888; text-transform: uppercase; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; }
        .label { color: #777; font-size: 14px; padding: 5px 0; }
        .value { color: #333; font-weight: bold; text-align: right; font-size: 14px; }
        .total-row { border-top: 2px dashed #eee; padding-top: 10px; margin-top: 10px; }
        .price-big { color: #d32f2f; font-size: 20px; font-weight: bold; }
        .pickup-box { background: #e7f3ff; border-left: 5px solid #007bff; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .footer { background: #2c3e50; color: #bdc3c7; text-align: center; padding: 25px; font-size: 12px; }
        .btn { display: inline-block; padding: 12px 25px; background: #007bff; color: white !important; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        @php
            $isCancelled = $bookingDetail->bookingstatus == 'cancelled';
            $isPaid = $bookingDetail->paymentstatus == 'paid';
            $isDeposit = $bookingDetail->paymentstatus == 'deposit_paid';
            $headerClass = $isCancelled ? 'bg-danger' : (($isPaid || $isDeposit) ? 'bg-success' : 'bg-info');
        @endphp

        {{-- 1. HEADER --}}
        <div class="header {{ $headerClass }}">
            <h1 style="margin:0; font-size: 24px;">
                @if($isCancelled) 🔔 THÔNG BÁO HỦY TOUR @elseif($isPaid) ✅ VÉ ĐIỆN TỬ XÁC NHẬN @elseif($isDeposit) 💳 XÁC NHẬN TIỀN CỌC @else 📨 XÁC NHẬN ĐƠN ĐẶT @endif
            </h1>
            <p style="margin:5px 0 0 0; opacity:0.8;">Mã đơn hàng: #{{ $bookingDetail->bookingid }}</p>
        </div>

<div class="content">
    <p>Xin chào <strong>{{ $bookingDetail->username }}</strong>,</p>

    {{-- 1. TRƯỜNG HỢP HỦY TOUR --}}
    @if($isCancelled)
        <p>Yêu cầu hủy dịch vụ của bạn đã được hệ thống ghi nhận thành công. Dưới đây là chi tiết biên nhận hoàn tiền:</p>
        <div class="info-card">
            <div class="info-title">💰 Thông tin hoàn trả</div>
            <table>
                <tr>
                    <td class="label">Tổng số tiền đã đóng:</td>
                    <td class="value">{{ number_format($bookingDetail->paid_amount, 0, ',', '.') }} VNĐ</td>
                </tr>
                
                {{-- Hiển thị phụ phí khấu trừ nếu có --}}
                @if(($bookingDetail->pickup_fee_total ?? 0) > 0)
                <tr>
                    <td class="label">Phụ phí đón (Không hoàn lại):</td>
                    <td class="value" style="color: #dc3545;">- {{ number_format($bookingDetail->pickup_fee_total, 0, ',', '.') }} VNĐ</td>
                </tr>
                @endif

                <tr>
                    <td class="label">Lý do hủy:</td>
                    <td class="value">{{ $bookingDetail->cancel_reason ?? 'Theo yêu cầu khách hàng' }}</td>
                </tr>
                
                <tr class="total-row">
                    <td class="label" style="font-size: 16px; font-weight: bold;">Số tiền hoàn thực tế:</td>
                    <td class="value price-big">
                        {{-- Ưu tiên lấy refund_amount đã chốt trong DB --}}
                        {{ number_format($bookingDetail->refund_amount ?? ($bookingDetail->refund_calculated ?? 0), 0, ',', '.') }} VNĐ
                    </td>
                </tr>
            </table>
        </div>
        <p style="font-size: 13px; color: #666; font-style: italic; background: #fff4f4; padding: 10px; border-radius: 5px;">
            * <strong>Lưu ý:</strong> Theo quy định, phụ phí đón khách là chi phí dịch vụ cố định không được hoàn trả. Tiền hoàn trả sẽ được chuyển vào tài khoản của quý khách từ 3-5 ngày làm việc.
        </p>

    {{-- 2. TRƯỜNG HỢP ĐẶT TOUR / THANH TOÁN THÀNH CÔNG --}}
    @else
        <div class="badge {{ $isPaid ? 'badge-paid' : 'badge-pending' }}">
            {{ $isPaid ? 'Đã hoàn tất thanh toán 100%' : ($isDeposit ? 'Đã thanh toán tiền cọc' : 'Chờ xác nhận thanh toán') }}
        </div>

        {{-- THÔNG TIN TOUR --}}
        <div class="info-card">
            <div class="info-title">📍 Chi tiết hành trình</div>
            <table>
                <tr><td class="label">Tên Tour:</td><td class="value">{{ $bookingDetail->title }}</td></tr>
                <tr><td class="label">Khởi hành:</td><td class="value">{{ date('d/m/Y', strtotime($bookingDetail->startdate)) }}</td></tr>
                <tr><td class="label">Ngày về (Dự kiến):</td><td class="value">{{ isset($bookingDetail->enddate) ? date('d/m/Y', strtotime($bookingDetail->enddate)) : 'Theo lịch trình' }}</td></tr>
                <tr><td class="label">Hành khách:</td><td class="value">{{ $bookingDetail->numadults }} Người lớn {{ $bookingDetail->numchildren > 0 ? ', '.$bookingDetail->numchildren.' Trẻ em' : '' }}</td></tr>
            </table>
        </div>

        {{-- THÔNG TIN ĐIỂM ĐÓN --}}
        @if(!empty($bookingDetail->pickup_name))
        <div class="pickup-box">
            <h4 style="margin:0 0 5px 0; color: #0056b3;"><i class="fas fa-map-marker-alt"></i> Thông tin điểm đón khách:</h4>
            <p style="margin:0; font-size: 14px;">Địa điểm: <strong>{{ $bookingDetail->pickup_name }}</strong></p>
            <p style="margin:0; font-size: 14px;">Giờ đón: <strong style="color: #d32f2f;">{{ date('H:i', strtotime($bookingDetail->pickup_time)) }}</strong></p>
            <small style="color: #666;">* Quý khách vui lòng có mặt tại điểm đón trước 15-20 phút.</small>
        </div>
        @endif

        {{-- CHI TIẾT TÀI CHÍNH --}}
        <div class="info-card">
            <div class="info-title">💳 Chi tiết thanh toán</div>
            <table>
                <tr>
                    <td class="label">Giá gốc Tour:</td>
                    <td class="value">{{ number_format($bookingDetail->totalprice, 0, ',', '.') }} VNĐ</td>
                </tr>
                @if(($bookingDetail->pickup_fee_total ?? 0) > 0)
                <tr>
                    <td class="label">Phụ phí đón khách:</td>
                    <td class="value">+ {{ number_format($bookingDetail->pickup_fee_total, 0, ',', '.') }} VNĐ</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td class="label" style="font-weight: bold;">Tổng giá trị đơn hàng:</td>
                    <td class="value" style="font-weight: bold;">{{ number_format($bookingDetail->totalprice + ($bookingDetail->pickup_fee_total ?? 0), 0, ',', '.') }} VNĐ</td>
                </tr>
                <tr>
                    <td class="label" style="color: #28a745;">Đã thanh toán ({{ strtoupper($bookingDetail->paymentmethod ?? 'Tiền mặt') }}):</td>
                    <td class="value" style="color: #28a745; font-weight: bold;">- {{ number_format($bookingDetail->paid_amount, 0, ',', '.') }} VNĐ</td>
                </tr>
                <tr style="background: #fff8e1;">
                    <td class="label" style="font-size: 16px; font-weight: bold; color: #333; padding: 10px 5px;">Số tiền còn lại:</td>
                    <td class="value price-big" style="padding: 10px 5px;">
                        {{ number_format(($bookingDetail->totalprice + ($bookingDetail->pickup_fee_total ?? 0)) - $bookingDetail->paid_amount, 0, ',', '.') }} VNĐ
                    </td>
                </tr>
            </table>
        </div>

        @if(!$isPaid)
        <div style="text-align: center; margin: 25px 0;">
            <p style="font-size: 13px; color:#666; margin-bottom: 15px;">Quý khách vui lòng hoàn tất số dư còn lại bằng MoMo hoặc thanh toán tiền mặt cho Hướng dẫn viên vào ngày khởi hành.</p>
            <a href="{{ url('/booking-history') }}" class="btn">QUẢN LÝ ĐƠN HÀNG</a>
        </div>
        @endif
    @endif

    {{-- YÊU CẦU ĐẶC BIỆT --}}
    @if(!empty($bookingDetail->specialrequest))
    <div style="margin-top: 25px; padding: 15px; border-top: 1px solid #eee; background-color: #fafafa; border-radius: 8px;">
        <strong style="color: #555; font-size: 14px; display: block; margin-bottom: 5px;">📝 Ghi chú từ khách hàng:</strong>
        <i style="color: #777; font-size: 13px;">"{{ $bookingDetail->specialrequest }}"</i>
    </div>
    @endif
</div>

        {{-- FOOTER ĐỘNG LẤY TỪ SETTINGS --}}
        <div class="footer">
            <p style="font-weight: bold; font-size: 16px; margin-bottom: 10px; color: #fff;">{{ $settings['site_name'] ?? 'GoViet Travel' }}</p>
            <p>📞 Hotline: {{ $settings['hotline'] ?? '039.884.6587' }} | 📧 Email: {{ $settings['contact_email'] ?? 'vuongvanbui20@gmail.com' }}</p>
            <p>🏠 Địa chỉ: {{ $settings['company_address'] ?? 'Đà Nẵng, Việt Nam' }}</p>
            <div style="margin-top: 15px; border-top: 1px solid #444; padding-top: 15px; opacity: 0.6;">
                &copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'GoViet Travel' }}. Chân thành cảm ơn quý khách đã tin tưởng!
            </div>
        </div>

    </div>
</body>
</html>