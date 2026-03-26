@extends('adminlte::page')

@section('title', 'Quản lý Booking')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-list-alt mr-2"></i>Danh Sách Booking</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Quản lý Booking</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary">
        <h3 class="card-title"><i class="fas fa-search mr-1"></i> Bộ lọc & Tìm kiếm</h3>
    </div>
    
    <div class="card-body border-bottom bg-light">
        <form action="{{ route('admin.bookings.index') }}" method="GET">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <input type="text" name="keyword" class="form-control" placeholder="ID, Khách, Tour..." value="{{ request('keyword') }}">
                </div>
                
                <div class="col-md-2 mb-2">
                    <select name="status" class="form-control">
                        <option value="">-- Trạng thái Đơn --</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã duyệt</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>

                {{-- THÊM BỘ LỌC THEO NGÀY ĐI --}}
                <div class="col-md-2 mb-2">
                    <input type="date" name="start_date" class="form-control" title="Lọc theo ngày khởi hành" value="{{ request('start_date') }}">
                    <small class="text-muted">Lọc theo ngày đi</small>
                </div>
                
                <div class="col-md-3 mb-2">
                    <select name="payment" class="form-control">
                        <option value="">-- Trạng thái Thanh toán --</option>
                        <option value="paid" {{ request('payment') == 'paid' ? 'selected' : '' }}>Đã thanh toán (100%)</option>
                        <option value="deposit_paid" {{ request('payment') == 'deposit_paid' ? 'selected' : '' }}>Đã đặt cọc</option>
                        <option value="unpaid" {{ request('payment') == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                    </select>
                </div>
                
                <div class="col-md-2 mb-2">
                    <button type="submit" class="btn btn-info w-100"><i class="fas fa-filter"></i> Lọc dữ liệu</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped text-nowrap table-valign-middle">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">Mã Đơn</th>
                    <th>Khách Hàng</th>
                    <th>Thông Tin Tour</th>
                    <th class="text-center">Ngày Khởi Hành</th> {{-- THÊM CỘT NÀY --}}
                    <th class="text-right">Tài Chính</th>
                    <th class="text-center">Trạng Thái</th>
                    <th class="text-center">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $item)
                <tr>
                    <td class="text-center">
                        <a href="{{ route('admin.bookings.show', $item->bookingid) }}" class="font-weight-bold">
                            #{{ $item->bookingid }}
                        </a>
                    </td>
                    <td>
                        <strong class="text-primary">{{ $item->user->username ?? 'Khách vãng lai' }}</strong><br>
                        <small class="text-muted"><i class="fas fa-users"></i> {{ $item->numadults }} Lớn, {{ $item->numchildren }} Nhỏ</small>
                    </td>
                    <td>
                        <span title="{{ $item->tour->title ?? '' }}">{{ Str::limit($item->tour->title ?? 'N/A', 30) }}</span><br>
                        <small class="text-muted"><i class="far fa-calendar-alt"></i> Đặt lúc: {{ \Carbon\Carbon::parse($item->bookingdate)->format('H:i d/m') }}</small>
                    </td>
                    
                    {{-- HIỂN THỊ NGÀY ĐI TỪ BẢNG LỊCH TRÌNH --}}
                    <td class="text-center">
                        @if($item->schedule)
                            <div class="badge badge-info shadow-sm p-2" style="font-size: 13px;">
                                <i class="fas fa-bus mr-1"></i> {{ \Carbon\Carbon::parse($item->schedule->startdate)->format('d/m/Y') }}
                            </div>
                        @else
                            <span class="badge badge-secondary p-2" style="font-size: 11px; opacity: 0.7;">Chưa có lịch</span>
                        @endif
                    </td>

                    <td class="text-right">
                        <div>Tổng: <strong class="text-danger">{{ number_format($item->totalprice, 0, ',', '.') }}đ</strong></div>
                        <div><small class="text-success">Đã thu: {{ number_format($item->paid_amount ?? 0, 0, ',', '.') }}đ</small></div>
                    </td>
                    <td class="text-center">
                        {{-- Gộp trạng thái đơn và thanh toán cho gọn --}}
                        @if($item->bookingstatus == 'confirmed')
                            <span class="badge badge-success">Đã duyệt</span>
                        @elseif($item->bookingstatus == 'pending')
                            <span class="badge badge-warning">Chờ duyệt</span>
                        @else
                            <span class="badge badge-danger">Đã hủy</span>
                        @endif
                        <br>
                        <small class="{{ $item->paymentstatus == 'paid' ? 'text-success' : 'text-muted' }}">
                             {{ $item->paymentstatus == 'paid' ? '● Đã trả đủ' : '○ Chưa trả đủ' }}
                        </small>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.bookings.show', $item->bookingid) }}" class="btn btn-sm btn-outline-primary shadow-sm px-3">
                            <i class="fas fa-edit"></i> Xử lý
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-box-open fa-3x mb-3 text-light"></i><br>
                        Không tìm thấy đơn hàng nào phù hợp
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="card-footer clearfix mt-2 text-right">
        {{ $bookings->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
</div>
@stop