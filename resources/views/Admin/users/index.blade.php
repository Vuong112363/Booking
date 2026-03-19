@extends('adminlte::page')

@section('title', 'Quản lý Người dùng')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-users-cog mr-2"></i>Quản lý Người dùng</h1>
            </div>
            <div class="col-sm-6 text-right">
                <button class="btn btn-primary shadow-sm"><i class="fas fa-plus-circle"></i> Thêm User mới</button>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="card card-outline card-primary shadow-lg" style="border-radius: 15px;">
    <div class="card-header border-0">
        <h3 class="card-title text-bold">Danh sách tài khoản</h3>
        <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 200px;">
                <input type="text" name="table_search" class="form-control float-right" placeholder="Tìm kiếm...">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="text-center" width="60">ID</th>
                        <th width="80">Avatar</th>
                        <th>Người dùng</th>
                        <th>Thông tin liên lạc</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center" width="180">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="text-center text-bold text-muted">{{ $user->userid }}</td>
                        <td class="text-center">
                            @php
                                $avatarUrl = $user->avatar 
                                    ? asset('uploads/avatar/'.$user->avatar) 
                                    : 'https://ui-avatars.com/api/?name='.urlencode($user->username).'&background=random&color=fff';
                            @endphp
                            <img src="{{ $avatarUrl }}" 
                                 alt="User" 
                                 class="img-circle elevation-2 border border-white" 
                                 width="45" height="45">
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="text-bold text-dark">{{ $user->username }}</span>
                                <small class="text-muted text-uppercase" style="font-size: 0.7rem;">
                                    <i class="fas fa-shield-alt text-info"></i> 
                                    {{ $user->role == 1 ? 'Quản trị viên' : 'Thành viên' }}
                                </small>
                            </div>
                        </td>
                        <td>
                            <div class="small"><i class="fas fa-envelope text-muted mr-1"></i> {{ $user->email }}</div>
                            <div class="small text-primary"><i class="fas fa-phone text-muted mr-1"></i> {{ $user->phoneNumber ?? 'N/A' }}</div>
                        </td>
                        <td class="text-center">
                            @if($user->status == 1)
                                <span class="badge badge-success shadow-sm px-3 py-2" style="border-radius: 20px;">
                                    <i class="fas fa-check-circle mr-1"></i> Active
                                </span>
                            @else
                                <span class="badge badge-danger shadow-sm px-3 py-2" style="border-radius: 20px;">
                                    <i class="fas fa-ban mr-1"></i> Blocked
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                @if($user->status == 1)
                                    <a href="{{ route('admin.users.block', $user->userid) }}" 
                                       class="btn btn-sm btn-outline-warning border-0" 
                                       title="Khóa User" 
                                       onclick="return confirm('Bạn có chắc chắn muốn khóa tài khoản này?')">
                                        <i class="fas fa-user-lock"></i> Khóa
                                    </a>
                                @else
                                    <a href="{{ route('admin.users.active', $user->userid) }}" 
                                       class="btn btn-sm btn-outline-success border-0" 
                                       title="Mở khóa">
                                        <i class="fas fa-user-check"></i> Mở
                                    </a>
                                @endif
                                        {{-- Cấp / gỡ quyền admin --}}
        @if($user->role == 0)
            <a href="{{ route('admin.users.makeAdmin', $user->userid) }}"
               class="btn btn-sm btn-outline-primary border-0"
               onclick="return confirm('Cấp quyền admin cho user này?')">
                <i class="fas fa-user-shield"></i> Admin
            </a>
        @else
            <a href="{{ route('admin.users.removeAdmin', $user->userid) }}"
               class="btn btn-sm btn-outline-secondary border-0"
               onclick="return confirm('Thu hồi quyền admin?')">
                <i class="fas fa-user-minus"></i> Gỡ
            </a>
        @endif
                                <a href="{{ route('admin.users.delete', $user->userid) }}" 
                                   class="btn btn-sm btn-outline-danger border-0" 
                                   title="Xóa vĩnh viễn" 
                                   onclick="return confirm('Hành động này không thể hoàn tác. Tiếp tục xóa?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card-footer bg-white border-0 py-3">
        <div class="float-right">
            {{-- Chỗ này để code phân trang nếu bạn dùng $users->links() --}}
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    /* Làm mượt bảng và bo góc card */
    .table td, .table th { vertical-align: middle !important; }
    .card { transition: transform 0.2s; }
    .btn-group .btn { padding: 0.4rem 0.8rem; }
    .btn-group .btn:hover { background-color: #f8f9fa; transform: scale(1.05); transition: 0.2s; }
    
    /* Hiệu ứng sọc bảng nhẹ nhàng hơn */
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0,0,0,.02);
    }
</style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Tự động ẩn thông báo sau 3 giây
        setTimeout(function() {
            $(".alert").fadeOut('slow');
        }, 3000);
    });
</script>
@stop