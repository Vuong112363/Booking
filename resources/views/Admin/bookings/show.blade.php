@extends('adminlte::page')

@section('title', 'Quản lý Đơn hàng #' . str_pad($booking->bookingid, 6, '0', STR_PAD_LEFT))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="text-dark font-weight-bold">Booking #{{ str_pad($booking->bookingid, 6, '0', STR_PAD_LEFT) }}</h1>
            <p class="text-muted mb-0">Ngày đặt: {{ \Carbon\Carbon::parse($booking->bookingdate)->format('d/m/Y H:i') }}</p>
        </div>
        <div class="btn-group">
            <button onclick="window.print()" class="btn btn-default shadow-sm"><i class="fas fa-print"></i> In đơn hàng</button>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary shadow-sm ml-2">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
@stop

@section('content')
    {{-- 1. THANH CHỈ SỐ NHANH --}}
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info shadow-sm">
                <div class="inner">
                    <h3>{{ number_format($booking->totalprice) }}<sup style="font-size: 20px">đ</sup></h3>
                    <p>Tổng giá trị đơn hàng</p>
                </div>
                <div class="icon"><i class="fas fa-shopping-cart"></i></div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success shadow-sm">
                <div class="inner">
                    <h3>{{ number_format($booking->paid_amount) }}<sup style="font-size: 20px">đ</sup></h3>
                    <p>Số tiền thực thu</p>
                </div>
                <div class="icon"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            @php $balance = $booking->totalprice - $booking->paid_amount; @endphp
            <div class="small-box {{ $balance > 0 ? 'bg-danger' : 'bg-secondary' }} shadow-sm">
                <div class="inner">
                    <h3>{{ number_format($balance > 0 ? $balance : 0) }}<sup style="font-size: 20px">đ</sup></h3>
                    <p>{{ $balance > 0 ? 'Còn nợ (Cần thu thêm)' : 'Đã tất toán' }}</p>
                </div>
                <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            {{-- THÔNG TIN CHI TIẾT --}}
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-list-alt mr-1"></i> Chi tiết lịch trình & Khách hàng</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <tbody>
                            <tr>
                                <th class="bg-light" style="width: 220px">Tên Tour</th>
                                <td>
                                    <strong class="text-primary" style="font-size: 1.1rem;">{{ $booking->tour->title ?? 'Tour đã bị xóa' }}</strong>
                                    <br><small class="badge badge-info mt-1"><i class="far fa-clock"></i> {{ $booking->tour->duration ?? 'N/A' }}</small>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Khách hàng đặt</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-2">
                                            <i class="fas fa-user-circle fa-2x text-secondary"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $booking->user->username ?? 'Khách lẻ' }}</strong><br>
                                            <span class="text-muted small">{{ $booking->user->email ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Ngày khởi hành</th>
                                <td>
                                    <span class="text-danger font-weight-bold" style="font-size: 1.1rem;">
                                        <i class="far fa-calendar-check mr-1"></i>
                                        {{ isset($booking->schedule->startdate) ? \Carbon\Carbon::parse($booking->schedule->startdate)->format('d/m/Y') : 'Chưa xác định' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Số lượng thành viên</th>
                                <td>
                                    <span class="mr-3"><i class="fas fa-male text-muted mr-1"></i>Người lớn: <b>{{ $booking->numadults }}</b></span>
                                    <span><i class="fas fa-child text-muted mr-1"></i>Trẻ em: <b>{{ $booking->numchildren }}</b></span>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light text-warning"><i class="fas fa-info-circle mr-1"></i> Yêu cầu & Ghi chú</th>
                                <td>
                                    @if($booking->specialrequest)
                                        <div class="bg-light p-3 rounded border" style="white-space: pre-line; border-left: 4px solid #ffc107 !important;">
                                            {{ $booking->specialrequest }}
                                        </div>
                                    @else
                                        <i class="text-muted small italic">Không có yêu cầu đặc biệt từ khách hàng.</i>
                                    @endif
                                </td>
                            </tr>
                            @if($booking->bookingstatus == 'cancelled')
                            <tr>
                                <th class="bg-danger text-white">Lý do hủy đơn</th>
                                <td class="bg-red-light" style="background: #fff5f5;">
                                    <b class="text-danger">{{ $booking->cancel_reason ?? 'Không có lý do' }}</b>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- NHẬT KÝ ĐƠN HÀNG (TIMELINE) --}}
            <div class="card card-outline card-secondary mt-4 shadow-sm">
                <div class="card-header p-2">
                    <h3 class="card-title font-weight-bold ml-2"><i class="fas fa-history mr-1"></i> Lịch sử xử lý nội bộ</h3>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-inverse">
                        {{-- Mẹo: Bạn có thể query tbl_history để hiện ở đây --}}
                        <div>
                            <i class="fas fa-check bg-success"></i>
                            <div class="timeline-item shadow-none border">
                                <span class="time"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($booking->bookingdate)->format('H:i') }}</span>
                                <h3 class="timeline-header border-0 text-muted small"><b>Hệ thống:</b> Tiếp nhận đơn hàng mới thành công.</h3>
                            </div>
                        </div>
                        @if($booking->paid_amount > 0)
                        <div>
                            <i class="fas fa-dollar-sign bg-primary"></i>
                            <div class="timeline-item shadow-none border">
                                <h3 class="timeline-header border-0 text-muted small"><b>Thanh toán:</b> Ghi nhận khoản thu {{ number_format($booking->paid_amount) }}đ từ {{ $booking->paymentmethod }}.</h3>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            {{-- FORM ĐIỀU KHIỂN --}}
            <div class="card card-warning card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-tools mr-1"></i> Thao tác quản trị</h3>
                </div>
                <form action="{{ route('admin.bookings.update_status', $booking->bookingid) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success border-0 shadow-sm mb-3">
                                <i class="icon fas fa-check"></i> {{ session('success') }}
                            </div>
                        @endif

                        <div class="form-group border-bottom pb-3">
                            <label class="text-muted small text-uppercase">Tình trạng Tour</label>
                            <select name="bookingstatus" class="form-control font-weight-bold border-primary shadow-sm">
                                <option value="pending" {{ $booking->bookingstatus == 'pending' ? 'selected' : '' }}>🕒 Chờ xử lý đơn</option>
                                <option value="confirmed" {{ $booking->bookingstatus == 'confirmed' ? 'selected' : '' }}>✅ Duyệt & Đã chốt chỗ</option>
                                <option value="completed" {{ $booking->bookingstatus == 'completed' ? 'selected' : '' }}>🏁 Hoàn tất chuyến đi</option>
                                <option value="cancelled" {{ $booking->bookingstatus == 'cancelled' ? 'selected' : '' }}>❌ Hủy đơn hàng</option>
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label class="text-muted small text-uppercase text-success">Trạng thái Thanh toán</label>
                            <select name="paymentstatus" class="form-control font-weight-bold border-success shadow-sm text-success">
                                <option value="unpaid" {{ $booking->paymentstatus == 'unpaid' ? 'selected' : '' }}>⚪ Chưa thanh toán</option>
                                <option value="deposit_paid" {{ $booking->paymentstatus == 'deposit_paid' ? 'selected' : '' }}>🟠 Đã thu cọc (30%)</option>
                                <option value="paid" {{ $booking->paymentstatus == 'paid' ? 'selected' : '' }}>🟢 Đã thu đủ (100%)</option>
                                <option value="refund_pending" {{ $booking->paymentstatus == 'refund_pending' ? 'selected' : '' }}>🔴 Chờ hoàn tiền hủy tour</option>
                                <option value="refunded" {{ $booking->paymentstatus == 'refunded' ? 'selected' : '' }}>✅ Đã hoàn trả tiền</option>
                            </select>
                        </div>

                        <div class="alert alert-info mt-3 p-2 small border-0 shadow-none">
                            <i class="fas fa-lightbulb mr-1"></i> Lưu ý: Khi cập nhật trạng thái, hệ thống sẽ tự động gửi Email xác nhận cho khách hàng.
                        </div>
                    </div>

                    <div class="card-footer bg-transparent border-0">
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-sm">
                            <i class="fas fa-save mr-1"></i> LƯU THAY ĐỔI
                        </button>
                        
                        @if($booking->paymentstatus != 'paid' && $booking->bookingstatus != 'cancelled')
                        <a href="{{ route('admin.bookings.confirm_cash', $booking->bookingid) }}" 
                           class="btn btn-outline-success btn-block mt-3 shadow-sm font-weight-bold"
                           onclick="return confirm('Bạn có chắc chắn muốn xác nhận thu tiền mặt toàn bộ đơn hàng này?')">
                            <i class="fas fa-hand-holding-usd mr-1"></i> NHẬN TIỀN MẶT 100%
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            @if($booking->bookingstatus == 'cancelled')
    <tr style="background: #fffdf5; border: 2px solid #ffc107;">
        <th class="bg-warning text-dark">
            <i class="fas fa-undo-alt mr-1"></i> Số tiền hoàn trả (Đã trừ phí đón)
        </th>
        <td>
            <div class="d-flex align-items-center">
                <strong class="text-danger" style="font-size: 1.3rem;">
                    {{ number_format($booking->refund_amount) }}đ
                </strong>
                <ul class="ml-3 mb-0 small text-muted" style="list-style: none; padding-left: 0;">
                    <li>- Tiền khách đóng: {{ number_format($booking->paid_amount) }}đ</li>
                    <li>- Phụ phí đón khách: {{ number_format($booking->pickup_fee_total) }}đ (Khấu trừ)</li>
                    <li><b>= Tiền hoàn chốt: {{ number_format($booking->refund_amount) }}đ</b></li>
                </ul>
            </div>
        </td>
    </tr>
@endif
        </div>
    </div>
@stop

@section('css')
    <style>
        /* CSS cho việc In ấn hóa đơn */
        @media print {
            .main-sidebar, .main-footer, .btn, .card-footer, .col-md-4, .alert { display: none !important; }
            .col-md-8 { width: 100% !important; flex: 0 0 100% !important; max-width: 100% !important; }
            .content-wrapper { background: #fff !important; margin: 0 !important; }
            .card { border: 1px solid #ddd !important; box-shadow: none !important; }
        }
        .bg-red-light { background-color: #fff5f5 !important; }
        .timeline-inverse > div > .timeline-item { background-color: #f8f9fa; }
    </style>
@stop