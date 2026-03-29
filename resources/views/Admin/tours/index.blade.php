@extends('adminlte::page')

@section('title', 'Quản lý Tour - GoViet')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark font-weight-bold">
                    <i class="fas fa-globe-asia text-primary mr-2"></i>HỆ THỐNG QUẢN LÝ TOUR
                </h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.tours.create') }}" class="btn btn-success shadow">
                    <i class="fas fa-plus-circle"></i> Thêm Tour Mới
                </a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        {{-- 1. Thống kê nhanh (Widgets) --}}
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-map-marked-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Tổng số Tour</span>
                        <span class="info-box-number">{{ $tours->total() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Đang mở bán</span>
                        <span class="info-box-number">
                            {{-- Giả sử bạn có biến thống kê từ controller truyền qua --}}
                            {{ $tours->where('availability', 1)->count() }} 
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-calendar-day"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Khởi hành sắp tới</span>
                        <span class="info-box-number">Mới</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-exclamation-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Hết chỗ/Tạm ngưng</span>
                        <span class="info-box-number">{{ $tours->where('availability', 0)->count() }}</span>
                    </div>
                </div>
            </div>
        </div>


        {{-- 3. Bộ lọc tìm kiếm nâng cao --}}
        <div class="card card-outline card-primary shadow">
            <div class="card-header">
                <h3 class="card-title text-bold"><i class="fas fa-search-location mr-1"></i> Bộ lọc nâng cao</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body bg-light">
                <form action="{{ route('admin.tours.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="small text-bold">Từ khóa</label>
                            <div class="input-group">
                                <input type="text" name="keyword" class="form-control" placeholder="Tên tour, điểm đến hoặc ID..." value="{{ request('keyword') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="small text-bold">Vùng miền</label>
                            <select name="domain" class="form-control select2">
                                <option value="">-- Tất cả --</option>
                                <option value="b" {{ request('domain') == 'b' ? 'selected' : '' }}>Miền Bắc</option>
                                <option value="t" {{ request('domain') == 't' ? 'selected' : '' }}>Miền Trung</option>
                                <option value="n" {{ request('domain') == 'n' ? 'selected' : '' }}>Miền Nam</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="small text-bold">Trạng thái</label>
                            <select name="availability" class="form-control">
                                <option value="">-- Tất cả --</option>
                                <option value="1" {{ request('availability') == '1' ? 'selected' : '' }}>Đang mở bán</option>
                                <option value="0" {{ request('availability') == '0' ? 'selected' : '' }}>Tạm ngưng</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary w-100 mr-1 shadow-sm"><i class="fas fa-filter"></i></button>
                                <a href="{{ route('admin.tours.index') }}" class="btn btn-secondary shadow-sm"><i class="fas fa-undo"></i></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- 4. Bảng danh sách --}}
        <div class="card shadow border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 custom-table">
                        <thead class="bg-dark">
                            <tr>
                                <th class="text-center" width="50px">ID</th>
                                <th width="100px">Hình ảnh</th>
                                <th>Thông tin Tour</th>
                                <th class="text-center" width="180px">Giá (VND)</th>
                                <th class="text-center" width="180px">Đợt khởi hành</th>
                                <th class="text-center" width="150px">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tours as $tour)
                            @php
                                $upcomingSchedules = $tour->schedules->where('startdate', '>=', now()->toDateString())->sortBy('startdate');
                                $nextSch = $upcomingSchedules->first();
                                $minPrice = $upcomingSchedules->min('priceadult');
                            @endphp
                            <tr>
                                <td class="text-center align-middle font-weight-bold text-muted">#{{ $tour->tourid }}</td>
                                
                                <td class="text-center align-middle p-2">
                                    <div class="tour-img-wrapper shadow-sm border">
                                        <img src="{{ asset('clients/assets/images/gallery-tours/' . ($tour->images ?? 'default.jpg')) }}" 
                                             class="img-fluid rounded" alt="Tour image">
                                    </div>
                                </td>
                                
                                <td class="align-middle">
                                    <h6 class="mb-1 font-weight-bold text-primary tour-title-link">{{ $tour->title }}</h6>
                                    <div class="d-flex flex-wrap align-items-center mb-1">
                                        <span class="mr-3 text-sm text-muted"><i class="fas fa-map-pin text-danger mr-1"></i>{{ $tour->destination }}</span>
                                        <span class="mr-3 text-sm text-muted"><i class="far fa-clock text-info mr-1"></i>{{ $tour->duration }}</span>
                                    </div>
                                    <div class="badges-row">
                                        @if($tour->domain == 'b') <span class="badge badge-success">Miền Bắc</span>
                                        @elseif($tour->domain == 't') <span class="badge badge-warning text-dark">Miền Trung</span>
                                        @elseif($tour->domain == 'n') <span class="badge badge-info">Miền Nam</span>
                                        @endif
                                        <span class="badge badge-light border">{{ $tour->time }}</span>
                                        
                                        @if($tour->availability == 1)
                                            <span class="badge badge-pill badge-success ml-1"><i class="fas fa-check-circle mr-1"></i>Active</span>
                                        @else
                                            <span class="badge badge-pill badge-danger ml-1"><i class="fas fa-pause mr-1"></i>Inactive</span>
                                        @endif
                                    </div>
                                </td>
                                
                                <td class="text-center align-middle">
                                    @if($minPrice)
                                        <div class="price-tag">
                                            <span class="small text-muted d-block">Chỉ từ</span>
                                            <span class="text-danger font-weight-bold h5 mb-0">{{ number_format($minPrice, 0, ',', '.') }}</span>
                                            <span class="text-xs font-weight-normal text-muted">VND</span>
                                        </div>
                                    @else
                                        <span class="badge badge-light border text-muted px-3 py-2">Liên hệ để cập nhật</span>
                                    @endif
                                </td>
                                
                                <td class="text-center align-middle">
                                    @if($nextSch)
                                        <div class="departure-box">
                                            <span class="badge badge-outline-primary text-primary border border-primary px-2 mb-1">
                                                <i class="far fa-calendar-alt mr-1"></i> {{ date('d/m/Y', strtotime($nextSch->startdate)) }}
                                            </span>
                                            <div class="text-xs text-muted">Còn <b>{{ $upcomingSchedules->count() }}</b> đợt sắp tới</div>
                                        </div>
                                    @else
                                        <span class="text-sm text-muted italic">Chưa có lịch khởi hành</span>
                                    @endif
                                </td>
                                
                                <td class="text-center align-middle action-column">
    {{-- Khối trạng thái --}}
    <div class="status-wrapper mb-3">
        <div class="custom-control custom-switch ios-switch">
            <input type="checkbox" class="custom-control-input toggle-availability" 
                   id="status-{{ $tour->tourid }}" 
                   data-id="{{ $tour->tourid }}" 
                   {{ $tour->availability == 1 ? 'checked' : '' }}>
            <label class="custom-control-label" for="status-{{ $tour->tourid }}">
                <span class="status-text {{ $tour->availability == 1 ? 'text-success' : 'text-danger' }}" id="label-{{ $tour->tourid }}">
                    {{ $tour->availability == 1 ? 'Đang mở bán' : 'Tạm ngưng' }}
                </span>
            </label>
        </div>
    </div>

    {{-- Khối nút bấm --}}
    <div class="action-buttons">
        <a href="{{ route('admin.tours.edit', $tour->tourid) }}" class="btn btn-edit-tour" title="Chỉnh sửa">
            <i class="fas fa-edit"></i>
        </a>
        <form action="{{ route('admin.tours.delete', $tour->tourid) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-delete-tour" onclick="return confirm('Bạn có chắc muốn xóa?')">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    </div>
</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <img src="{{ asset('admin_assets/img/empty.svg') }}" style="width: 150px; opacity: 0.5;" class="mb-3">
                                    <h5 class="text-muted">Không tìm thấy tour nào phù hợp!</h5>
                                    <a href="{{ route('admin.tours.create') }}" class="btn btn-primary btn-sm mt-2">Tạo mới ngay</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($tours->hasPages())
            <div class="card-footer bg-white border-top">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="small text-muted">
                        Đang hiển thị từ <b>{{ $tours->firstItem() }}</b> đến <b>{{ $tours->lastItem() }}</b> trong tổng số <b>{{ $tours->total() }}</b> kết quả.
                    </div>
                    <div>
                        {{ $tours->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@stop
@section('css')
    @section('css')
<style>
    /* Fix lỗi đè chữ và căn chỉnh cột Thao tác */
    .action-column {
        min-width: 160px;
        padding: 20px 10px !important;
    }

    /* Tùy chỉnh Switch kiểu iOS (iOS Style Switch) */
    .ios-switch {
        padding-left: 3.5rem !important; /* Tạo khoảng trống bên trái cho nút gạt */
        display: inline-block;
        text-align: left;
    }

    .ios-switch .custom-control-label {
        padding-top: 2px;
        cursor: pointer;
        user-select: none;
    }

    /* Thanh ray của nút gạt */
    .ios-switch .custom-control-label::before {
        left: -3.5rem !important;
        width: 2.8rem;
        height: 1.5rem;
        background-color: #e9ecef;
        border: none !important;
        border-radius: 50rem;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
        transition: background-color 0.3s ease;
    }

    /* Nút tròn di chuyển */
    .ios-switch .custom-control-label::after {
        left: calc(-3.5rem + 2px) !important;
        width: calc(1.5rem - 4px);
        height: calc(1.5rem - 4px);
        background-color: #fff;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        transition: transform 0.3s ease;
    }

    /* Khi ở trạng thái ON */
    .ios-switch .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #28a745;
    }

    .ios-switch .custom-control-input:checked ~ .custom-control-label::after {
        transform: translateX(1.3rem);
    }

    /* Text trạng thái */
    .status-text {
        font-size: 0.85rem;
        font-weight: 700;
        margin-left: 5px;
        display: inline-block;
        min-width: 80px;
    }

    /* Style cho các nút Sửa/Xóa */
    .action-buttons .btn {
        width: 38px;
        height: 38px;
        padding: 0;
        line-height: 38px;
        border-radius: 8px;
        margin: 0 3px;
        transition: all 0.2s;
        border: 1px solid #eee;
        background: #fff;
    }

    .btn-edit-tour { color: #17a2b8; }
    .btn-edit-tour:hover { background: #17a2b8 !important; color: #fff !important; transform: translateY(-2px); }

    .btn-delete-tour { color: #dc3545; }
    .btn-delete-tour:hover { background: #dc3545 !important; color: #fff !important; transform: translateY(-2px); }
</style>
@stop


@section('js')
    @section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function () {
            // 1. Xử lý nút gạt Bật/Tắt
            $('.toggle-availability').change(function() {
                let status = $(this).prop('checked') ? 1 : 0;
                let tourId = $(this).data('id');
                let label = $('#label-' + tourId);
                let checkbox = $(this);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('admin.tours.toggle') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'status': status,
                        'id': tourId
                    },
                    success: function(data) {
                        // Cập nhật nhãn chữ
                        if(status == 1) {
                            label.text('Đang mở bán').removeClass('text-danger').addClass('text-success');
                        } else {
                            label.text('Tạm ngưng').removeClass('text-success').addClass('text-danger');
                        }
                        
                        // Hiện thông báo Toast xịn
                        Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000
                        }).fire({
                            icon: 'success',
                            title: data.message
                        });
                    },
                    error: function() {
                        // Nếu lỗi thì gạt ngược nút lại và báo lỗi
                        checkbox.prop('checked', !checkbox.prop('checked'));
                        alert('Không thể kết nối đến máy chủ!');
                    }
                });
            });

            // 2. Tooltip & Auto close alert cũ của bạn
            $('[data-toggle="tooltip"]').tooltip();
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 4000);
        });
    </script>
@stop