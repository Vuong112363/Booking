@extends('adminlte::page')

@section('title', 'Trung Tâm Điều Hành GoViet')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2 align-items-center">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark font-weight-bold"><i class="fas fa-tachometer-alt text-primary mr-2"></i>TỔNG QUAN HỆ THỐNG</h1>
        </div>
        <div class="col-sm-6 text-right">
            <button class="btn btn-primary btn-sm shadow-sm font-weight-bold rounded-pill px-3" onclick="window.location.reload()">
                <i class="fas fa-sync-alt mr-1"></i> Làm mới
            </button>
            <span class="badge badge-white p-2 shadow-sm border ml-2 text-muted rounded-pill">
                <i class="far fa-calendar-alt text-primary mr-1"></i> Hôm nay: {{ date('d/m/Y') }}
            </span>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">

    {{-- PHẦN 1: KPI CHÍNH (Hiển thị các con số quan trọng nhất) --}}
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm hover-elevate">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-wallet"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted font-weight-bold small">DOANH THU THÁNG NÀY</span>
                    <span class="info-box-number h4 mb-0 text-success">{{ number_format($revenueThisMonth) }}đ</span>
                    <span class="text-xs {{ $revenueGrowth >= 0 ? 'text-success' : 'text-danger' }}">
                        <i class="fas {{ $revenueGrowth >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i> {{ number_format(abs($revenueGrowth), 1) }}% so với tháng trước
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm hover-elevate">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted font-weight-bold small">TỔNG ĐƠN HÀNG</span>
                    <span class="info-box-number h4 mb-0">{{ $totalBookings }}</span>
                    <span class="text-xs text-info"><i class="fas fa-plus"></i> {{ $bookingsToday }} đơn mới hôm nay</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm hover-elevate">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted font-weight-bold small">TỔNG KHÁCH HÀNG</span>
                    <span class="info-box-number h4 mb-0">{{ $totalUsers }}</span>
                    <span class="text-xs text-warning"><a href="{{ url('admin/users') }}" class="text-warning small">Xem chi tiết <i class="fas fa-angle-right"></i></a></span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm hover-elevate">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-map-marked-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted font-weight-bold small">TOUR ĐANG MỞ BÁN</span>
                    <span class="info-box-number h4 mb-0">{{ $activeTours }}</span>
                    <span class="text-xs text-primary"><a href="{{ url('admin/tours') }}" class="text-primary small">Quản lý Tour <i class="fas fa-angle-right"></i></a></span>
                </div>
            </div>
        </div>
    </div>

    {{-- PHẦN 2: QUẢN LÝ DÒNG TIỀN (SỔ QUỸ CHI TIẾT) --}}
    <h5 class="mb-3 font-weight-bold text-dark mt-3"><i class="fas fa-file-invoice-dollar text-secondary mr-2"></i>Sổ Quỹ & Hoàn Trả</h5>
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-white border-left-success shadow-sm">
                <div class="inner">
                    <h4 class="font-weight-bold text-success">{{ number_format($totalRevenue) }}đ</h4>
                    <p class="text-muted mb-0 small text-uppercase font-weight-bold">Lợi Nhuận Thuần (Đã trừ hoàn)</p>
                </div>
                <div class="icon"><i class="fas fa-coins text-success opacity-50"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-white border-left-info shadow-sm">
                <div class="inner">
                    <h4 class="font-weight-bold text-info">{{ number_format($totalPickupFees) }}đ</h4>
                    <p class="text-muted mb-0 small text-uppercase font-weight-bold">Phụ Phí Đón (Không hoàn trả)</p>
                </div>
                <div class="icon"><i class="fas fa-bus text-info opacity-50"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-white border-left-danger shadow-sm">
                <div class="inner">
                    <h4 class="font-weight-bold text-danger">{{ number_format($totalRefundPending) }}đ</h4>
                    <p class="text-muted mb-0 small text-uppercase font-weight-bold">Tiền Chờ Hoàn (Cần trả khách)</p>
                </div>
                <div class="icon"><i class="fas fa-undo text-danger opacity-50"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-white border-left-warning shadow-sm">
                <div class="inner">
                    <h4 class="font-weight-bold text-warning">{{ number_format($totalDebt) }}đ</h4>
                    <p class="text-muted mb-0 small text-uppercase font-weight-bold">Công Nợ Khách Cần Thu</p>
                </div>
                <div class="icon"><i class="fas fa-user-clock text-warning opacity-50"></i></div>
            </div>
        </div>
    </div>

    {{-- PHẦN 3: BIỂU ĐỒ XU HƯỚNG --}}
    <div class="row mt-2">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-chart-line text-primary mr-2"></i>Biểu Đồ Doanh Thu {{ date('Y') }}</h3>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" style="height: 320px; width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-chart-pie text-info mr-2"></i>Tỷ Lệ Đơn Hàng</h3>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <canvas id="statusChart" style="height: 250px; width: 100%;"></canvas>
                </div>
                <div class="card-footer bg-white border-top p-0">
                    <ul class="nav nav-pills flex-column text-sm">
                        <li class="nav-item">
                            <a href="#" class="nav-link text-dark">Chờ duyệt <span class="float-right text-warning font-weight-bold"><i class="fas fa-circle text-warning mr-1"></i> {{ $statusChart['pending'] }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-dark">Chờ hoàn tiền <span class="float-right text-danger font-weight-bold"><i class="fas fa-circle text-danger mr-1"></i> {{ $statusChart['refund_pending'] }}</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- KHỐI 4: TOP TOUR BÁN CHẠY & ĐƠN HÀNG MỚI (TRỰC QUAN HƠN) --}}
    {{-- ======================================================= --}}
    <div class="row mt-4">
        
        {{-- 4.1. BẢNG XẾP HẠNG TOP 5 TOUR BÁN CHẠY --}}
        <div class="col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h3 class="card-title font-weight-bold text-dark"><i class="fas fa-trophy text-warning mr-2"></i>Top 5 Tour Bán Chạy Nhất</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @forelse($topTours as $index => $tour)
                            <li class="item p-3 border-bottom-0">
                                <div class="product-info ml-0">
                                    <a href="javascript:void(0)" class="product-title text-dark">
                                        <span class="badge badge-{{ $index == 0 ? 'danger' : ($index == 1 ? 'warning' : ($index == 2 ? 'success' : 'secondary')) }} mr-2">#{{ $index + 1 }}</span>
                                        {{ Str::limit($tour->title, 40) }}
                                        <span class="badge badge-info float-right">{{ $tour->total_bookings }} Đơn</span>
                                    </a>
                                    <span class="product-description text-success font-weight-bold mt-1">
                                        <i class="fas fa-money-bill-wave mr-1"></i> Doanh thu: {{ number_format($tour->total_earned) }} đ
                                    </span>
                                    {{-- Thanh tiến trình trực quan --}}
                                    @php 
                                        $maxBookings = $topTours->max('total_bookings'); 
                                        $percent = ($tour->total_bookings / ($maxBookings > 0 ? $maxBookings : 1)) * 100;
                                    @endphp
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar bg-{{ $index == 0 ? 'danger' : 'info' }}" style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="item p-3 text-center text-muted">Chưa có dữ liệu Tour bán chạy.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        {{-- 4.2. DANH SÁCH ĐƠN HÀNG MỚI ĐỔ VỀ --}}
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h3 class="card-title font-weight-bold text-dark"><i class="fas fa-cart-arrow-down text-primary mr-2"></i>Đơn Đặt Tour Mới Nhất</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                    </div>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Mã Đơn</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings as $booking)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $booking->bookingid) }}" class="font-weight-bold text-primary">
                                            #{{ str_pad($booking->bookingid, 5, '0', STR_PAD_LEFT) }}
                                        </a>
                                        <br><small class="text-muted">{{ \Carbon\Carbon::parse($booking->bookingdate)->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <b>{{ $booking->username }}</b>
                                        <br><span class="badge bg-light text-dark border">{{ strtoupper($booking->paymentmethod) }}</span>
                                    </td>
                                    <td class="font-weight-bold text-dark">{{ number_format($booking->totalprice) }}đ</td>
                                    <td>
                                        {{-- Trạng thái Đơn hàng --}}
                                        @if($booking->bookingstatus == 'pending') <span class="badge badge-warning"><i class="fas fa-clock"></i> Chờ duyệt</span>
                                        @elseif($booking->bookingstatus == 'confirmed') <span class="badge badge-success"><i class="fas fa-check"></i> Đã duyệt</span>
                                        @elseif($booking->bookingstatus == 'completed') <span class="badge badge-primary"><i class="fas fa-flag-checkered"></i> Hoàn tất</span>
                                        @else <span class="badge badge-danger"><i class="fas fa-times"></i> Đã hủy</span>
                                        @endif
                                        
                                        <div class="mt-1"></div>
                                        
                                        {{-- Trạng thái Thanh toán --}}
                                        @if($booking->paymentstatus == 'unpaid') <span class="badge badge-secondary">Chưa TT</span>
                                        @elseif($booking->paymentstatus == 'deposit_paid') <span class="badge badge-info">Đã Cọc</span>
                                        @elseif($booking->paymentstatus == 'paid') <span class="badge badge-success">Đã TT 100%</span>
                                        @elseif($booking->paymentstatus == 'refund_pending') <span class="badge badge-warning">Chờ hoàn tiền</span>
                                        @else <span class="badge badge-dark">Đã hoàn tiền</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted">Chưa có đơn đặt tour nào.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- KHỐI 5: NHẬT KÝ HOẠT ĐỘNG HỆ THỐNG (TIMELINE) --}}
    {{-- ======================================================= --}}
    <div class="row mt-2">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h3 class="card-title font-weight-bold text-dark"><i class="fas fa-history text-secondary mr-2"></i>Nhật Ký Hoạt Động (Logs)</h3>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-inverse mb-0">
                        @foreach($histories as $history)
                            @php 
                                // Tạo màu và icon ngẫu nhiên dựa trên nội dung actionType cho sinh động
                                $icon = 'fa-info'; $color = 'bg-primary';
                                if(str_contains(strtolower($history->actionType), 'hủy')) { $icon = 'fa-ban'; $color = 'bg-danger'; }
                                elseif(str_contains(strtolower($history->actionType), 'tạo') || str_contains(strtolower($history->actionType), 'mới')) { $icon = 'fa-plus'; $color = 'bg-success'; }
                                elseif(str_contains(strtolower($history->actionType), 'cập nhật') || str_contains(strtolower($history->actionType), 'duyệt')) { $icon = 'fa-edit'; $color = 'bg-warning'; }
                                elseif(str_contains(strtolower($history->actionType), 'thanh toán') || str_contains(strtolower($history->actionType), 'thu tiền')) { $icon = 'fa-dollar-sign'; $color = 'bg-info'; }
                            @endphp
                            <div>
                                <i class="fas {{ $icon }} {{ $color }}"></i>
                                <div class="timeline-item shadow-none border">
                                    <span class="time text-muted"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($history->timestamp)->diffForHumans() }}</span>
                                    <h3 class="timeline-header border-0" style="font-size: 0.9rem;">
                                        <b class="text-primary">{{ $history->username }}</b> 
                                        <span class="text-muted">{{ $history->actionType }}</span>
                                    </h3>
                                </div>
                            </div>
                        @endforeach
                        <div><i class="far fa-clock bg-gray"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(function () {
        Chart.defaults.font.family = '"Nunito", sans-serif';
        var revCtx = document.getElementById('revenueChart').getContext('2d');
        var gradient = revCtx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(40, 167, 69, 0.8)');
        gradient.addColorStop(1, 'rgba(40, 167, 69, 0.1)');

        new Chart(revCtx, {
            type: 'bar',
            data: {
                labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
                datasets: [{
                    label: 'Doanh thu thuần (VNĐ)',
                    data: @json($monthlyRevenue),
                    backgroundColor: gradient,
                    borderRadius: 5,
                }]
            },
            options: { 
                maintainAspectRatio: false, 
                plugins: { legend: { display: false } },
                scales: { 
                    y: { beginAtZero: true, ticks: { callback: function(value) { return value.toLocaleString('vi-VN') + 'đ'; } } },
                    x: { grid: { display: false } }
                } 
            }
        });

        var s = @json($statusChart);
        new Chart(document.getElementById('statusChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Đã Duyệt', 'Chờ Duyệt', 'Đã Hủy', 'Chờ Hoàn Tiền'],
                datasets: [{
                    data: [s.confirmed, s.pending, s.cancelled, s.refund_pending],
                    backgroundColor: ['#28a745', '#ffc107', '#858796', '#dc3545'],
                }]
            },
            options: { cutout: '75%', maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
        });
    });
</script>
@stop

@section('css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap');
    body { font-family: 'Nunito', sans-serif; background-color: #f8f9fc; }
    .hover-elevate { transition: transform 0.2s ease; }
    .hover-elevate:hover { transform: translateY(-3px); }
    .border-left-success { border-left: 4px solid #28a745!important; }
    .border-left-info { border-left: 4px solid #36b9cc!important; }
    .border-left-warning { border-left: 4px solid #f6c23e!important; }
    .border-left-danger { border-left: 4px solid #e74a3b!important; }
    .border-left-secondary { border-left: 4px solid #858796!important; }
    .card { box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important; }
</style>
@stop