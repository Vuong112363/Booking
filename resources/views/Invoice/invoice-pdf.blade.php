<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <style>
        /* Tối ưu Font tiếng Việt cho hệ thống DomPDF */
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; line-height: 1.5; margin: 0; padding: 0; }
        .invoice-box { padding: 30px 40px; }
        
        /* Header: Logo & Công ty */
        .header-table { width: 100%; border-bottom: 2px solid #032a63; padding-bottom: 15px; margin-bottom: 25px; }
        .logo-text { font-size: 24px; font-weight: bold; color: #032a63; text-transform: uppercase; margin: 0; letter-spacing: 1px; }
        .company-info { font-size: 10px; color: #555; line-height: 1.4; margin-top: 5px; }
        .invoice-label { text-align: right; vertical-align: bottom; }
        .invoice-label h1 { color: #ff5722; font-size: 26px; margin: 0 0 5px 0; text-transform: uppercase; letter-spacing: 2px; }
        
        /* Thông tin Khách hàng & Tour (Dùng bảng để DOMPDF không vỡ layout) */
        .info-section { width: 100%; margin-bottom: 30px; border-collapse: collapse; }
        .info-column { width: 48%; vertical-align: top; background-color: #f8f9fc; padding: 15px; border: 1px solid #eef0f5; border-radius: 8px; }
        .spacer-column { width: 4%; }
        .section-title { font-size: 11px; font-weight: bold; color: #032a63; text-transform: uppercase; border-bottom: 1px solid #dce1eb; padding-bottom: 5px; margin-bottom: 10px; display: block; }
        .info-text { font-size: 11px; line-height: 1.6; }

        /* Bảng kê dịch vụ chi tiết */
        .item-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .item-table th { background-color: #032a63; color: #ffffff; padding: 10px; font-size: 11px; text-transform: uppercase; border: 1px solid #032a63; }
        .item-table td { padding: 10px; border: 1px solid #e0e0e0; vertical-align: top; font-size: 12px; }
        .item-table .qty-col { text-align: center; width: 15%; }
        .item-table .price-col { text-align: right; width: 20%; }

        /* Tổng kết tài chính (Dùng Table thay vì Float để tránh lỗi DOMPDF) */
        .summary-wrapper { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .summary-spacer { width: 50%; }
        .summary-table { width: 50%; border-collapse: collapse; }
        .summary-table td { padding: 8px 10px; font-size: 12px; border-bottom: 1px solid #f0f0f0; }
        .summary-table .label-col { text-align: left; color: #555; }
        .summary-table .value-col { text-align: right; font-weight: bold; }
        .total-row { background-color: #fff5f2; }
        .total-row td { color: #dc3545; font-size: 14px; border-top: 2px solid #dc3545; border-bottom: 2px solid #dc3545; font-weight: bold; }
        
        /* Con dấu trạng thái */
        .status-stamp {
            position: absolute; top: 130px; left: 40%;
            border: 3px solid #28a745; color: #28a745;
            font-size: 22px; font-weight: bold; padding: 5px 20px;
            transform: rotate(-15deg); opacity: 0.4; border-radius: 8px;
            text-transform: uppercase; letter-spacing: 2px;
        }

        /* Footer & Signatures */
        .signature-table { width: 100%; margin-top: 50px; text-align: center; }
        .signature-table td { width: 50%; vertical-align: top; }
        .footer { margin-top: 50px; text-align: center; border-top: 1px dashed #ccc; padding-top: 15px; font-size: 10px; color: #777; line-height: 1.5; }
    </style>
</head>
<body>
    <div class="invoice-box">
        
        <table class="header-table">
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <div class="logo-text">GoViet Travel</div>
                    <div class="company-info">
                        <strong>Công ty TNHH Du Lịch & Lữ Hành GoViet</strong><br>
                        Địa chỉ: Tầng 5, Tòa nhà Travel City, Đà Nẵng, Việt Nam<br>
                        Điện thoại: 1900 1234 | MST: 0123456789<br>
                        Website: www.goviet-tours.vn
                    </div>
                </td>
                <td class="invoice-label" style="width: 40%;">
                    <h1>HÓA ĐƠN</h1>
                    <div style="font-weight: bold; font-size: 14px; color: #333;">Số: #INV-{{ str_pad($invoice->invoiceid, 6, '0', STR_PAD_LEFT) }}</div>
                    <div style="font-size: 11px; color: #666; margin-top: 3px;">Ngày lập: {{ date('d/m/Y', strtotime($invoice->detelssued)) }}</div>
                </td>
            </tr>
        </table>

        @if($booking->paymentstatus == 'paid')
            <div class="status-stamp">ĐÃ THANH TOÁN</div>
        @endif

        <table class="info-section">
            <tr>
                <td class="info-column">
                    <span class="section-title">Thông tin khách hàng</span>
                    <div class="info-text">
                        <strong>Khách hàng:</strong> {{ $booking->username ?? 'Khách lẻ' }}<br>
                        <strong>Email:</strong> {{ $invoice->email }}<br>
                        <strong>Mã đặt chỗ:</strong> #{{ $booking->bookingid }}<br>
                        <strong>Ngày đặt:</strong> {{ date('d/m/Y H:i', strtotime($booking->bookingdate)) }}<br>
                        <strong>Ghi chú:</strong> {{ $booking->specialrequest ?? 'Không có' }}
                    </div>
                </td>
                <td class="spacer-column"></td>
                <td class="info-column">
                    <span class="section-title">Chi tiết chuyến đi</span>
                    <div class="info-text">
                        <strong>Tour:</strong> {{ $booking->title }}<br>
                        <strong>Khởi hành:</strong> {{ date('d/m/Y', strtotime($booking->startdate)) }}<br>
                        <strong>Điểm đón:</strong> {{ $booking->pickup_name ?? 'Tại văn phòng GoViet' }}<br>
                        <strong>Giờ đón:</strong> {{ isset($booking->pickup_time) ? date('H:i', strtotime($booking->pickup_time)) : 'Theo sự sắp xếp của HDV' }}
                    </div>
                </td>
            </tr>
        </table>

        <table class="item-table">
            <thead>
                <tr>
                    <th style="text-align: left;">Hạng mục dịch vụ</th>
                    <th class="qty-col">Số lượng</th>
                    <th class="price-col">Đơn giá</th>
                    <th class="price-col">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $pickupFee = $booking->pickup_fee_total ?? 0;
                    $tourTotal = $booking->totalprice - $pickupFee;
                    $totalPeople = $booking->numadults + $booking->numchildren;
                    $avgPrice = $totalPeople > 0 ? ($tourTotal / $totalPeople) : 0;
                @endphp
                
                <tr>
                    <td>
                        <strong style="color: #032a63;">Gói Tour Du Lịch Trọn Gói</strong><br>
                        <span style="font-size: 10px; color: #666;">Bao gồm phương tiện di chuyển, HDV và vé tham quan.</span><br>
                        <span style="font-size: 10px; color: #ff5722;">(Chi tiết: {{ $booking->numadults }} Người lớn, {{ $booking->numchildren }} Trẻ em)</span>
                    </td>
                    <td class="qty-col">{{ $totalPeople }} khách</td>
                    <td class="price-col">{{ number_format($avgPrice) }} đ</td>
                    <td class="price-col"><strong>{{ number_format($tourTotal) }} đ</strong></td>
                </tr>

                @if($pickupFee > 0)
                <tr>
                    <td>
                        <strong style="color: #032a63;">Phụ phí đưa đón tận nơi</strong><br>
                        <span style="font-size: 10px; color: #666;">Đón tại: {{ $booking->pickup_name }}</span>
                    </td>
                    <td class="qty-col">1 chuyến</td>
                    <td class="price-col">{{ number_format($pickupFee) }} đ</td>
                    <td class="price-col"><strong>{{ number_format($pickupFee) }} đ</strong></td>
                </tr>
                @endif
            </tbody>
        </table>

        <table class="summary-wrapper">
            <tr>
                <td class="summary-spacer"></td>
                <td style="padding: 0;">
                    <table class="summary-table" style="width: 100%;">
                        <tr>
                            <td class="label-col">Cộng tiền hàng (Trị giá trước thuế):</td>
                            <td class="value-col">{{ number_format($invoice->totalamount / 1.08) }} đ</td>
                        </tr>
                        <tr>
                            <td class="label-col">Thuế GTGT (VAT 8%):</td>
                            <td class="value-col">{{ number_format($invoice->totalamount - ($invoice->totalamount / 1.08)) }} đ</td>
                        </tr>
                        <tr class="total-row">
                            <td class="label-col" style="color: #dc3545; text-transform: uppercase;">Tổng cộng thanh toán:</td>
                            <td class="value-col">{{ number_format($invoice->totalamount) }} đ</td>
                        </tr>
                        <tr>
                            <td class="label-col" style="color: #28a745;">Đã thanh toán ({{ strtoupper($booking->paymentmethod) }}):</td>
                            <td class="value-col" style="color: #28a745;">- {{ number_format($booking->paid_amount) }} đ</td>
                        </tr>
                        <tr>
                            <td class="label-col" style="font-weight: bold; color: #000;">SỐ TIỀN CÒN LẠI:</td>
                            <td class="value-col" style="font-weight: bold; color: #dc3545;">{{ number_format($invoice->totalamount - $booking->paid_amount) }} đ</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="signature-table">
            <tr>
                <td>
                    <p style="margin: 0;"><strong>KHÁCH HÀNG</strong></p>
                    <p style="font-size: 10px; color: #999; margin-top: 2px;">(Ký và ghi rõ họ tên)</p>
                </td>
                <td>
                    <p style="margin: 0;"><strong>NGƯỜI LẬP HÓA ĐƠN</strong></p>
                    <p style="font-size: 10px; color: #999; margin-top: 2px;">(Đã ký điện tử)</p>
                    <div style="margin-top: 15px; color: #032a63; font-weight: bold; font-style: italic;">
                        GoViet Travel
                    </div>
                </td>
            </tr>
        </table>

        <div class="footer">
            <p style="margin: 2px 0;">Cảm ơn Quý khách đã tin tưởng sử dụng dịch vụ của GoViet Travel!</p>
            <p style="margin: 2px 0;">Đây là hóa đơn điện tử có giá trị pháp lý lưu hành nội bộ theo quy định hiện hành.</p>
        </div>
    </div>
</body>
</html>