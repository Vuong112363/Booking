@extends('adminlte::page')

@section('title', 'Chi tiết người dùng | GoViet Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-id-card mr-2 text-info"></i>Hồ sơ người dùng</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Quản lý User</a></li>
                    <li class="breadcrumb-item active">Chi tiết</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- CỘT TRÁI: THÔNG TIN CƠ BẢN --}}
        <div class="col-md-3">
            <div class="card card-info card-outline shadow-sm">
                <div class="card-body box-profile">
                    <div class="text-center">
                        @php
                            $avatarUrl = $user->avatar 
                                ? asset('clients/assets/images/avatars/'.$user->avatar)
                                : 'https://ui-avatars.com/api/?name='.urlencode($user->username).'&background=4CBEE1&color=fff&size=128';
                        @endphp
                        <img class="profile-user-img img-fluid img-circle border-info"
                             src="{{ $avatarUrl }}" alt="User profile picture" style="width: 100px; height: 100px; object-fit: cover;">
                    </div>

                    <h3 class="profile-username text-center font-weight-bold mt-3">{{ $user->username }}</h3>
                    <p class="text-muted text-center mb-1">
                        @if($user->role == 1)
                            <span class="badge badge-info"><i class="fas fa-shield-alt mr-1"></i>Quản trị viên</span>
                        @else
                            <span class="badge badge-secondary">Thành viên</span>
                        @endif
                    </p>
                    <p class="text-center small text-muted">ID: #{{ $user->userid }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item border-top-0">
                            <b>Tổng Tour đã đặt</b> <a class="float-right text-info font-weight-bold">{{ count($bookings) }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Đánh giá gửi đi</b> <a class="float-right text-info font-weight-bold">{{ count($reviews) }}</a>
                        </li>
                        <li class="list-group-item border-bottom-0">
                            <b>Trạng thái</b> 
                            <span class="float-right">
                                {!! $user->status == 1 
                                    ? '<span class="text-success"><i class="fas fa-check-circle"></i> Active</span>' 
                                    : '<span class="text-danger"><i class="fas fa-ban"></i> Blocked</span>' 
                                !!}
                            </span>
                        </li>
                    </ul>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-default btn-sm">Quay lại</a>
                        <button class="btn btn-info btn-sm shadow-sm px-3" data-toggle="modal" data-target="#modalEdit">Sửa hồ sơ</button>
                    </div>
                </div>
            </div>

            {{-- CARD THÔNG TIN THÊM --}}
            <div class="card card-info shadow-sm mt-3">
                <div class="card-header border-0">
                    <h3 class="card-title font-weight-bold small">DỮ LIỆU HỆ THỐNG</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0 small">
                        <tr><td class="pl-3 py-2 text-muted">Nguồn:</td><td class="text-right pr-3 font-weight-bold text-uppercase">{{ $user->provider ?? 'Hệ thống' }}</td></tr>
                        <tr><td class="pl-3 py-2 text-muted">IP cuối:</td><td class="text-right pr-3">{{ $user->IpAdress ?? 'N/A' }}</td></tr>
                        <tr><td class="pl-3 py-2 text-muted">Tham gia:</td><td class="text-right pr-3">{{ date('d/m/Y', strtotime($user->created_at ?? now())) }}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- CỘT PHẢI: CHI TIẾT CÁC TABS --}}
        <div class="col-md-9">
            <div class="card shadow-sm" style="border-radius: 10px; overflow: hidden;">
                <div class="card-header p-2 bg-white border-bottom-0">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#info" data-toggle="tab"><i class="fas fa-user mr-1"></i> Thông tin cá nhân</a></li>
                        <li class="nav-item"><a class="nav-link" href="#bookings" data-toggle="tab"><i class="fas fa-suitcase-rolling mr-1"></i> Lịch sử đặt Tour</a></li>
                        <li class="nav-item"><a class="nav-link" href="#reviews" data-toggle="tab"><i class="fas fa-star mr-1"></i> Đánh giá</a></li>
                        <li class="nav-item"><a class="nav-link" href="#history" data-toggle="tab"><i class="fas fa-history mr-1"></i> Nhật ký hoạt động</a></li>
                    </ul>
                </div>
                
                <div class="card-body">
                    <div class="tab-content">
                        {{-- TAB 1: THÔNG TIN CHI TIẾT --}}
                        <div class="active tab-pane" id="info">
                            <form class="form-horizontal small">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-muted">Họ tên</label>
                                    <div class="col-sm-10"><input type="text" class="form-control border-0 bg-light" value="{{ $user->username }}" readonly></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-muted">Email</label>
                                    <div class="col-sm-10"><input type="email" class="form-control border-0 bg-light" value="{{ $user->email }}" readonly></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-muted">Số điện thoại</label>
                                    <div class="col-sm-10"><input type="text" class="form-control border-0 bg-light" value="{{ $user->phoneNumber ?? 'Chưa cập nhật' }}" readonly></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-muted">Địa chỉ</label>
                                    <div class="col-sm-10"><textarea class="form-control border-0 bg-light" rows="2" readonly>{{ $user->address ?? 'Chưa cập nhật địa chỉ' }}</textarea></div>
                                </div>
                            </form>
                            <hr>
                            <div class="alert alert-light border small text-muted">
                                <i class="fas fa-info-circle mr-1"></i> Thông tin này được thu thập từ quá trình người dùng đăng ký hoặc cập nhật hồ sơ cá nhân.
                            </div>
                        </div>

                        {{-- TAB 2: LỊCH SỬ BOOKING --}}
                        <div class="tab-pane" id="bookings">
                            @if(count($bookings) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="bg-light small text-uppercase">
                                        <tr>
                                            <th>Ngày đặt</th>
                                            <th>Tên Tour</th>
                                            <th class="text-center">Số người</th>
                                            <th class="text-right">Tổng tiền</th>
                                            <th class="text-center">Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bookings as $booking)
                                        <tr>
                                            <td class="small">{{ date('d/m/Y', strtotime($booking->bookingdate)) }}</td>
                                            <td class="font-weight-bold text-info">{{ $booking->tour_name }}</td>
                                            <td class="text-center small">{{ $booking->numadults }}L, {{ $booking->numchildren }}T</td>
                                            <td class="text-right font-weight-bold text-success">{{ number_format($booking->totalprice) }}đ</td>
                                            <td class="text-center">
                                                @php
                                                    $statusClass = [
                                                        'pending' => 'warning',
                                                        'confirmed' => 'primary',
                                                        'completed' => 'success',
                                                        'cancelled' => 'danger'
                                                    ][$booking->bookingstatus] ?? 'secondary';
                                                @endphp
                                                <span class="badge badge-{{ $statusClass }} small px-2">{{ strtoupper($booking->bookingstatus) }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                                <div class="text-center py-5 text-muted"><i class="fas fa-box-open fa-3x mb-3"></i><p>Chưa có lịch sử đặt tour nào.</p></div>
                            @endif
                        </div>

                        {{-- TAB 3: ĐÁNH GIÁ --}}
                        <div class="tab-pane" id="reviews">
                            @if(count($reviews) > 0)
                                @foreach($reviews as $review)
                                <div class="post mb-3 border-bottom pb-3">
                                    <div class="user-block">
                                        <span class="username ml-0">
                                            <a href="#" class="text-info font-weight-bold">{{ $review->tour_name }}</a>
                                            <span class="float-right text-warning small">
                                                @for($i=1; $i<=5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-light' }}"></i>
                                                @endfor
                                            </span>
                                        </span>
                                        <span class="description ml-0">{{ date('d/m/Y H:i', strtotime($review->createdat)) }}</span>
                                    </div>
                                    <p class="text-dark">{{ $review->comment }}</p>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-5 text-muted"><i class="fas fa-comment-slash fa-3x mb-3"></i><p>Người dùng chưa gửi đánh giá nào.</p></div>
                            @endif
                        </div>

                        {{-- TAB 4: NHẬT KÝ HỆ THỐNG --}}
                        <div class="tab-pane" id="history">
                            <div class="timeline timeline-inverse mt-2 small">
                                @forelse($activities as $activity)
                                <div>
                                    <i class="fas fa-bolt bg-secondary"></i>
                                    <div class="timeline-item shadow-none border">
                                        <span class="time"><i class="far fa-clock"></i> {{ date('H:i d/m/Y', strtotime($activity->timestamp)) }}</span>
                                        <h3 class="timeline-header border-0">{{ $activity->actionType }}</h3>
                                    </div>
                                </div>
                                @empty
                                    <div class="text-center text-muted py-4">Chưa có dữ liệu nhật ký.</div>
                                @endforelse
                                <div><i class="far fa-clock bg-gray"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- MODAL CHỈNH SỬA HỒ SƠ --}}
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('admin.users.update', $user->userid) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="modalEditLabel"><i class="fas fa-user-edit mr-2"></i>Chỉnh sửa hồ sơ: {{ $user->username }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{-- Ảnh đại diện --}}
                        <div class="col-md-4 text-center border-right">
                            <label class="d-block text-muted small">ẢNH ĐẠI DIỆN</label>
                            <img src="{{ $avatarUrl }}" id="preview_avatar" class="img-circle elevation-2 mb-3" 
                                 style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #f4f6f9;">
                            <div class="custom-file">
                                <input type="file" name="avatar" class="custom-file-input" id="avatarInput" onchange="previewImage(this)">
                                <label class="custom-file-label text-left">Chọn file...</label>
                            </div>
                            <p class="text-xs text-muted mt-2">Định dạng: JPG, PNG. Tối đa 2MB.</p>
                        </div>
                        
                        {{-- Thông tin chi tiết --}}
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Tên người dùng</label>
                                        <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Số điện thoại</label>
                                        <input type="text" name="phoneNumber" class="form-control" value="{{ $user->phoneNumber }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="small font-weight-bold">Email (Không thể sửa nếu là tài khoản Social)</label>
                                <input type="email" class="form-control" value="{{ $user->email }}" {{ $user->provider ? 'readonly' : 'name=email' }}>
                            </div>

                            <div class="form-group">
                                <label class="small font-weight-bold">Địa chỉ</label>
                                <textarea name="address" class="form-control" rows="2">{{ $user->address }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Vai trò</label>
                                        <select name="role" class="form-control" {{ (session('user') && session('user')->userid == $user->userid) ? 'disabled' : '' }}>
                                            <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Thành viên</option>
                                            <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Quản trị viên</option>
                                        </select>
                                        @if(session('user') && session('user')->userid == $user->userid)
                                            <input type="hidden" name="role" value="{{ $user->role }}">
                                            <small class="text-danger italic">Bạn không thể tự đổi quyền của mình.</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Trạng thái</label>
                                        <select name="status" class="form-control">
                                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Khóa tài khoản</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-info px-4 shadow-sm">Lưu cập nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
<style>
    .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
        background-color: #4CBEE1;
    }
    .profile-user-img {
        padding: 3px;
        border: 3px solid #4CBEE1;
    }
    .post {
        border-bottom: 1px solid #adb5bd;
        color: #666;
        margin-bottom: 15px;
        padding-bottom: 15px;
    }
</style>
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview_avatar').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@stop