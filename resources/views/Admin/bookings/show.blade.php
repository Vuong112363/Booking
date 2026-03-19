@extends('adminlte::page')

@section('title', 'Chi tiết Booking #' . $booking->bookingid)

@section('content_header')
    <h1>Chi tiết Booking #{{ $booking->bookingid }}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Thông tin Đơn đặt Tour</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px">Khách hàng:</th>
                        <td>{{ $booking->user->username ?? 'Khách vãng lai' }} (Email: {{ $booking->user->email ?? 'N/A' }})</td>
                    </tr>
                    <tr>
                        <th>Tên Tour:</th>
                        <td><a href="#">{{ $booking->tour->title ?? 'Tour đã bị xóa' }}</a></td>
                    </tr>
                    <tr>
                        <th>Ngày đi dự kiến:</th>
                        <td>{{ \Carbon\Carbon::parse($booking->bookingdate)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Số lượng:</th>
                        <td>Người lớn: <b>{{ $booking->numadults }}</b> | Trẻ em: <b>{{ $booking->numchildren }}</b></td>
                    </tr>
                    <tr>
                        <th>Yêu cầu đặc biệt:</th>
                        <td>
                            @if($booking->specialrequest)
                                <div class="callout callout-warning">
                                    {{ $booking->specialrequest }}
                                </div>
                            @else
                                <i>Không có yêu cầu thêm</i>
                            @endif
                        </td>
                    </tr>
                    <tr class="bg-light">
                        <td colspan="2"><h5 class="mb-0 text-primary"><b>Thông Tin Thanh Toán</b></h5></td>
                    </tr>
                    <tr>
                        <th>Phương thức chọn:</th>
                        <td>
                            @if($booking->paymentmethod == 'momo')
                                <span class="badge bg-purple"><i class="fas fa-wallet"></i> Ví MoMo</span>
                            @elseif($booking->paymentmethod == 'cash')
                                <span class="badge bg-success"><i class="fas fa-money-bill-wave"></i> Tiền mặt / Chuyển khoản</span>
                            @else
                                {{ strtoupper($booking->paymentmethod) }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tổng tiền Tour:</th>
                        <td style="font-size: 1.1rem;">{{ number_format($booking->totalprice, 0, ',', '.') }} VNĐ</td>
                    </tr>
                    <tr>
                        <th>Yêu cầu cọc (30%):</th>
                        <td class="text-warning" style="font-weight: bold;">{{ number_format($booking->deposit_amount, 0, ',', '.') }} VNĐ</td>
                    </tr>
                    <tr>
                        <th>Số tiền ĐÃ THU:</th>
                        <td class="text-success" style="font-size: 1.3rem; font-weight: bold;">
                            {{ number_format($booking->paid_amount, 0, ',', '.') }} VNĐ
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Xử Lý Trạng Thái</h3>
            </div>
            <form action="{{ route('admin.bookings.update_status', $booking->bookingid) }}" method="POST">
                @csrf
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="form-group">
                        <label>Tình trạng hiện tại:</label>
                        <div>
                            @if($booking->bookingstatus == 'confirmed')
                                <span class="badge badge-success" style="font-size: 0.9rem;">Tour: Đã duyệt</span>
                            @elseif($booking->bookingstatus == 'pending')
                                <span class="badge badge-warning" style="font-size: 0.9rem;">Tour: Chờ xử lý</span>
                            @else
                                <span class="badge badge-danger" style="font-size: 0.9rem;">Tour: Đã hủy</span>
                            @endif

                            @if($booking->paymentstatus == 'unpaid')
                                <span class="badge badge-secondary" style="font-size: 0.9rem;">Tiền: Chưa thanh toán</span>
                            @elseif($booking->paymentstatus == 'deposit_paid')
                                <span class="badge badge-warning" style="font-size: 0.9rem;">Tiền: Đã cọc</span>
                            @elseif($booking->paymentstatus == 'paid')
                                <span class="badge badge-success" style="font-size: 0.9rem;">Tiền: Đã thu đủ</span>
                            @elseif($booking->paymentstatus == 'refund_pending')
                                <span class="badge badge-danger" style="font-size: 0.9rem;">Tiền: Chờ hoàn cọc</span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="form-group mt-2">
                        <label>Cập nhật trạng thái Tour:</label>
                        <select name="bookingstatus" class="form-control">
                            <option value="pending" {{ $booking->bookingstatus == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="confirmed" {{ $booking->bookingstatus == 'confirmed' ? 'selected' : '' }}>Duyệt đơn (Confirmed)</option>
                            <option value="cancelled" {{ $booking->bookingstatus == 'cancelled' ? 'selected' : '' }}>Hủy đơn (Cancelled)</option>
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label>Cập nhật trạng thái Thanh toán:</label>
                        <select name="paymentstatus" class="form-control">
                            <option value="unpaid" {{ $booking->paymentstatus == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                            <option value="deposit_paid" {{ $booking->paymentstatus == 'deposit_paid' ? 'selected' : '' }}>Xác nhận Đã thu cọc 30%</option>
                            <option value="paid" {{ $booking->paymentstatus == 'paid' ? 'selected' : '' }}>Xác nhận Đã thu đủ 100%</option>
                            <option value="refund_pending" {{ $booking->paymentstatus == 'refund_pending' ? 'selected' : '' }}>Chờ hoàn tiền (Refund)</option>
                        </select>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save"></i> Lưu Trạng Thái</button>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-default btn-block mt-2">Quay lại danh sách</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop