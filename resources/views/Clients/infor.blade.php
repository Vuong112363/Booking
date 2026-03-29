@include('Clients.blocks.header')

<div class="user-profile py-5" style="background:#f5f7fb; min-height: 90vh;">
    <div class="container">
        
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold text-dark">Quản Lý Hồ Sơ</h2>
                <p class="text-muted">Cập nhật thông tin cá nhân và quản lý hành trình của bạn</p>
            </div>
        </div>

        {{-- Hệ thống thông báo --}}
        <div class="row justify-content-center mb-3">
            <div class="col-lg-12">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger shadow-sm border-0 alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="fas fa-times-circle me-1"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>
        </div>

        <div class="row g-4">
            {{-- CỘT TRÁI: AVATAR & ĐỔI MK --}}
            <div class="col-lg-4 mb-4">
                {{-- Card Avatar --}}
                <div class="card shadow-sm border-0 text-center mb-4 overflow-hidden" style="border-radius: 15px;">
                    <div class="card-body pt-5">
                        <div class="position-relative d-inline-block mb-3">
                            <div class="avatar-wrapper">
                                <img id="avatar-preview" class="rounded-circle shadow-sm border border-4 border-white"
                                     src="{{ $user->avatar ? asset('clients/assets/images/avatars/' . $user->avatar) : asset('clients/assets/images/avatars/Noavatar.png') }}"
                                     style="width:150px; height:150px; object-fit:cover;">
                                <label for="avatar-input" class="avatar-edit-icon">
                                    <i class="fas fa-camera"></i>
                                </label>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-0 text-dark">{{ $user->username }}</h5>
                        <p class="text-muted small mb-4">{{ $user->email }}</p>

                        <form id="avatarForm" method="POST" action="{{ route('user.avatar') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="avatar" id="avatar-input" accept="image/*" class="d-none">
                            <button type="submit" id="btn-save-avatar" class="btn btn-primary w-100 rounded-pill shadow-sm d-none animate__animated animate__fadeIn">
                                <i class="fas fa-cloud-upload-alt me-1"></i> Xác nhận thay đổi
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Card Đổi Mật Khẩu (Tính năng yêu cầu: Nhập mật khẩu cũ) --}}
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <h6 class="mb-0 text-dark fw-bold text-uppercase small tracking-wider">
                            <i class="fas fa-shield-alt text-warning me-2"></i>Bảo mật tài khoản
                        </h6>
                    </div>
                    <div class="card-body pt-3">
                        <form method="POST" action="{{ route('user.password') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="text-muted small fw-bold">Mật khẩu hiện tại</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-key text-muted"></i></span>
                                    <input type="password" name="old_password" class="form-control bg-light border-0 shadow-none" placeholder="Nhập mật khẩu cũ" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted small fw-bold">Mật khẩu mới</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" name="new_password" class="form-control bg-light border-0 shadow-none" placeholder="Tối thiểu 6 ký tự" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="text-muted small fw-bold">Xác nhận mật khẩu mới</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-check text-muted"></i></span>
                                    <input type="password" name="confirm_password" class="form-control bg-light border-0 shadow-none" placeholder="Nhập lại mật khẩu mới" required>
                                </div>
                            </div>

                            <button class="btn btn-warning w-100 rounded-pill shadow-sm fw-bold py-2">
                                <i class="fas fa-sync-alt me-1"></i> Cập nhật mật khẩu
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- CỘT PHẢI: TABS NỘI DUNG --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 bg-white" style="border-radius: 15px; min-height: 600px;">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <ul class="nav nav-tabs profile-tabs border-0" id="profileTab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active fw-bold border-0 bg-transparent px-3 pb-3" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                                    <i class="fas fa-user-edit text-success me-1"></i> Thông tin cá nhân
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold border-0 bg-transparent px-3 pb-3" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">
                                    <i class="fas fa-history text-primary me-1"></i> Lịch sử đặt Tour
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold border-0 bg-transparent px-3 pb-3" id="wishlist-tab" data-bs-toggle="tab" data-bs-target="#wishlist" type="button" role="tab">
                                    <i class="fas fa-heart text-danger me-1"></i> Yêu thích
                                </button>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="card-body p-4 pt-2">
                        <div class="tab-content" id="profileTabContent">
                            
                            {{-- TAB 1: THÔNG TIN CÁ NHÂN --}}
                            <div class="tab-pane fade show active" id="info" role="tabpanel">
                                <form method="POST" action="{{ route('user.update') }}">
                                    @csrf
                                    <div class="row g-4 mt-1">
                                        <div class="col-md-12">
                                            <label class="text-muted small fw-bold">Họ và tên</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-0"><i class="fas fa-user text-muted"></i></span>
                                                <input class="form-control bg-light border-0 shadow-none" name="username" value="{{ old('username', $user->username) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-muted small fw-bold">Số điện thoại</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-0"><i class="fas fa-phone-alt text-muted"></i></span>
                                                <input class="form-control bg-light border-0 shadow-none" name="phoneNumber" value="{{ old('phoneNumber', $user->phoneNumber) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-muted small fw-bold">Email (Cố định)</label>
                                            <div class="input-group">
                                                <span class="input-group-text border-0" style="background: #e9ecef;"><i class="fas fa-envelope text-muted"></i></span>
                                                <input class="form-control border-0 shadow-none" style="background: #e9ecef;" value="{{ $user->email }}" readonly disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="text-muted small fw-bold">Địa chỉ</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-0"><i class="fas fa-map-marker-alt text-muted"></i></span>
                                                <input class="form-control bg-light border-0 shadow-none" name="address" value="{{ old('address', $user->address) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end mt-5">
                                        <button type="submit" class="btn btn-success px-5 rounded-pill shadow-sm fw-bold">
                                            <i class="fas fa-save me-2"></i>Lưu Thay Đổi
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {{-- TAB 2: LỊCH SỬ ĐẶT TOUR (Tính năng yêu cầu: Bộ lọc + In hóa đơn) --}}
                            <div class="tab-pane fade" id="history" role="tabpanel">
                                {{-- Bộ lọc trạng thái --}}
                                <div class="d-flex justify-content-start gap-2 mb-4 mt-3">
                                    <button class="btn btn-sm btn-outline-dark rounded-pill px-3 filter-btn active" data-filter="all">Tất cả</button>
                                    <button class="btn btn-sm btn-outline-warning rounded-pill px-3 filter-btn" data-filter="pending">Chờ duyệt</button>
                                    <button class="btn btn-sm btn-outline-success rounded-pill px-3 filter-btn" data-filter="confirmed">Thành công</button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover align-middle border-0">
                                        <thead class="table-light">
                                            <tr class="small text-muted text-uppercase">
                                                <th class="ps-3">Mã vé</th>
                                                <th>Thông tin Tour</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                                <th class="text-center">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($bookings as $booking)
                                                <tr class="booking-row" data-status="{{ $booking->bookingstatus }}">
                                                    <td class="ps-3"><span class="fw-bold">#{{ $booking->bookingid }}</span></td>
                                                    <td>
                                                        <div class="fw-bold text-dark text-truncate" style="max-width: 250px;">{{ $booking->title }}</div>
                                                        <small class="text-muted"><i class="far fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($booking->bookingdate)->format('d/m/Y') }}</small>
                                                    </td>
                                                    <td><span class="text-danger fw-bold">{{ number_format($booking->totalprice) }} đ</span></td>
                                                    <td>
                                                        @php
                                                            $statusClass = [
                                                                'pending' => 'bg-warning-subtle text-dark border-warning',
                                                                'confirmed' => 'bg-success-subtle text-success border-success',
                                                                'cancelled' => 'bg-secondary-subtle text-secondary border-secondary'
                                                            ];
                                                            $statusLabel = [
                                                                'pending' => 'Chờ duyệt',
                                                                'confirmed' => 'Thành công',
                                                                'cancelled' => 'Đã hủy'
                                                            ];
                                                        @endphp
                                                        <span class="badge border px-3 py-2 rounded-pill {{ $statusClass[$booking->bookingstatus] ?? $statusClass['cancelled'] }}">
                                                            {{ $statusLabel[$booking->bookingstatus] ?? 'Không rõ' }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center gap-2">
                                                            {{-- Nút In --}}
                                                            <button class="btn btn-sm btn-light rounded-circle shadow-sm border" title="In hóa đơn" onclick="window.print()">
                                                                <i class="fas fa-print text-muted"></i>
                                                            </button>
                                                            {{-- Nút Chi tiết --}}
                                                            <button class="btn btn-sm btn-outline-info rounded-circle shadow-sm" 
                                                                    data-bs-toggle="collapse" 
                                                                    data-bs-target="#detail{{ $booking->bookingid }}"
                                                                    title="Xem chi tiết">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                            
                                                            @if($booking->bookingstatus == 'pending')
                                                                <form action="{{ route('booking.cancelled', $booking->bookingid) }}" method="POST">
                                                                    @csrf
                                                                    <button class="btn btn-sm btn-outline-danger rounded-circle shadow-sm" 
                                                                            onclick="return confirm('Xác nhận hủy đơn đặt tour này?')" title="Hủy đơn">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                
                                                {{-- Chi tiết ẩn --}}
                                                <tr class="collapse border-0" id="detail{{ $booking->bookingid }}">
                                                    <td colspan="5" class="p-0 border-0">
                                                        <div class="p-3 m-2 bg-light rounded-3 border-start border-4 border-info">
                                                            <div class="row small g-3">
                                                                <div class="col-md-6 border-end">
                                                                    <p class="mb-1 text-muted">Chi tiết khách hàng:</p>
                                                                    <p class="mb-1"><strong>Ngày khởi hành:</strong> {{ \Carbon\Carbon::parse($booking->startdate)->format('d/m/Y') }}</p>
                                                                    <p class="mb-0"><strong>Số lượng:</strong> {{ $booking->numadults }} Lớn / {{ $booking->numchildren }} Trẻ em</p>
                                                                </div>
                                                                <div class="col-md-6 text-md-end">
                                                                    <p class="mb-1 text-muted">Yêu cầu đặc biệt:</p>
                                                                    <p class="mb-0 fw-bold text-dark italic">"{{ $booking->specialrequest ?? 'Không có yêu cầu' }}"</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-5">
                                                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" style="width: 80px; opacity: 0.2;" class="mb-3">
                                                        <p class="text-muted">Bạn chưa có lịch sử đặt tour nào.</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- TAB 3: TOUR YÊU THÍCH --}}
                            <div class="tab-pane fade" id="wishlist" role="tabpanel">
                                @if(isset($tours_wishlist) && $tours_wishlist->count() > 0)
                                    <div class="row">
                                        @foreach($tours_wishlist as $tour)
                                            <div class="col-md-6 col-lg-4 mb-4">
                                                <div class="card h-100 shadow-sm border-0 position-relative">
                                                    <button class="btn-favorite position-absolute top-0 end-0 m-2 btn btn-danger btn-sm rounded-circle shadow-sm z-1" 
                                                            data-tour-id="{{ $tour->tourid }}" 
                                                            title="Bỏ yêu thích">
                                                        <i class="fas fa-heart"></i>
                                                    </button>

                                                    <img src="{{ asset('clients/assets/images/gallery-tours/' . $tour->display_image) }}" 
                                                                                                            class="card-img-top" 
                                                                                                            alt="{{ $tour->title }}" 
                                                                                                            style="height: 200px; object-fit: cover;">
                                                    <div class="card-body">
                                                        <h6 class="card-title font-weight-bold">{{ $tour->title }}</h6>
                                                        <p class="text-danger font-weight-bold mb-0">{{ number_format($tour->min_price) }}đ</p>
                                                    </div>
                                                    <div class="card-footer bg-white border-0 pb-3">
                                                        <a href="{{ route('tour-detail', $tour->tourid) }}" class="btn btn-outline-primary btn-sm btn-block rounded-pill">Xem chi tiết</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $tours_wishlist->links() }}
                                    </div>
                                @else
                                    {{-- Giao diện trống (Code cũ của bạn) --}}
                                    <div class="text-center py-5">
                                        <div class="mb-4">
                                            <i class="fas fa-heart fa-4x text-danger opacity-10"></i>
                                        </div>
                                        <h5 class="text-muted">Danh sách yêu thích đang trống</h5>
                                        <p class="small text-muted mb-4">Hãy lưu lại những điểm đến mơ ước của bạn!</p>
                                        <a href="{{ route('Tours') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">Khám phá tour ngay</a>
                                    </div>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Tabs Custom */
    .profile-tabs .nav-link { color: #6c757d; position: relative; transition: all 0.3s; font-size: 0.95rem; }
    .profile-tabs .nav-link:hover { color: #198754; }
    .profile-tabs .nav-link.active { color: #198754 !important; }
    .profile-tabs .nav-link.active::after {
        content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 3px; background: #198754; border-radius: 3px 3px 0 0;
    }

    /* Avatar Upload Styling */
    .avatar-wrapper { position: relative; display: inline-block; cursor: pointer; }
    .avatar-edit-icon {
        position: absolute; bottom: 5px; right: 5px; background: #198754; color: white;
        width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; 
        justify-content: center; border: 3px solid white; cursor: pointer; transition: 0.2s;
    }
    .avatar-edit-icon:hover { transform: scale(1.1); background: #146c43; }

    /* Button Effects */
    .btn-warning { background: linear-gradient(45deg,#ffc107,#ff9800); border:none; color: white !important; }
    .btn-warning:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255, 152, 0, 0.3); }
    .btn-success { background: #198754; border: none; }
    .btn-success:hover { background: #146c43; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3); }

    /* Table & Row Hover */
    .booking-row { transition: background 0.2s; }
    .booking-row:hover { background-color: #f8f9fa !important; }

    /* Print styling */
    @media print {
        header, footer, .col-lg-4, .nav-tabs, .filter-btn, .breadcrumb, .btn-outline-info, .btn-outline-danger { display: none !important; }
        .col-lg-8 { width: 100% !important; }
        .card { border: none !important; box-shadow: none !important; }
        .collapse { display: block !important; }
        .table-responsive { overflow: visible !important; }
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // 1. Preview Ảnh Đại Diện & Hiện nút Lưu
    const avatarInput = document.getElementById('avatar-input');
    const avatarPreview = document.getElementById('avatar-preview');
    const btnSaveAvatar = document.getElementById('btn-save-avatar');
    
    if(avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    avatarPreview.src = event.target.result;
                    btnSaveAvatar.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // 2. Bộ lọc trạng thái đơn hàng tại chỗ (Client-side filter)
    const filterBtns = document.querySelectorAll('.filter-btn');
    const bookingRows = document.querySelectorAll('.booking-row');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Đổi active class
            filterBtns.forEach(b => b.classList.remove('active', 'btn-dark'));
            this.classList.add('active');
            if(this.dataset.filter === 'all') this.classList.add('btn-outline-dark');

            const filterValue = this.getAttribute('data-filter');

            bookingRows.forEach(row => {
                const status = row.getAttribute('data-status');
                if(filterValue === 'all' || status === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // 3. Tự động mở Tab từ URL Hash (hoặc lưu vào localStorage)
    let hash = window.location.hash || localStorage.getItem('activeProfileTab');
    if (hash) {
        let triggerEl = document.querySelector(`.nav-link[data-bs-target="${hash}"]`);
        if (triggerEl) {
            bootstrap.Tab.getOrCreateInstance(triggerEl).show();
        }
    }

    // Lưu tab khi chuyển đổi
    document.querySelectorAll('.nav-link[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', (e) => {
            const target = e.target.getAttribute('data-bs-target');
            localStorage.setItem('activeProfileTab', target);
        });
    });
});
</script>

@include('Clients.blocks.footer')