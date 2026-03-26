@extends('adminlte::page')

@section('title', 'Hệ thống Quản lý Khuyến mãi')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-dark font-weight-bold"><i class="fas fa-ticket-alt mr-2 text-primary"></i>Quản Lý Mã Giảm Giá</h1>
        <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addPromotionModal">
            <i class="fas fa-plus-circle"></i> Tạo mã khuyến mãi mới
        </button>
    </div>
@stop

@section('content')
<div class="container-fluid">
    {{-- 1. THỐNG KÊ NHANH --}}
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-info"><i class="fas fa-tags"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Tổng số mã</span>
                    <span class="info-box-number">{{ $promotions->total() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Đang hoạt động</span>
                    <span class="info-box-number">
                        {{ $promotions->where('quantity', '>', 0)->count() }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-warning text-white"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Sắp bắt đầu</span>
                    <span class="info-box-number">
                         {{ $promotions->where('startdate', '>', now())->count() }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Hết hạn / Hết lượt</span>
                    <span class="info-box-number">
                        {{ $promotions->where('enddate', '<', now())->count() }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. BẢNG DANH SÁCH --}}
    <div class="card card-outline card-primary shadow-lg">
        <div class="card-header bg-white">
            <h3 class="card-title text-bold"><i class="fas fa-list mr-1"></i> Danh sách mã Voucher</h3>
            <div class="card-tools">
                <form action="" method="GET" class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="search" class="form-control float-right" placeholder="Tìm tên mã...">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 border-0 shadow-sm">
                    <i class="icon fas fa-check"></i> {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="pl-4">Mã Code</th>
                            <th class="text-center">Chiết khấu</th>
                            <th>Thời hạn sử dụng</th>
                            <th style="width: 15%">Độ khả dụng</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-right pr-4">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($promotions as $item)
                            <tr>
                                <td class="pl-4 align-middle">
                                    <div class="d-flex align-items-center">
                                        <code class="p-2 bg-light border rounded text-primary font-weight-bold" id="code-{{ $item->promotionid }}" style="font-size: 1.1rem;">{{ $item->code }}</code>
                                        <button class="btn btn-xs btn-link text-muted ml-2" onclick="copyToClipboard('code-{{ $item->promotionid }}')" title="Copy mã">
                                            <i class="far fa-copy"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <span class="h5 text-danger font-weight-bold">-{{ $item->discount_percent }}%</span>
                                </td>
                                <td class="align-middle">
                                    <div class="small">
                                        <span class="text-muted">Bắt đầu:</span> <b>{{ \Carbon\Carbon::parse($item->startdate)->format('d/m/Y') }}</b><br>
                                        <span class="text-muted">Kết thúc:</span> <b class="text-danger">{{ \Carbon\Carbon::parse($item->enddate)->format('d/m/Y') }}</b>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="font-weight-bold">Còn: {{ $item->quantity }} lượt</small>
                                    </div>
                                    <div class="progress progress-xxs shadow-sm">
                                        @php 
                                            // Giả định bạn có tổng lượt ban đầu, nếu không ta dùng màu sắc cảnh báo
                                            $color = $item->quantity > 10 ? 'bg-success' : ($item->quantity > 0 ? 'bg-warning' : 'bg-danger');
                                            $width = $item->quantity > 0 ? '100%' : '0%';
                                        @endphp
                                        <div class="progress-bar {{ $color }}" style="width: {{ $width }}"></div>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    @php $now = \Carbon\Carbon::now(); @endphp
                                    @if($item->quantity <= 0)
                                        <span class="badge badge-pill badge-danger">Hết lượt dùng</span>
                                    @elseif($now->lt($item->startdate))
                                        <span class="badge badge-pill badge-warning text-white">Lên lịch</span>
                                    @elseif($now->gt($item->enddate))
                                        <span class="badge badge-pill badge-secondary">Hết hạn</span>
                                    @else
                                        <span class="badge badge-pill badge-success shadow-sm">Đang chạy</span>
                                    @endif
                                </td>
                                <td class="text-right pr-4 align-middle">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal{{ $item->promotionid }}" title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.promotions.destroy', $item->promotionid) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa mã này sẽ ảnh hưởng đến lịch sử đơn hàng. Bạn chắc chứ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger ml-1" title="Xóa mã">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- MODAL EDIT --}}
                            <div class="modal fade" id="editModal{{ $item->promotionid }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content shadow-lg border-0">
                                        <form action="{{ route('admin.promotions.update', $item->promotionid) }}" method="POST">
                                            @csrf
                                            <div class="modal-header bg-warning">
                                                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit"></i> Cập nhật Mã: {{ $item->code }}</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Mã khuyến mãi</label>
                                                    <input type="text" name="code" class="form-control font-weight-bold" value="{{ $item->code }}" required style="text-transform: uppercase;">
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label>Giảm (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" name="discount_percent" class="form-control text-danger font-weight-bold" value="{{ $item->discount_percent }}" min="1" max="100" required>
                                                            <div class="input-group-append"><span class="input-group-text">%</span></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>Số lượng cấp mới</label>
                                                        <input type="number" name="quantity" class="form-control" value="{{ $item->quantity }}" min="0" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label>Từ ngày</label>
                                                        <input type="date" name="startdate" class="form-control" value="{{ \Carbon\Carbon::parse($item->startdate)->format('Y-m-d') }}" required>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>Đến ngày</label>
                                                        <input type="date" name="enddate" class="form-control" value="{{ \Carbon\Carbon::parse($item->enddate)->format('Y-m-d') }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                                <button type="submit" class="btn btn-primary">Xác nhận Lưu</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486747.png" width="80" class="opacity-50 mb-3"><br>
                                    <span class="text-muted">Chưa có mã giảm giá nào trong hệ thống.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="float-right">
                {{ $promotions->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

{{-- MODAL THÊM MỚI --}}
<div class="modal fade" id="addPromotionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <form action="{{ route('admin.promotions.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle"></i> Thêm Chiến Dịch Khuyến Mãi</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Mã Code (Gợi ý: {{ strtoupper(Str::random(8)) }})</label>
                        <input type="text" name="code" class="form-control font-weight-bold" placeholder="VD: GIAMGIA2026" style="text-transform: uppercase;" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Phần trăm giảm</label>
                            <div class="input-group input-group-lg">
                                <input type="number" name="discount_percent" class="form-control text-primary font-weight-bold" placeholder="10" min="1" max="100" required>
                                <div class="input-group-append"><span class="input-group-text">%</span></div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tổng lượt dùng</label>
                            <input type="number" name="quantity" class="form-control form-control-lg" placeholder="100" min="1" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Ngày kích hoạt</label>
                            <input type="date" name="startdate" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Ngày hết hạn</label>
                            <input type="date" name="enddate" class="form-control" value="{{ date('Y-m-d', strtotime('+30 days')) }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-link text-muted" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary px-4 shadow">Kích hoạt mã ngay</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    // Hàm copy mã code vào clipboard
    function copyToClipboard(elementId) {
        const text = document.getElementById(elementId).innerText;
        navigator.clipboard.writeText(text).then(() => {
            toastr.success('Đã copy mã: ' + text);
        }).catch(err => {
            console.error('Lỗi khi copy: ', err);
        });
    }

    // Hiển thị thông báo khi có lỗi từ backend
    @if($errors->any())
        @foreach($errors->all() as $error)
            toastr.error('{{ $error }}');
        @endforeach
    @endif
</script>
@stop

@section('css')
<style>
    .table td, .table th { vertical-align: middle !important; }
    .progress-xxs { height: 6px; border-radius: 10px; }
    .badge-pill { padding-right: .6em; padding-left: .6em; border-radius: 10rem; }
    .card-outline.card-primary { border-top: 3px solid #007bff; }
    .btn-group .btn { border-radius: 6px; margin: 0 2px; }
    .info-box { min-height: 80px; }
</style>
@stop