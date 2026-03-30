@include('Clients.blocks.header')

<style>
    /* CSS Nâng cấp giao diện Modern UI - Pro Version */
    body { background-color: #f4f6f9; font-family: 'Inter', sans-serif; }
    
    /* Card Styles */
    .booking-card { transition: all 0.3s ease; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; background: #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .booking-card:hover { transform: translateY(-4px); box-shadow: 0 15px 30px rgba(0,0,0,0.08); border-color: #cbd5e1; }
    .booking-header { background-color: #f8fafc; border-bottom: 1px dashed #e2e8f0; padding: 16px 24px; }
    .booking-body { padding: 24px; }
    .booking-footer { background-color: #f8fafc; border-top: 1px solid #f1f5f9; padding: 16px 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px; }
    
    /* Typography & Colors */
    .tour-title { font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 8px; line-height: 1.4; }
    .tour-title a:hover { color: #2563eb !important; text-decoration: none; }
    .info-label { font-size: 0.8rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .price-value { font-size: 1.4rem; font-weight: 800; color: #e11d48; }
    .status-badge { padding: 6px 14px; border-radius: 50px; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; }
    
    /* Image Thumbnail */
    .tour-thumbnail { width: 160px; height: 120px; object-fit: cover; border-radius: 12px; border: 1px solid #e2e8f0; }
    
    /* Custom Tabs & Filters */
    .modern-tabs .nav-link { border: none; color: #64748b; font-weight: 600; padding: 12px 25px; border-radius: 50px; margin-right: 10px; transition: all 0.2s; }
    .modern-tabs .nav-link.active { background-color: #2563eb; color: #fff; box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3); }
    
    .filter-wrapper::-webkit-scrollbar { display: none; } /* Hide scrollbar for filter pills */
    .filter-pill { border: 1px solid #e2e8f0; color: #475569; background: #fff; border-radius: 50px; padding: 8px 20px; font-weight: 600; font-size: 0.9rem; transition: all 0.2s; white-space: nowrap; }
    .filter-pill:hover { background: #f1f5f9; }
    .filter-pill.active { background: #0f172a; color: #fff; border-color: #0f172a; }

    /* Order Tracker (Progress Bar) */
    .order-tracker { display: flex; justify-content: space-between; position: relative; margin: 25px 0 10px 0; max-width: 500px; }
    .order-tracker::before { content: ''; position: absolute; top: 12px; left: 10%; right: 10%; height: 3px; background: #e2e8f0; z-index: 1; }
    .tracker-step { position: relative; z-index: 2; text-align: center; flex: 1; }
    .tracker-icon { width: 28px; height: 28px; border-radius: 50%; background: #e2e8f0; color: #94a3b8; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px auto; font-size: 0.8rem; border: 3px solid #fff; transition: all 0.3s; }
    .tracker-text { font-size: 0.75rem; font-weight: 600; color: #64748b; }
    .tracker-step.active .tracker-icon { background: #10b981; color: #fff; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2); }
    .tracker-step.active .tracker-text { color: #10b981; }

    /* Timeline Log & Modals */
    .timeline-log { position: relative; padding-left: 30px; }
    .timeline-log::before { content: ''; position: absolute; left: 11px; top: 0; bottom: 0; width: 2px; background: #e2e8f0; }
    .timeline-item { position: relative; margin-bottom: 24px; }
    .timeline-icon { position: absolute; left: -30px; top: 0; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #fff; border: 2px solid #e2e8f0; z-index: 1; }
    .modal { background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); }
    .modal-backdrop { display: none !important; } 
    .modal-content { border: none; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }

    /* Utilities */
    .text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    /* CSS cho Modal Lịch trình dạng Accordion (Đóng/Mở) */
    .timeline-accordion-item {
        position: relative;
        padding-left: 45px;
        margin-bottom: 5px;
    }
    /* Đường kẻ dọc nối các ngày */
    .timeline-accordion-item::before {
        content: '';
        position: absolute;
        left: 15px; /* Nằm giữa nút tick xanh 30px */
        top: 30px;
        bottom: -10px;
        border-left: 1px solid #e2e8f0;
        z-index: 1;
    }
    /* Ẩn đường kẻ ở item cuối cùng */
    .timeline-accordion-item:last-child::before {
        display: none;
    }
    /* Nút Tick Xanh */
    .timeline-check-icon {
        position: absolute;
        left: 0;
        top: 0;
        width: 30px;
        height: 30px;
        background-color: #5cb85c; /* Màu xanh lá giống ảnh */
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        font-size: 0.85rem;
    }
    /* Nút bấm tiêu đề */
    .timeline-header-btn {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: transparent;
        border: none;
        border-bottom: 1px solid #f1f5f9;
        padding: 4px 0 15px 0;
        font-size: 1.05rem;
        font-weight: 600;
        color: #1f2937;
        text-align: left;
    }
    .timeline-header-btn:focus { outline: none; }
    
    /* Icon Mũi tên Đóng/Mở */
    .timeline-header-btn .toggle-icon {
        transition: transform 0.3s, color 0.3s;
        color: #1f2937; /* Mũi tên đen khi đóng */
        font-size: 1.1rem;
    }
    /* Khi đang mở (aria-expanded="true") */
    .timeline-header-btn[aria-expanded="true"] .toggle-icon {
        color: #f97316; /* Đổi sang màu cam giống ảnh */
        transform: rotate(90deg); /* Xoay mũi tên chúc xuống */
    }
    .timeline-content {
        padding: 15px 0 20px 0;
        color: #4b5563;
        line-height: 1.7;
    }
</style>

<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center">
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm mr-3" style="width: 55px; height: 55px;">
                <i class="fa-solid fa-plane-departure fa-lg"></i>
            </div>
            <div>
                <h2 class="font-weight-bold mb-0 text-dark">Chuyến đi của tôi</h2>
                <p class="text-muted mb-0">Quản lý và theo dõi lịch trình du lịch của bạn</p>
            </div>
        </div>
    </div>

    {{-- THÔNG BÁO --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-lg d-flex align-items-center mb-4">
            <i class="fa-solid fa-circle-check fa-lg mr-2"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-lg d-flex align-items-center mb-4">
            <i class="fa-solid fa-triangle-exclamation fa-lg mr-2"></i> {{ session('error') }}
        </div>
    @endif

    {{-- NAVIGATION TABS --}}
    <ul class="nav nav-pills modern-tabs mb-4" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active shadow-sm" id="pills-bookings-tab" data-bs-toggle="pill" data-bs-target="#pills-bookings" type="button" role="tab" aria-selected="true">
                <i class="fa-solid fa-ticket mr-1"></i> Đơn hàng của tôi
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link shadow-sm" id="pills-logs-tab" data-bs-toggle="pill" data-bs-target="#pills-logs" type="button" role="tab" aria-selected="false">
                <i class="fa-solid fa-clock-rotate-left mr-1"></i> Lịch sử hoạt động
            </a>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        
        {{-- TAB 1: DANH SÁCH BOOKING --}}
        <div class="tab-pane fade show active" id="pills-bookings" role="tabpanel">
            
            {{-- BỘ LỌC THÔNG MINH (JS Filter) --}}
            @if(count($bookings) > 0)
            <div class="d-flex gap-2 mb-4 overflow-auto filter-wrapper pb-2" id="bookingFilters">
                <button class="filter-pill active" data-filter="all">Tất cả chuyến đi</button>
                <button class="filter-pill" data-filter="unpaid">Chờ thanh toán</button>
                <button class="filter-pill" data-filter="upcoming">Sắp khởi hành</button>
                <button class="filter-pill" data-filter="completed">Đã hoàn thành</button>
                <button class="filter-pill" data-filter="cancelled">Đã hủy</button>
            </div>
            @endif

            <div class="row" id="bookingList">
                @forelse($bookings as $item)
                    @php
                        // Logic tính toán cho đếm ngược và bộ lọc
                        $daysLeft = 0;
                        $isUpcoming = false;
                        if(isset($item->startdate) && strtotime($item->startdate) > time() && $item->bookingstatus == 'confirmed') {
                            $daysLeft = ceil((strtotime($item->startdate) - time()) / 86400);
                            $isUpcoming = true;
                        }
                    @endphp

                    {{-- Data attributes để dùng JS Filter --}}
                    <div class="col-12 mb-4 booking-item" 
                         data-payment="{{ $item->paymentstatus }}" 
                         data-status="{{ $item->bookingstatus }}" 
                         data-upcoming="{{ $isUpcoming ? 'true' : 'false' }}">
                         
                        <div class="booking-card">
                            {{-- Header: Mã đơn & Trạng thái --}}
                            <div class="booking-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <div>
                                    <span class="text-muted mr-1">Mã Đơn:</span>
                                    <span class="font-weight-bold text-dark">#{{ str_pad($item->bookingid, 6, '0', STR_PAD_LEFT) }}</span>
                                    <span class="text-muted mx-2 d-none d-sm-inline">|</span>
                                    <span class="text-muted d-block d-sm-inline mt-1 mt-sm-0"><i class="fa-regular fa-clock mr-1"></i> Đặt lúc: {{ date('d/m/Y H:i', strtotime($item->bookingdate)) }}</span>
                                </div>
                                <div class="d-flex gap-2 flex-wrap">
                                    {{-- Huy hiệu Đếm ngược --}}
                                    @if($isUpcoming)
                                        <span class="badge bg-danger text-white px-3 py-2" style="border-radius: 50px; font-size:0.85rem;"><i class="fa-solid fa-fire mr-1"></i> Chỉ còn {{ $daysLeft }} ngày</span>
                                    @endif

                                    {{-- Trạng thái Tour --}}
                                    @if($item->bookingstatus == 'pending')
                                        <span class="status-badge bg-warning text-dark"><i class="fa-solid fa-hourglass-half"></i> Chờ xử lý</span>
                                    @elseif($item->bookingstatus == 'confirmed')
                                        @if($isUpcoming)
                                            <span class="status-badge bg-primary text-white"><i class="fa-solid fa-calendar-check"></i> Đã chốt lịch</span>
                                        @elseif(isset($item->startdate))
                                            <span class="status-badge bg-info text-dark"><i class="fa-solid fa-map-location-dot"></i> Đang đi Tour</span>
                                        @endif
                                    @elseif($item->bookingstatus == 'completed')
                                        <span class="status-badge bg-success text-white"><i class="fa-solid fa-check-double"></i> Hoàn thành</span>
                                    @elseif($item->bookingstatus == 'cancelled')
                                        <span class="status-badge bg-danger text-white"><i class="fa-solid fa-ban"></i> Đã hủy</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Body: Thông tin Tour Đầy đủ --}}
                            <div class="booking-body">
                                <div class="d-flex flex-column flex-md-row gap-4">
                                    {{-- Hình ảnh Tour --}}
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('clients/assets/images/gallery-tours/' . ($item->images ?? 'default.jpg')) }}" 
                                             alt="{{ $item->title }}" 
                                             class="tour-thumbnail shadow-sm">
                                    </div>
                                    

                                    {{-- Thông tin cốt lõi --}}
                                    <div class="flex-grow-1">
                                        <h4 class="tour-title text-truncate-2">
                                            <a href="{{ url('/tour-detail/'.$item->tourid) }}" class="text-dark" target="_blank">{{ $item->title }}</a>
                                        </h4>
                                        {{-- Chèn vào ngay dưới tiêu đề tour hoặc phần thời lượng --}}
<div class="mt-3">
    @if($item->pickup_name)
        <div class="d-flex align-items-center p-3 rounded-lg border" style="background-color: #fff9f5; border-color: #ffe4d3 !important;">
            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm mr-3" style="width: 40px; height: 40px; min-width: 40px;">
                <i class="fa-solid fa-bus-simple" style="color: #ff5722;"></i>
            </div>
            <div>
                <div class="text-uppercase font-weight-bold" style="font-size: 0.7rem; color: #9a5f2a; letter-spacing: 0.5px;">Thông tin đón khách:</div>
                <div class="text-dark font-weight-bold" style="font-size: 0.95rem;">
                    {{ $item->pickup_name }} 
                    <span class="mx-2 text-muted">|</span>
                    <i class="fa-regular fa-clock mr-1 text-muted"></i> Đón lúc: {{ date('H:i', strtotime($item->pickup_time)) }}
                </div>
            </div>
        </div>
    @else
        <div class="small text-muted italic">
            <i class="fa-solid fa-circle-info mr-1"></i> Chưa có điểm đón cố định. Hướng dẫn viên sẽ gọi điện sắp xếp điểm đón thuận tiện nhất cho bạn.
        </div>
    @endif
</div>

                                        <div class="d-flex flex-wrap gap-2 mb-3 mt-2">
                                            <span class="badge bg-light text-secondary border font-weight-normal"><i class="fa-solid fa-clock mr-1 text-primary"></i> {{ $item->duration ?? 'Cập nhật sau' }}</span>
                                            <span class="badge bg-light text-secondary border font-weight-normal"><i class="fa-solid fa-location-dot mr-1 text-danger"></i> {{ $item->destination ?? 'Cập nhật sau' }}</span>
                                            <span class="badge bg-light text-secondary border font-weight-normal"><i class="fa-solid fa-user-group mr-1 text-info"></i> {{ $item->numadults }} Lớn, {{ $item->numchildren }} Trẻ em</span>
                                        </div>

                                        <div class="d-flex align-items-center text-dark font-weight-bold">
                                            <div class="bg-light rounded p-2 border mr-3 text-center" style="min-width: 70px;">
                                                <div class="small text-muted text-uppercase" style="font-size: 0.7rem;">Khởi hành</div>
                                                <div class="text-primary">{{ isset($item->startdate) && $item->startdate ? date('d/m', strtotime($item->startdate)) : '--/--' }}</div>
                                            </div>
                                            <div>
                                                <button class="btn btn-sm btn-link text-info p-0 font-weight-bold text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#detail{{ $item->bookingid }}">
                                                    Xem chi tiết yêu cầu & thanh toán <i class="fa-solid fa-angle-down ml-1"></i>
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Chi tiết ẩn (Biên lai thu nhỏ) --}}
                                        <div class="collapse mt-3" id="detail{{ $item->bookingid }}">
                                            <div class="card card-body bg-light border-0 shadow-sm rounded-lg p-4 mt-2" style="border-top: 4px solid #17a2b8 !important;">
                                                <h6 class="font-weight-bold mb-3 border-bottom pb-2 text-dark">
                                                    <i class="fa-solid fa-file-invoice-dollar mr-2 text-primary"></i> Chi tiết thanh toán & Liên hệ
                                                </h6>
                                                
                                                <div class="row">
                                                    {{-- Cột 1: Thông tin khách hàng & Ghi chú --}}
                                                    <div class="col-md-6 mb-3 mb-md-0">
                                                        <div class="bg-white p-3 rounded border h-100">
                                                            <p class="text-muted small text-uppercase mb-2 font-weight-bold">Yêu cầu từ khách hàng</p>
                                                            
                                                            <div class="text-dark small" style="white-space: pre-line; line-height: 1.6;">
                                                                {{ $item->specialrequest ?? 'Không có thông tin ghi chú.' }}
                                                            </div>

                                                            <hr class="my-2">
                                                            <p class="mb-0 small text-muted"><i class="fa-solid fa-headset mr-1 text-success"></i> Cần hỗ trợ khẩn cấp? Gọi: <strong class="text-primary">1900 1234</strong></p>
                                                        </div>
                                                        
                                                    </div>
                                                    

                                                    {{-- Cột 2: Bảng tính tiền chi tiết --}}
<div class="col-md-6">
    <div class="bg-white p-3 rounded border h-100 small position-relative overflow-hidden">
        
        {{-- WATERMARK HIỂU ỨNG CHÌM (CHỈ HIỆN KHI HỦY HOẶC ĐÃ TRẢ ĐỦ) --}}
        @if($item->bookingstatus == 'cancelled')
            <div class="position-absolute d-flex flex-column align-items-center justify-content-center" 
                style="top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-15deg); opacity: 0.08; pointer-events: none; z-index: 0;">
                <i class="fa-solid fa-ban text-danger mb-1" style="font-size: 5rem;"></i>
                <span class="text-danger font-weight-bold" style="font-size: 1.5rem; letter-spacing: 2px;">CANCELLED</span>
            </div>
        @elseif($item->paymentstatus == 'paid')
            <div class="position-absolute d-flex flex-column align-items-center justify-content-center" 
                style="top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-15deg); opacity: 0.08; pointer-events: none; z-index: 0;">
                <i class="fa-solid fa-stamp text-success mb-1" style="font-size: 5rem;"></i>
                <span class="text-success font-weight-bold" style="font-size: 1.5rem; letter-spacing: 2px;">PAID IN FULL</span>
            </div>
        @endif

        <div class="position-relative" style="z-index: 1;">
            
            {{-- ========================================== --}}
            {{-- PHẦN 1: BẢNG TÍNH CHI PHÍ MINH BẠCH --}}
            {{-- ========================================== --}}
            <h6 class="font-weight-bold text-dark border-bottom pb-2 mb-3"><i class="fa-solid fa-file-invoice-dollar mr-1"></i> Bảng tính chi phí</h6>
            
            {{-- Tiền Tour & Số người --}}
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Giá trị Tour:</span>
                    <span class="font-weight-bold text-dark">{{ number_format($item->totalprice - ($item->pickup_fee_total ?? 0)) }} đ</span>
                </div>
                <div class="text-muted mt-1 bg-light p-2 rounded" style="font-size: 0.8rem; border-left: 3px solid #dee2e6;">
                    <i class="fa-solid fa-user-group text-secondary mr-1"></i> {{ $item->numadults }} Người lớn
                    @if($item->numchildren > 0)
                        <span class="mx-2">|</span>
                        <i class="fa-solid fa-child text-secondary mr-1"></i> {{ $item->numchildren }} Trẻ em
                    @endif
                </div>
            </div>

            {{-- Tiền Phụ phí Đón xe --}}
            @if(($item->pickup_fee_total ?? 0) > 0)
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Phụ phí xe đưa đón:</span>
                    <span class="font-weight-bold text-warning">+ {{ number_format($item->pickup_fee_total) }} đ</span>
                </div>
                <div class="text-muted mt-1 bg-light p-2 rounded" style="font-size: 0.8rem; border-left: 3px solid #ffc107;">
                    <div><i class="fa-solid fa-location-dot text-warning mr-1"></i> Đón tại: <b>{{ $item->pickup_name ?? 'Theo yêu cầu' }}</b></div>
                    @if(isset($item->pickup_time))
                    <div class="mt-1"><i class="fa-regular fa-clock text-warning mr-1"></i> Giờ đón dự kiến: <b>{{ \Carbon\Carbon::parse($item->pickup_time)->format('H:i') }}</b></div>
                    @endif
                </div>
            </div>
            @endif

            {{-- TỔNG CỘNG --}}
            <div class="d-flex justify-content-between mt-2 pt-2 border-top">
                <span class="text-dark font-weight-bold">TỔNG CỘNG:</span>
                <span class="font-weight-bold text-primary" style="font-size: 1.2rem;">{{ number_format($item->totalprice) }} đ</span>
            </div>


            {{-- ========================================== --}}
            {{-- PHẦN 2: TÌNH TRẠNG THANH TOÁN --}}
            {{-- ========================================== --}}
            <h6 class="font-weight-bold text-dark border-bottom pb-2 mt-4 mb-3"><i class="fa-solid fa-credit-card mr-1"></i> Tình trạng thanh toán</h6>
            
            <div class="d-flex justify-content-between mb-3">
                <span class="text-muted">Phương thức:</span>
                <span class="font-weight-bold text-uppercase">
                    @php $method = strtolower($item->paymentmethod); @endphp
                    @if($method == 'momo') <span class="text-pink" style="color: #a50064;"><i class="fa-solid fa-wallet mr-1"></i> Ví MoMo</span>
                    @elseif($method == 'cash' || $method == 'tien mat') <span class="text-success"><i class="fa-solid fa-money-bill-wave mr-1"></i> Tiền mặt</span>
                    @else <span class="text-info">{{ $item->paymentmethod ?? 'Chưa rõ' }}</span> @endif
                </span>
            </div>

            {{-- LOGIC THEO TRẠNG THÁI --}}
            @if($item->bookingstatus == 'cancelled')
                {{-- 1. HỦY TOUR --}}
                @php
                    $paid = $item->paid_amount ?? 0;
                    $refund = 0;
                    if($paid > 0 && isset($item->startdate)) {
                        $daysToStart = (strtotime($item->startdate) - strtotime($item->bookingdate)) / 86400; 
                        $refundable_amount = $paid - ($item->pickup_fee_total ?? 0);
                        if($refundable_amount < 0) $refundable_amount = 0;
                        if ($daysToStart >= 5) $refund = $refundable_amount; 
                        elseif ($daysToStart >= 2) $refund = $refundable_amount * 0.5;
                    }
                @endphp
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Đã thanh toán:</span>
                    <span class="font-weight-bold">{{ number_format($paid) }} đ</span>
                </div>
                
                @if($refund > 0)
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Khấu trừ phụ phí/Hủy:</span>
                        <span class="text-danger">- {{ number_format($paid - $refund) }} đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                        <span class="text-muted font-weight-bold">Sẽ hoàn trả khách:</span>
                        <span class="font-weight-bold text-info" style="font-size: 1.1rem;">+ {{ number_format($refund) }} đ</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-2 pt-2 border border-danger p-2 rounded" style="background-color: #fef2f2;">
                        <span class="text-danger font-weight-bold"><i class="fa-solid fa-rotate-left mr-1"></i> TRẠNG THÁI:</span>
                        <span class="font-weight-bold text-danger">
                            @if($item->paymentstatus == 'refunded') <span class="text-success"><i class="fa-solid fa-check-circle mr-1"></i> Đã hoàn tiền</span>
                            @elseif($item->paymentstatus == 'refund_pending') Đang chờ hoàn tiền
                            @else Đã hủy đơn @endif
                        </span>
                    </div>
                    <div class="mt-2 text-muted" style="font-size: 0.75rem; font-style: italic;">
                        * Lưu ý: Tiền hoàn không bao gồm phụ phí xe (nếu có) và áp dụng theo quy định hủy trước ngày đi.
                    </div>
                @else
                    <div class="d-flex justify-content-between mt-2 pt-2 border border-secondary p-2 rounded bg-light">
                        <span class="text-secondary font-weight-bold"><i class="fa-solid fa-circle-xmark mr-1"></i> TRẠNG THÁI:</span>
                        <span class="font-weight-bold text-secondary">Hủy không hoàn tiền</span>
                    </div>
                    @if($paid > 0)
                    <div class="mt-2 text-muted" style="font-size: 0.75rem; font-style: italic;">
                        * Lưu ý: Theo chính sách, tour hủy sát ngày khởi hành sẽ không được hoàn lại tiền đã đóng.
                    </div>
                    @endif
                @endif

            @elseif($item->paymentstatus == 'paid')
                {{-- 2. TRẢ 100% --}}
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Đã thanh toán (100%):</span>
                    <span class="font-weight-bold text-success">- {{ number_format($item->totalprice) }} đ</span>
                </div>
                <div class="d-flex justify-content-between mt-2 pt-2 border border-success p-2 rounded" style="background-color: #f0fdf4;">
                    <span class="text-success font-weight-bold"><i class="fa-solid fa-circle-check mr-1"></i> CÒN LẠI:</span>
                    <span class="font-weight-bold text-success" style="font-size: 1.1rem;">0 đ</span>
                </div>

            @elseif($item->paymentstatus == 'deposit_paid')
                {{-- 3. ĐÃ CỌC --}}
                <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                    <span class="text-muted">Đã đặt cọc:</span>
                    <span class="font-weight-bold text-success">- {{ number_format($item->deposit_amount ?? 0) }} đ</span>
                </div>
                <div class="d-flex justify-content-between mt-2 pt-2 bg-light p-2 rounded border">
                    <span class="text-dark font-weight-bold">CÒN LẠI PHẢI THU:</span>
                    <span class="font-weight-bold text-danger" style="font-size: 1.1rem;">
                        {{ number_format($item->totalprice - ($item->deposit_amount ?? 0)) }} đ
                    </span>
                </div>
                <div class="mt-2 text-muted" style="font-size: 0.75rem; font-style: italic;">
                    * Vui lòng thanh toán số dư còn lại trước ngày khởi hành để nhận vé lên xe.
                </div>

            @else
                {{-- 4. CHƯA THANH TOÁN --}}
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Yêu cầu cọc (30%):</span>
                    <span class="font-weight-bold text-warning">{{ number_format($item->deposit_amount ?? 0) }} đ</span>
                </div>
                <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                    <span class="text-muted">Đã thanh toán:</span>
                    <span class="font-weight-bold text-secondary">0 đ</span>
                </div>
                <div class="d-flex justify-content-between mt-2 pt-2 bg-light p-2 rounded border border-danger">
                    <span class="text-danger font-weight-bold">CHƯA THANH TOÁN:</span>
                    <span class="font-weight-bold text-danger" style="font-size: 1.1rem;">
                        {{ number_format($item->totalprice) }} đ
                    </span>
                </div>
            @endif
            
        </div>
    </div>
</div>
{{-- KẾT THÚC CỘT 2 --}}
                                                </div>
                                                
                                                {{-- Nút tiện ích phụ (Gọi Modal Lịch trình) --}}
                                                <div class="mt-3 pt-2">
    {{-- Nút Xem lịch trình (Đã thêm w-100 và mb-2 để dài bằng nút dưới và có khoảng cách) --}}
    <button type="button" class="btn btn-sm btn-outline-secondary w-100 font-weight-bold bg-white shadow-sm mb-2" 
            data-bs-toggle="modal" data-bs-target="#timelineModal{{ $item->bookingid }}">
        <i class="fa-solid fa-map-location-dot text-primary mr-1"></i> Xem lại lịch trình
    </button>
    
    {{-- Nút Tải PDF --}}
    @if($item->paymentstatus == 'paid')
    <a href="{{ url('/export-invoice/'.$item->bookingid) }}" target="_blank" class="btn btn-sm btn-outline-dark w-100 font-weight-bold shadow-sm">
        <i class="fa-solid fa-file-pdf mr-1 text-danger"></i> Tải hóa đơn PDF
    </a>
    @endif
</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- Order Tracker (Chỉ hiện khi chưa hủy) --}}
                                    @if($item->bookingstatus != 'cancelled')
                                    <div class="d-none d-lg-block border-left pl-4" style="min-width: 200px;">
                                        <div class="info-label mb-2 text-center">Tiến trình</div>
                                        <div class="order-tracker flex-column align-items-center m-0 w-100">
                                            <div class="tracker-step w-100 d-flex align-items-center mb-3 active">
                                                <div class="tracker-icon m-0 mr-2" style="width:20px;height:20px;font-size:0.6rem;"><i class="fa-solid fa-check"></i></div>
                                                <div class="tracker-text text-left">Tiếp nhận</div>
                                            </div>
                                            <div class="tracker-step w-100 d-flex align-items-center mb-3 {{ $item->paymentstatus != 'unpaid' ? 'active' : '' }}">
                                                <div class="tracker-icon m-0 mr-2" style="width:20px;height:20px;font-size:0.6rem;"><i class="fa-solid fa-check"></i></div>
                                                <div class="tracker-text text-left">Thanh toán</div>
                                            </div>
                                            <div class="tracker-step w-100 d-flex align-items-center {{ $item->bookingstatus == 'completed' ? 'active' : '' }}">
                                                <div class="tracker-icon m-0 mr-2" style="width:20px;height:20px;font-size:0.6rem;"><i class="fa-solid fa-check"></i></div>
                                                <div class="tracker-text text-left">Hoàn thành</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Footer: Tổng tiền & Nút hành động --}}
                            <div class="booking-footer">
                                <div>
                                    <div class="info-label mb-1">Tổng thanh toán</div>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="price-value">{{ number_format($item->totalprice) }} <span style="font-size: 1rem; font-weight: 500;">VNĐ</span></div>
                                        
                                        {{-- Nhãn tiền cọc/nợ --}}
                                        @if($item->paymentstatus == 'deposit_paid')
                                            <span class="badge bg-warning text-dark px-2 py-1"><i class="fa-solid fa-coins mr-1"></i> Đã cọc {{ number_format($item->deposit_amount) }}đ</span>
                                        @elseif($item->paymentstatus == 'unpaid')
                                            <span class="badge bg-secondary text-white px-2 py-1"><i class="fa-solid fa-wallet mr-1"></i> Chưa thanh toán</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-2 w-100 w-sm-auto mt-3 mt-sm-0 flex-wrap justify-content-end">
                                    {{-- Nút Hủy (Chỉ hiện khi chưa đi và chưa hủy) --}}
                                    @if($item->bookingstatus != 'cancelled' && $item->bookingstatus != 'completed')
                                        <button type="button" class="btn btn-outline-danger font-weight-bold flex-grow-1 flex-sm-grow-0" data-bs-toggle="modal" data-bs-target="#modalCancel{{ $item->bookingid }}">
                                            Hủy chuyến
                                        </button>
                                    @endif

                                    {{-- Nút Thanh Toán MoMo (Nổi bật nhất) --}}
                                   {{-- Nút Thanh Toán (Hiển thị thông minh theo trạng thái) --}}
    @if($item->bookingstatus != 'cancelled' && $item->bookingstatus != 'completed')
        
        {{-- 1. Nếu chưa thanh toán -> Nút Thanh toán cọc --}}
        @if($item->paymentstatus == 'unpaid')
            <a href="{{ url('/momo-payment/'.$item->bookingid) }}" class="btn btn-success shadow-sm font-weight-bold flex-grow-1 flex-sm-grow-0 px-4">
                <img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" width="20" class="mr-2 rounded bg-white"> Thanh toán cọc
            </a>
            
        {{-- 2. Nếu đã cọc -> Nút Thanh toán số dư còn lại --}}
        @elseif($item->paymentstatus == 'deposit_paid')
            <a href="{{ url('/momo-payment/'.$item->bookingid) }}" class="btn btn-info text-white shadow-sm font-weight-bold flex-grow-1 flex-sm-grow-0 px-4">
                <img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" width="20" class="mr-2 rounded bg-white"> Thanh toán Tổng số tiền còn lại
            </a>
        @endif

    @endif

                                    <a href="{{ url('/tour-detail/'.$item->tourid) }}" class="btn btn-primary font-weight-bold flex-grow-1 flex-sm-grow-0 px-4">
                                        Xem chi tiết Tour
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- MODAL HỦY ĐƠN --}}
                        @if($item->bookingstatus != 'cancelled' && $item->bookingstatus != 'completed')
                            <div class="modal fade" id="modalCancel{{ $item->bookingid }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ url('/booking-cancel/'.$item->bookingid) }}" method="POST" class="w-100">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title font-weight-bold text-danger"><i class="fa-solid fa-triangle-exclamation mr-2"></i> Xác nhận hủy Tour</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="mb-3">Bạn đang yêu cầu hủy chuyến đi <strong>{{ $item->title }}</strong>.</p>
                                                
                                                {{-- Khung chính sách (Đã sửa lỗi không hiển thị) --}}
<div class="bg-light p-3 rounded mb-4 border border-danger-subtle" style="display: block !important;">
    <p class="text-danger fw-bold mb-2 small" style="opacity: 1 !important;">
        <i class="fa-solid fa-file-invoice-dollar me-1"></i> Chính sách hoàn tiền:
    </p>
    
    {{-- Chuyển từ thẻ ul/li sang div để không bị CSS của Theme ẩn đi --}}
    <div class="small text-dark mt-2" style="font-family: Arial, sans-serif !important;">
        <div class="mb-2 d-flex align-items-start">
            <i class="fas fa-check-circle text-success mt-1 me-2" style="width: 15px;"></i> 
            <span>Báo trước <strong>5 ngày</strong>: Hoàn 100% tiền cọc.</span>
        </div>
        <div class="mb-2 d-flex align-items-start">
            <i class="fas fa-exclamation-circle text-warning mt-1 me-2" style="width: 15px;"></i> 
            <span>Báo trước <strong>2-5 ngày</strong>: Hoàn 50% tiền cọc.</span>
        </div>
        <div class="d-flex align-items-start">
            <i class="fas fa-times-circle text-danger mt-1 me-2" style="width: 15px;"></i> 
            <span>Báo dưới <strong>2 ngày</strong>: Không hoàn tiền.</span>
        </div>
    </div>
</div>
                                                
                                                <div class="form-group mb-3">
                                                    <label class="form-label font-weight-bold">Lý do hủy chuyến <span class="text-danger">*</span></label>
                                                    <textarea name="cancel_reason" class="form-control" rows="2" required placeholder="Chia sẻ lý do để chúng tôi hỗ trợ tốt hơn..."></textarea>
                                                </div>

                                                @if($item->paymentstatus != 'unpaid')
                                                <div class="form-group mb-0">
                                                    <label class="form-label font-weight-bold text-success">Thông tin nhận tiền hoàn <span class="text-danger">*</span></label>
                                                    <p class="small text-muted mb-2">Áp dụng nếu đơn hàng đủ điều kiện hoàn tiền.</p>
                                                    <textarea name="refund_info" class="form-control" rows="2" required placeholder="VD: 0123456789 - Vietcombank - NGUYEN VAN A"></textarea>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Suy nghĩ lại</button>
                                                <button type="submit" class="btn btn-danger px-4 shadow-sm">Xác nhận Hủy</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif

                        {{-- MODAL HIỂN THỊ LỊCH TRÌNH CHI TIẾT TỪ TBL_TIMELINE --}}
                        <div class="modal fade" id="timelineModal{{ $item->bookingid }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-light border-bottom-0 pb-3">
                                        <h5 class="modal-title font-weight-bold text-dark">
                                            <i class="fa-solid fa-map-signs text-primary mr-2"></i> Lịch trình: {{ $item->title }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    
                                    <div class="modal-body text-start p-4">
    @if(isset($item->timelines) && count($item->timelines) > 0)
        <div class="pt-2">
            @foreach($item->timelines as $index => $tl)
                @php
                    // Lấy tiêu đề từ DB (Xử lý để hiển thị đẹp nhất)
                    $title = $tl->title ?? $tl->timeline_title ?? 'Hoạt động ngày ' . ($index + 1);
                    // Nếu tiêu đề chưa có chữ "Ngày", tự động thêm vào cho giống ảnh
                    $displayTitle = str_contains(mb_strtolower($title), 'ngày') ? $title : "Ngày ".($index + 1)." - ".$title;
                @endphp

                <div class="timeline-accordion-item">
                    {{-- Nút Tick Xanh --}}
                    <div class="timeline-check-icon shadow-sm">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    
                    {{-- Tiêu đề (Bấm vào để mở nội dung) --}}
                    {{-- Mặc định Ngày 1 sẽ mở (aria-expanded="true"), các ngày khác đóng --}}
                    <button class="timeline-header-btn {{ $index == 0 ? '' : 'collapsed' }}" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapse_tl_{{ $item->bookingid }}_{{ $index }}" 
                            aria-expanded="{{ $index == 0 ? 'true' : 'false' }}">
                        <span>{{ $displayTitle }}</span>
                        {{-- Icon mũi tên tròn --}}
                        <i class="fa-regular fa-circle-right toggle-icon"></i>
                    </button>
                    
                    {{-- Nội dung chi tiết --}}
                    <div id="collapse_tl_{{ $item->bookingid }}_{{ $index }}" 
                         class="collapse {{ $index == 0 ? 'show' : '' }}">
                        <div class="timeline-content small">
                            {!! $tl->description ?? $tl->timeline_description ?? $tl->content ?? '' !!}
                            
                            {{-- Box Bữa ăn & Khách sạn (Nếu có) --}}
                            @if(!empty($tl->meals) || !empty($tl->hotel) || !empty($tl->timeline_hotel))
                                <div class="p-2 bg-light rounded mt-3 border">
                                    @if(!empty($tl->meals) || !empty($tl->timeline_meals))
                                        <span class="mr-3"><i class="fa-solid fa-utensils text-warning mr-1"></i> Bữa ăn: <strong>{{ $tl->meals ?? $tl->timeline_meals }}</strong></span>
                                    @endif
                                    @if(!empty($tl->hotel) || !empty($tl->timeline_hotel))
                                        <span><i class="fa-solid fa-hotel text-info mr-1"></i> Lưu trú: <strong>{{ $tl->hotel ?? $tl->timeline_hotel }}</strong></span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            

   
            @endforeach
            
        </div>
    @else
        <div class="text-center text-muted py-5">
            <i class="fa-solid fa-calendar-xmark fa-3x mb-3 opacity-50 text-secondary"></i>
            <h5>Lịch trình chi tiết đang được cập nhật.</h5>
            <p class="small">Vui lòng liên hệ Hotline 1900 1234 để biết thêm chi tiết.</p>
        </div>
    @endif
</div>
                                    
                                    <div class="modal-footer border-top-0 pt-0">
                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Đóng cửa sổ</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486747.png" alt="Empty" width="120" class="mb-3 opacity-50">
                        <h4 class="text-muted font-weight-bold">Bạn chưa có chuyến đi nào</h4>
                        <p class="text-muted">Hãy khám phá các tour du lịch hấp dẫn và lên lịch trình ngay!</p>
                        <a href="{{ url('/tours') }}" class="btn btn-primary shadow mt-3 px-5 py-2 rounded-pill font-weight-bold">Khám phá Tour ngay</a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- TAB 2: NHẬT KÝ HOẠT ĐỘNG --}}
        <div class="tab-pane fade" id="pills-logs" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-body p-4 p-md-5">
                    <h5 class="font-weight-bold mb-4 border-bottom pb-3"><i class="fa-solid fa-list-check text-primary mr-2"></i> Lịch sử thao tác hệ thống</h5>
                    
                    <div class="timeline-log mt-4">
                        @php
                            $userLogs = \App\Models\History::where('userid', session('userid'))
                                        ->orderBy('timestamp', 'desc')
                                        ->take(15)
                                        ->get();
                        @endphp

                        @forelse($userLogs as $log)
                            <div class="timeline-item">
                                @if(str_contains($log->actionType, 'Thanh toán') || str_contains($log->actionType, 'thành công'))
                                    <div class="timeline-icon border-success text-success"><i class="fa-solid fa-check fa-xs"></i></div>
                                @elseif(str_contains($log->actionType, 'Hủy') || str_contains($log->actionType, 'thất bại'))
                                    <div class="timeline-icon border-danger text-danger"><i class="fa-solid fa-xmark fa-xs"></i></div>
                                @else
                                    <div class="timeline-icon border-primary text-primary"><i class="fa-solid fa-info fa-xs"></i></div>
                                @endif
                                
                                <div class="bg-light p-3 rounded shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="font-weight-bold text-dark">{{ $log->actionType }}</span>
                                        <span class="small text-muted"><i class="fa-regular fa-clock mr-1"></i> {{ date('H:i - d/m/Y', strtotime($log->timestamp)) }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">Chưa có dữ liệu hoạt động.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
 <div class="d-flex justify-content-center mt-4">
        {{ $bookings->links('pagination::bootstrap-4') }}
    </div>

@include('Clients.blocks.footer')

<script>
    // Logic Javascript cho Bộ lọc thông minh (Smart Filters)
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-pill');
        const bookingItems = document.querySelectorAll('.booking-item');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');

                bookingItems.forEach(item => {
                    item.style.display = 'none'; // Ẩn tất cả

                    if (filterValue === 'all') {
                        item.style.display = 'block';
                    } else if (filterValue === 'unpaid' && item.getAttribute('data-payment') === 'unpaid' && item.getAttribute('data-status') !== 'cancelled') {
                        item.style.display = 'block';
                    } else if (filterValue === 'upcoming' && item.getAttribute('data-upcoming') === 'true') {
                        item.style.display = 'block';
                    } else if (filterValue === 'completed' && item.getAttribute('data-status') === 'completed') {
                        item.style.display = 'block';
                    } else if (filterValue === 'cancelled' && item.getAttribute('data-status') === 'cancelled') {
                        item.style.display = 'block';
                    }
                });
            });
        });
    });
</script>