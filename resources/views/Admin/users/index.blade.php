@extends('adminlte::page')

@section('title', 'Quản lý Người dùng | GoViet Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark font-weight-bold">
                    <i class="fas fa-users-cog text-info mr-2"></i>Quản lý Người dùng
                </h1>
                <p class="text-muted mb-0">Theo dõi, phân quyền và kiểm soát truy cập hệ thống.</p>
            </div>
            <div class="col-sm-6 text-right">
                <button class="btn btn-info shadow-sm px-4" data-toggle="modal" data-target="#modalAddUser">
                    <i class="fas fa-user-plus mr-1"></i> Thêm tài khoản
                </button>
            </div>
        </div>

        {{-- Widgets Thống kê nhanh --}}
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-sm border-0">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted">Tổng User</span>
                        <span class="info-box-number text-lg">{{ $users->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-sm border-0">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted">Đang hoạt động</span>
                        <span class="info-box-number text-lg">{{ $users->where('status', 1)->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-sm border-0">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-shield text-white"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted">Quản trị viên</span>
                        <span class="info-box-number text-lg text-warning">{{ $users->where('role', 1)->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-sm border-0">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-slash"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted">Bị khóa</span>
                        <span class="info-box-number text-lg">{{ $users->where('status', 0)->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
    <div class="card-header bg-white py-3 border-bottom-0">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold m-0 text-secondary">
                <i class="fas fa-list-ul mr-2"></i>Danh sách tài khoản
            </h3>
            <div class="card-tools">
                <div class="input-group input-group-sm bg-light rounded" style="width: 280px; padding: 2px;">
                    <input type="text" id="tableSearch" class="form-control border-0 bg-transparent" placeholder="Tìm tên, email, SĐT...">
                    <div class="input-group-append">
                        <button class="btn btn-white text-muted"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="userTable">
                <thead class="bg-light text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                    <tr>
                        <th class="text-center" width="60">#ID</th>
                        <th width="250">Người dùng</th>
                        <th>Thông tin liên hệ</th>
                        <th class="text-center">Nguồn đăng nhập</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-right" width="220">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="text-center font-weight-bold text-muted small">{{ $user->userid }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @php
                                    $avatarUrl = $user->avatar 
                                        ? asset('uploads/avatar/'.$user->avatar) 
                                        : 'https://ui-avatars.com/api/?name='.urlencode($user->username).'&background=4CBEE1&color=fff&bold=true';
                                @endphp
                                <img src="{{ $avatarUrl }}" class="rounded-circle mr-3 shadow-sm border border-white" width="42" height="42">
                                <div>
                                    <div class="font-weight-bold text-dark mb-0">{{ $user->username }}</div>
                                    @if($user->role == 1)
                                        <span class="text-xs text-info font-weight-bold"><i class="fas fa-shield-alt mr-1"></i>Quản trị viên</span>
                                    @else
                                        <span class="text-xs text-muted"><i class="fas fa-user mr-1"></i>Khách hàng</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="small">
                            <div class="mb-1"><i class="far fa-envelope text-info mr-2"></i>{{ $user->email }}</div>
                            <div class="text-muted"><i class="fas fa-phone-alt text-info mr-2"></i>{{ $user->phoneNumber ?? 'Chưa cập nhật' }}</div>
                        </td>
                        <td class="text-center">
                            @if($user->provider == 'google')
                                <span class="badge badge-light border text-danger px-2 py-1"><i class="fab fa-google mr-1"></i> Google</span>
                            @elseif($user->provider == 'facebook')
                                <span class="badge badge-light border text-primary px-2 py-1"><i class="fab fa-facebook mr-1"></i> Facebook</span>
                            @else
                                <span class="badge badge-light border text-muted px-2 py-1"><i class="fas fa-laptop-code mr-1"></i> Hệ thống</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($user->status == 1)
                                <span class="badge bg-success-soft text-success px-3 py-2" style="border-radius: 30px;">
                                    <i class="fas fa-check-circle mr-1"></i> Hoạt động
                                </span>
                            @else
                                <span class="badge bg-danger-soft text-danger px-3 py-2" style="border-radius: 30px;">
                                    <i class="fas fa-ban mr-1"></i> Đã khóa
                                </span>
                            @endif
                        </td>
<td class="text-right pr-3">
    <div class="btn-group shadow-sm" style="border-radius: 6px; overflow: hidden;">
        
        {{-- NÚT VÀO TRANG SHOW (Hồ sơ chi tiết) --}}
        <a href="{{ route('admin.users.show', $user->userid) }}" 
           class="btn btn-sm btn-white border-right" 
           title="Xem chi tiết hồ sơ">
            <i class="fas fa-eye text-primary"></i>
        </a>

        {{-- Logic Cấp/Hủy quyền Admin --}}
        @if($user->role == 0)
            <a href="{{ route('admin.users.makeAdmin', $user->userid) }}" 
               class="btn btn-sm btn-white border-right" 
               title="Nâng cấp lên Quản trị viên"
               onclick="return confirm('Xác nhận cấp quyền Quản trị viên cho {{ $user->username }}?')">
                <i class="fas fa-user-shield text-info"></i>
            </a>
        @else
            @if(Auth::check() && Auth::user()->userid != $user->userid)
                <a href="{{ route('admin.users.removeAdmin', $user->userid) }}" 
                   class="btn btn-sm btn-white border-right" 
                   title="Gỡ quyền Quản trị viên"
                   style="background-color: #fff5f5;"
                   onclick="return confirm('Hạ quyền Admin của {{ $user->username }} xuống Thành viên thường?')">
                    <i class="fas fa-user-minus text-danger"></i>
                </a>
            @else
                <button class="btn btn-sm btn-white border-right disabled" title="Bạn không thể tự gỡ quyền của chính mình">
                    <i class="fas fa-user-check text-muted"></i>
                </button>
            @endif
        @endif

        {{-- Nút Khóa/Mở tài khoản --}}
        @if($user->status == 1)
            <a href="{{ route('admin.users.toggleStatus', $user->userid) }}" 
               class="btn btn-sm btn-white border-right" title="Khóa tài khoản"
               onclick="return confirm('Tài khoản này sẽ không thể đăng nhập. Tiếp tục?')">
                <i class="fas fa-lock text-warning"></i>
            </a>
        @else
            <a href="{{ route('admin.users.toggleStatus', $user->userid) }}" 
               class="btn btn-sm btn-white border-right" title="Mở khóa">
                <i class="fas fa-unlock text-success"></i>
            </a>
        @endif

        {{-- Nút Xóa vĩnh viễn --}}
        <a href="{{ route('admin.users.delete', $user->userid) }}" 
           class="btn btn-sm btn-white" 
           title="Xóa vĩnh viễn"
           onclick="return confirm('Dữ liệu liên quan đến người dùng này sẽ bị mất vĩnh viễn. Tiếp tục?')">
            <i class="fas fa-trash-alt text-danger"></i>
        </a>
    </div>
</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    /* Nền màu nhạt cho Badge */
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
    
    /* Tinh chỉnh Table */
    .table td { vertical-align: middle !important; border-top: 1px solid #f4f6f9; transition: background 0.2s; }
    #userTable tbody tr:hover { background-color: rgba(76, 190, 225, 0.03); }
    .btn-white { background-color: #fff; color: #444; }
    .btn-white:hover { background-color: #f8f9fa; }
    
    /* Widget shadow */
    .info-box { transition: transform 0.2s ease; }
    .info-box:hover { transform: translateY(-3px); }
</style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Tìm kiếm nhanh Real-time
        $("#tableSearch").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#userTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Tự động ẩn thông báo
        setTimeout(function() {
            $(".alert").slideUp(500);
        }, 3000);
    });
</script>
@stop