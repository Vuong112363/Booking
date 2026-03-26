@extends('adminlte::page')

@section('title', 'Hệ thống Quản lý Đánh giá')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-dark font-weight-bold"><i class="fas fa-star-half-alt mr-2 text-warning"></i>Quản Lý Đánh Giá & Phản Hồi</h1>
    </div>
@stop

@section('content')
<div class="container-fluid">
    {{-- 1. THỐNG KÊ NHANH --}}
    <div class="row">
        <div class="col-md-3">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-warning text-white"><i class="fas fa-star"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Điểm trung bình</span>
                    <span class="info-box-number" style="font-size: 1.5rem;">{{ number_format($reviews->avg('rating'), 1) }} / 5.0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-info"><i class="fas fa-comments"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Tổng đánh giá</span>
                    <span class="info-box-number">{{ $reviews->total() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-danger"><i class="fas fa-comment-slash"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Chưa phản hồi</span>
                    <span class="info-box-number">{{ $reviews->where('admin_reply', null)->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-success"><i class="fas fa-user-check"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Đang hiển thị</span>
                    <span class="info-box-number">{{ $reviews->where('status', 1)->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. BỘ LỌC & DANH SÁCH --}}
    <div class="card card-outline card-warning shadow-lg">
        <div class="card-header bg-white">
            <h3 class="card-title text-bold"><i class="fas fa-filter mr-1"></i> Bộ lọc danh sách</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        
        <div class="card-body">
            {{-- Form tìm kiếm/lọc --}}
            <form action="" method="GET" class="row mb-4">
                <div class="col-md-3">
                    <select name="rating" class="form-control">
                        <option value="">-- Lọc theo số sao --</option>
                        <option value="5">⭐⭐⭐⭐⭐ (5 sao)</option>
                        <option value="4">⭐⭐⭐⭐ (4 sao)</option>
                        <option value="3">⭐⭐⭐ (3 sao)</option>
                        <option value="2">⭐⭐ (2 sao)</option>
                        <option value="1">⭐ (1 sao)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">-- Trạng thái hiển thị --</option>
                        <option value="1">Đang hiện</option>
                        <option value="0">Đang ẩn</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i> Lọc</button>
                </div>
            </form>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-3">
                    <i class="icon fas fa-check"></i> {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover border-bottom mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0">ID</th>
                            <th class="border-0">Người dùng</th>
                            <th class="border-0">Tour du lịch</th>
                            <th class="border-0">Nội dung đánh giá</th>
                            <th class="border-0">Phản hồi của bạn</th>
                            <th class="border-0 text-center">Hiển thị</th>
                            <th class="border-0 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $item)
                            <tr>
                                <td class="align-middle">#{{ $item->reviewid }}</td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-40 mr-3">
                                            <img src="{{ asset('clients/assets/images/avatars/' . ($item->user->avatar ?? 'default-user.png')) }}" 
                                                 class="rounded-circle shadow-sm" width="40" height="40" style="object-fit: cover;">
                                        </div>
                                        <div>
                                            <span class="font-weight-bold d-block text-dark">{{ $item->user->name ?? $item->user->username ?? 'Khách' }}</span>
                                            <small class="text-muted"><i class="far fa-clock mr-1"></i>{{ \Carbon\Carbon::parse($item->createdat)->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <a href="#" class="text-primary font-weight-500 text-truncate-2" style="max-width: 150px; display: block;">
                                        {{ $item->tour->title ?? 'Tour không tồn tại' }}
                                    </a>
                                </td>
                                <td class="align-middle">
                                    <div class="rating-stars mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $item->rating ? 'fas' : 'far' }} fa-star text-warning small"></i>
                                        @endfor
                                    </div>
                                    <p class="mb-0 text-muted italic" style="max-width: 250px; line-height: 1.4;">"{{ $item->comment }}"</p>
                                </td>
                                <td class="align-middle">
                                    @if($item->admin_reply)
                                        <div class="p-2 rounded bg-light border-left border-primary" style="font-size: 0.85rem; max-width: 200px;">
                                            <i class="fas fa-user-shield text-primary mr-1"></i> {{ $item->admin_reply }}
                                        </div>
                                    @else
                                        <span class="badge badge-pill badge-secondary px-3">Chờ phản hồi</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <form action="{{ route('admin.reviews.toggle', $item->reviewid) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-flat {{ $item->status == 1 ? 'text-success' : 'text-danger' }}" title="Bấm để Thay đổi">
                                            <i class="fas {{ $item->status == 1 ? 'fa-toggle-on' : 'fa-toggle-off' }} fa-2x"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="text-right align-middle pr-3">
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" data-toggle="modal" data-target="#replyModal{{ $item->reviewid }}">
                                        <i class="fas fa-pen-nib mr-1"></i> Phản hồi
                                    </button>
                                </td>
                            </tr>

                            {{-- MODAL PHẢN HỒI --}}
                            <div class="modal fade" id="replyModal{{ $item->reviewid }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content shadow-lg border-0">
                                        <form action="{{ route('admin.reviews.reply', $item->reviewid) }}" method="POST">
                                            @csrf
                                            <div class="modal-header bg-warning text-white">
                                                <h5 class="modal-title font-weight-bold">Trả lời khách hàng: {{ $item->user->username }}</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body bg-light">
                                                <div class="card card-body border-0 shadow-none mb-3">
                                                    <span class="text-muted small">Khách hàng đánh giá {{ $item->rating }} sao:</span>
                                                    <p class="font-weight-bold mt-1">"{{ $item->comment }}"</p>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-primary"><i class="fas fa-reply-all mr-1"></i> Nội dung phản hồi của Admin:</label>
                                                    <textarea name="admin_reply" class="form-control border-primary" rows="5" placeholder="Cảm ơn khách hàng hoặc giải đáp thắc mắc..." required>{{ $item->admin_reply }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-white">
                                                <button type="button" class="btn btn-link text-muted" data-dismiss="modal">Hủy bỏ</button>
                                                <button type="submit" class="btn btn-primary px-4 shadow">Gửi phản hồi ngay</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/1358/1358023.png" width="80" class="opacity-50 mb-3"><br>
                                    <span class="text-muted">Chưa nhận được đánh giá nào từ khách hàng.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top">
            <div class="float-right">
                {{ $reviews->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        .table td { vertical-align: middle !important; }
        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .italic { font-style: italic; }
        .bg-red-light { background-color: #fff5f5 !important; }
        .badge-pill { padding: 0.4em 1em; }
        .info-box { min-height: 90px; border-radius: 12px; }
    </style>
@stop