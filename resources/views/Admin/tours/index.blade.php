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
                                
                                <td class="text-center align-middle">
                                    <div class="btn-group shadow-sm">
                                        <a href="{{ route('admin.tours.edit', $tour->tourid) }}" class="btn btn-sm btn-info" title="Sửa Lịch trình & Thông tin">
                                            <i class="fas fa-edit mr-1"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.tours.delete', $tour->tourid) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa vĩnh viễn Tour này không?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger border-left" style="border-radius: 0 0.2rem 0.2rem 0;">
                                                <i class="fas fa-trash"></i>
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
    <style>
        /* Tùy chỉnh Table */
        .custom-table thead th {
            border: none;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            padding: 15px;
        }
        .custom-table tbody tr { transition: all 0.2s; }
        .custom-table tbody tr:hover { background-color: rgba(0,123,255,0.05) !important; }
        
        /* Tour Image */
        .tour-img-wrapper {
            width: 80px;
            height: 55px;
            overflow: hidden;
            display: inline-block;
            background: #eee;
        }
        .tour-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* Badge UI */
        .badge { font-weight: 500; }
        .badge-outline-primary { color: #007bff; border-color: #007bff; background: transparent; }
        
        /* Title styling */
        .tour-title-link {
            font-size: 1rem;
            display: block;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 400px;
        }
        
        /* Price tag */
        .price-tag .text-danger { letter-spacing: -0.5px; }

        /* Animation */
        tbody tr { animation: fadeIn 0.5s ease; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@stop

@section('js')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            
            // Auto close alert
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 4000);
        });
    </script>
@stop