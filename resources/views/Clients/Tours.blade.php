@include('clients.blocks.header')
@include('clients.blocks.banner', ['title' => 'Khám Phá Hành Trình'])

<section class="tour-grid-page py-5 rel z-1 bg-light">
    <div class="container-fluid px-lg-5">
        <div class="row g-4">
            
            {{-- SIDEBAR --}}
            <div class="col-lg-3 col-md-12">
                @include('clients.blocks.sidebar-tour')
            </div>
            
            {{-- MAIN CONTENT --}}
            <div class="col-lg-9 col-md-12">
                
                {{-- THANH CÔNG CỤ TÌM KIẾM & SẮP XẾP --}}
                <div class="shop-top-bar d-flex flex-wrap align-items-center justify-content-between mb-4 bg-white p-3 rounded-4 shadow-sm border-0">
                    <div class="d-flex align-items-center mb-2 mb-md-0">
                        <ul class="grid-list d-flex list-unstyled mb-0 me-3 gap-2">
                            <li><a href="#" class="active view-btn text-primary"><i class="fas fa-th-large"></i></a></li>
                            <li><a href="#" class="view-btn text-muted"><i class="fas fa-list"></i></a></li>
                        </ul>
                        <div class="text-muted small fw-bold">
                            Hiển thị <span class="text-primary">{{ $tours->count() }}</span> / {{ $tours->total() }} Hành trình
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted small fw-bold d-none d-sm-block text-nowrap flex-shrink-0">Sắp xếp:</span>
                        
                        <select class="form-select form-select-sm rounded-pill shadow-none border bg-light px-3 py-2 fw-bold text-dark" name="sort_by" form="filterForm" onchange="document.getElementById('filterForm').submit();" style="min-width: 180px; cursor: pointer;">
                            <option value="default" {{ !request('sort_by') || request('sort_by') == 'default' ? 'selected' : '' }}>🌟 Phù hợp nhất</option>
                            <option value="new" {{ request('sort_by') == 'new' ? 'selected' : '' }}>🔥 Mới nhất</option>
                            <option value="old" {{ request('sort_by') == 'old' ? 'selected' : '' }}>🕒 Cũ nhất</option>
                            <option value="high-to-low" {{ request('sort_by') == 'high-to-low' ? 'selected' : '' }}>💰 Giá: Cao đến Thấp</option>
                            <option value="low-to-high" {{ request('sort_by') == 'low-to-high' ? 'selected' : '' }}>💸 Giá: Thấp đến Cao</option>
                        </select>
                    </div>
                </div> {{-- !!! ĐÃ THÊM THẺ DIV ĐÓNG KHỐI TOP-BAR Ở ĐÂY !!! --}}
                
                {{-- LƯỚI DANH SÁCH TOUR --}}
                <div class="row g-4">
                    
                    {{-- TRẠNG THÁI TRỐNG --}}
                    @if($tours->isEmpty())
                        <div class="col-12">
                            <div class="empty-result-area text-center py-5 px-4 bg-white shadow-sm rounded-4 border-0">
                                <img src="{{ asset('clients/assets/images/not-found.svg') }}" alt="No Tours" style="width: 150px; opacity: 0.6;" class="mb-4">
                                <h4 class="fw-bold text-dark mb-3">Rất tiếc, không tìm thấy chuyến đi nào!</h4>
                                <p class="text-muted mb-4">
                                    @if(request('destination'))
                                        Không có lịch trình nào khớp với điểm đến <strong class="text-danger">"{{ request('destination') }}"</strong> lúc này.<br>
                                    @endif
                                    Hãy thử thay đổi bộ lọc hoặc mở rộng tìm kiếm của bạn.
                                </p>
                                <a href="{{ route('Tours') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                                    <i class="fas fa-sync-alt me-2"></i> Xóa bộ lọc & Xem tất cả
                                </a>
                            </div>
                        </div>
                        
                    @else
                        {{-- VÒNG LẶP TOUR --}}
                        @foreach($tours as $tour)
                            @php
                                // Xử lý Logic Badge
                                $isPast = !empty($tour->startdate) && \Carbon\Carbon::parse($tour->startdate)->endOfDay()->isPast();
                                $isFull = $tour->quantity <= 0;
                                $isClosed = $tour->availability == 0;
                                
                                if($isPast) {
                                    $badgeClass = 'bg-secondary'; $badgeText = 'Đã khởi hành';
                                } elseif($isFull) {
                                    $badgeClass = 'bg-danger'; $badgeText = 'Đã hết chỗ';
                                } elseif($isClosed) {
                                    $badgeClass = 'bg-dark'; $badgeText = 'Tạm ngưng';
                                } else {
                                    $badgeClass = 'bg-success'; $badgeText = 'Đang mở bán';
                                }

                                // Xử lý chống lỗi Ảnh JSON
                                $tourImg = 'default.jpg';
                                if (!empty($tour->images)) {
                                    if (is_string($tour->images) && str_starts_with(trim($tour->images), '[')) {
                                        $arr = json_decode($tour->images, true);
                                        if (is_array($arr) && count($arr) > 0) { $tourImg = $arr[0]; }
                                    } else {
                                        $tourImg = $tour->images;
                                    }
                                }
                            @endphp

                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                <div class="card h-100 border-0 shadow-sm rounded-4 text-decoration-none transition-hover">
                                    
                                    {{-- Ảnh & Badges --}}
                                    <div class="position-relative overflow-hidden" style="border-radius: 1rem 1rem 0 0; height: 220px;">
                                        <span class="position-absolute top-0 start-0 m-3 badge {{ $badgeClass }} shadow-sm z-1">{{ $badgeText }}</span>
                                        
<button class="btn-favorite position-absolute top-0 end-0 m-3 btn btn-light btn-sm rounded-circle shadow-sm z-1" 
        data-tour-id="{{ $tour->tourid }}" 
        title="Lưu tour này" 
        style="width: 32px; height: 32px; padding: 0;">
    <i class="fa-heart {{ $tour->is_favorited ? 'fas text-danger' : 'far text-muted' }}"></i>
</button>
                                        
                                        <a href="{{ route('tour-detail', $tour->tourid) }}" class="d-block w-100 h-100">
                                            <img src="{{ asset('clients/assets/images/gallery-tours/' . $tourImg) }}" 
                                                 onerror="this.src='https://images.unsplash.com/photo-1528127269322-539801943592?q=80&w=600'"
                                                 alt="{{ $tour->title }}" class="w-100 h-100 object-fit-cover hover-zoom">
                                        </a>
                                    </div>
                                    
                                    {{-- Nội dung --}}
                                    <div class="card-body d-flex flex-column p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-primary small fw-bold"><i class="fas fa-map-marker-alt me-1"></i> {{ Str::limit($tour->destination, 20) }}</span>
                                            <div class="text-warning small fw-bold">
                                                <i class="fas fa-star"></i> 4.9
                                            </div>
                                        </div>
                                        
                                        <h5 class="card-title fw-bold mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                            <a href="{{ route('tour-detail', $tour->tourid) }}" class="text-dark text-decoration-none">{{ $tour->title }}</a>
                                        </h5>
                                        
                                        <div class="d-flex justify-content-between text-muted small mb-3 pb-3 border-bottom">
                                            <span class="fw-medium"><i class="far fa-clock me-1 text-primary"></i> {{ $tour->time ?? 'Cập nhật' }}</span>
                                            <span class="fw-medium"><i class="far fa-user me-1 text-primary"></i> Chỗ: <strong class="{{ $isFull ? 'text-danger' : 'text-dark' }}">{{ $isFull ? '0' : $tour->quantity }}</strong></span>
                                        </div>
                                        
                                        {{-- Footer đẩy xuống đáy --}}
                                        <div class="mt-auto d-flex justify-content-between align-items-end">
                                            <div>
                                                <span class="d-block text-muted small mb-1 fw-medium">Giá chỉ từ</span>
                                                <span class="text-danger fw-900 fs-5 lh-1">
                                                    {{ number_format($tour->min_price ?? $tour->priceadult, 0, ',', '.') }}<small class="text-muted ms-1 fs-6 text-decoration-underline">đ</small>
                                                </span>
                                            </div>
                                            <a href="{{ route('tour-detail', $tour->tourid) }}" class="btn btn-outline-primary rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; transition: 0.3s;">
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
                
                {{-- PHÂN TRANG --}}
                @if($tours->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $tours->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
                @endif
                
            </div>
        </div>
    </div>
</section>

{{-- Thêm chút CSS cho ảnh zoom mượt mà --}}
<style>
    .transition-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .transition-hover:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
    .hover-zoom { transition: transform 0.5s ease; }
    .transition-hover:hover .hover-zoom { transform: scale(1.08); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Cấu hình khung Thông báo (Toast) của SweetAlert2
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end', // Hiện ở góc trên bên phải
        showConfirmButton: false,
        timer: 3000, // Tự động tắt sau 3 giây
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // 2. Lấy tất cả các nút yêu thích
    const favoriteButtons = document.querySelectorAll('.btn-favorite');

    favoriteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); 

            const tourId = this.dataset.tourId; 
            const icon = this.querySelector('i.fa-heart'); 
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content; 

            // Gửi AJAX request
            fetch('{{ route("favorite.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin', // Nhớ giữ dòng này nhé
                body: JSON.stringify({ tourid: tourId })
            })
            .then(response => {
                if (response.status === 401) {
                    // Thông báo báo lỗi chưa đăng nhập
                    Toast.fire({
                        icon: 'warning',
                        title: 'Vui lòng đăng nhập để lưu tour!'
                    });
                    throw new Error('Unauthorized');
                }
                return response.json();
            })
            .then(data => {
                if (data && data.status === 'added') {
                    // Đổi icon sang đỏ
                    icon.classList.remove('far', 'text-muted');
                    icon.classList.add('fas', 'text-danger');
                    
                    // HIỆN THÔNG BÁO THÊM THÀNH CÔNG
                    Toast.fire({
                        icon: 'success',
                        title: 'Đã thêm vào yêu thích 💖'
                    });

                } else if (data && data.status === 'removed') {
                    // Đổi icon về xám
                    icon.classList.remove('fas', 'text-danger');
                    icon.classList.add('far', 'text-muted');

                    // HIỆN THÔNG BÁO XÓA THÀNH CÔNG
                    Toast.fire({
                        icon: 'info',
                        title: 'Đã bỏ lưu tour này 💔'
                    });
                }
            })
            .catch(error => {
                if(error.message !== 'Unauthorized') {
                    console.error('Lỗi:', error);
                    Toast.fire({
                        icon: 'error',
                        title: 'Có lỗi xảy ra, vui lòng thử lại!'
                    });
                }
            });
        });
    });
});
</script>

@include('clients.blocks.footer')