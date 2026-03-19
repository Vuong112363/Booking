@include('Clients.blocks.header')
<style>
    /* Sửa lỗi modal bị mờ hoặc không click được */
    .modal { background: rgba(0,0,0,0.5); }
    .modal-backdrop { display: none !important; } 
    .modal-content { z-index: 1060 !important; }
</style>

<div class="container mt-5 mb-5">
    <h3 class="mb-4">
        <i class="fa-solid fa-clock-rotate-left"></i> Lịch sử đặt tour
    </h3>

    {{-- THÔNG BÁO --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- BẢNG DANH SÁCH BOOKING --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Tour</th>
                    <th>Ngày đi</th>
                    <th>Tổng tiền</th>
                    <th>Thanh toán</th>
                    <th>Trạng thái Tour</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $key => $item)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td><strong>{{ $item->title }}</strong></td>
                    <td class="text-center">{{ date('d/m/Y', strtotime($item->startdate)) }}</td>
                    <td class="text-right text-primary">
                        {{ number_format($item->totalprice) }} VNĐ
                    </td>

                    {{-- PAYMENT STATUS --}}
                    <td class="text-center">
                        @if($item->paymentstatus == 'unpaid')
                            <span class="badge bg-secondary text-white">Chưa thanh toán</span>
                        @elseif($item->paymentstatus == 'deposit_paid')
                            <span class="badge bg-warning text-dark">
                                Đã cọc ({{ number_format($item->deposit_amount) }}đ)
                            </span>
                        @elseif($item->paymentstatus == 'paid')
                            <span class="badge bg-success text-white">Đã thanh toán đủ</span>
                        @elseif($item->paymentstatus == 'refund_pending')
                            <span class="badge bg-danger text-white">Đang chờ hoàn tiền</span>
                        @endif
                    </td>

                    {{-- BOOKING STATUS & TÌNH TRẠNG ĐI TOUR --}}
                    <td class="text-center">
                        @if($item->bookingstatus == 'pending')
                            <span class="badge bg-warning text-dark">Chờ xử lý</span>
                        @elseif($item->bookingstatus == 'confirmed')
                            {{-- Kiểm tra ngày khởi hành so với hiện tại --}}
                            @if(strtotime($item->startdate) > time())
                                <span class="badge bg-primary text-white">Sắp khởi hành</span>
                            @else
                                <span class="badge bg-info text-dark">Đang/Đã đi tour</span>
                            @endif
                        @elseif($item->bookingstatus == 'completed')
                            <span class="badge bg-success text-white">Hoàn thành</span>
                        @elseif($item->bookingstatus == 'cancelled')
                            <span class="badge bg-danger text-white">Đã hủy</span>
                        @endif
                    </td>

<td class="text-center">
    <a href="{{ url('/booking-detail/'.$item->bookingid) }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i></a>

    @if($item->paymentstatus == 'unpaid' && $item->bookingstatus != 'cancelled')
        <a href="{{ url('/momo-payment/'.$item->bookingid) }}" class="btn btn-sm btn-success"><i class="fa-solid fa-credit-card"></i></a>
    @endif

    @if($item->bookingstatus != 'cancelled' && $item->bookingstatus != 'completed')
        {{-- Nút kích hoạt Modal Hủy --}}
        <button type="button" class="btn btn-sm {{ $item->paymentstatus == 'unpaid' ? 'btn-danger' : 'btn-warning' }}" 
                data-bs-toggle="modal" data-bs-target="#modalCancel{{ $item->bookingid }}">
            <i class="fa-solid {{ $item->paymentstatus == 'unpaid' ? 'fa-trash' : 'fa-rotate-left' }}"></i> 
            {{ $item->paymentstatus == 'unpaid' ? 'Hủy đơn' : 'Hủy & Hoàn tiền' }}
        </button>

        <div class="modal fade" id="modalCancel{{ $item->bookingid }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ url('/booking-cancel/'.$item->bookingid) }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">Xác nhận hủy tour #{{ $item->bookingid }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <p class="text-danger"><strong>Lưu ý về chính sách hoàn tiền:</strong></p>
                            <ul class="small">
                                <li>Trước 5 ngày: Hoàn 100% tiền đã cọc.</li>
                                <li>Từ 2-5 ngày: Hoàn 50% tiền đã cọc.</li>
                                <li>Dưới 2 ngày: Không hoàn tiền cọc.</li>
                            </ul>
                            
                            <div class="mb-3">
                                <label class="form-label">Lý do hủy:</label>
                                <textarea name="cancel_reason" class="form-control" required placeholder="Vui lòng cho biết lý do..."></textarea>
                            </div>

                            @if($item->paymentstatus != 'unpaid')
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Thông tin nhận tiền hoàn (Số TK, Ngân hàng, Tên):</label>
                                <textarea name="refund_info" class="form-control" required placeholder="Ví dụ: 012345678 - Vietcombank - NGUYEN VAN A"></textarea>
                            </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
</td>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Không có dữ liệu đặt tour.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PHẦN NHẬT KÝ HOẠT ĐỘNG --}}
    <hr class="mt-5">
    <h3 class="mb-4 text-secondary"><i class="fa-solid fa-clock-rotate-left"></i> Nhật ký hoạt động gần đây</h3>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                @php
                    $userLogs = \App\Models\History::where('userid', session('userid'))
                                ->orderBy('timestamp', 'desc')
                                ->take(10)
                                ->get();
                @endphp

                @forelse($userLogs as $log)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <div>
                            @if(str_contains($log->actionType, 'Thanh toán') || str_contains($log->actionType, 'thành công'))
                                <i class="fas fa-check-circle text-success mr-2"></i>
                            @elseif(str_contains($log->actionType, 'Hủy') || str_contains($log->actionType, 'thất bại'))
                                <i class="fas fa-times-circle text-danger mr-2"></i>
                            @else
                                <i class="fas fa-info-circle text-primary mr-2"></i>
                            @endif
                            
                            {{ $log->actionType }}
                        </div>
                        <span class="badge badge-light text-muted font-weight-normal">
                            <i class="fa-regular fa-clock"></i> {{ date('d/m/Y H:i', strtotime($log->timestamp)) }}
                        </span>
                    </li>
                @empty
                    <li class="list-group-item text-center py-4 text-muted">Chưa có hoạt động nào được ghi lại.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

@include('Clients.blocks.footer')