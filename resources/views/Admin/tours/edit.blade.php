@extends('adminlte::page')

@section('title', 'Cập nhật Tour')

@section('content_header')
    <h1>Cập nhật Tour: #{{ $tour->tourid }}</h1>
@stop

@section('content')
<div class="card card-warning shadow">
    <div class="card-header">
        <h3 class="card-title text-bold">Chỉnh sửa thông tin chi tiết</h3>
    </div>
    
    <form id="tour-form" action="{{ route('admin.tours.update', $tour->tourid) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                {{-- CỘT TRÁI: THÔNG TIN CƠ BẢN --}}
                <div class="col-md-7">
                    <div class="form-group">
                        <label>Tên Tour (*)</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $tour->title) }}" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Điểm đến</label>
                                <input type="text" name="destination" class="form-control" value="{{ old('destination', $tour->destination) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Vùng miền (*)</label>
                                <select name="domain" class="form-control" required>
                                    <option value="b" {{ old('domain', $tour->domain) == 'b' ? 'selected' : '' }}>Miền Bắc</option>
                                    <option value="t" {{ old('domain', $tour->domain) == 't' ? 'selected' : '' }}>Miền Trung</option>
                                    <option value="n" {{ old('domain', $tour->domain) == 'n' ? 'selected' : '' }}>Miền Nam</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Mô tả tổng quan</label>
                        <textarea name="description" id="editor" class="form-control">{{ old('description', $tour->description) }}</textarea>
                    </div>
                </div>

                {{-- CỘT PHẢI: HÌNH ẢNH & THÔNG TIN PHỤ --}}
                <div class="col-md-5">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title text-bold"><i class="fas fa-images"></i> Quản lý hình ảnh</h3>
                        </div>
                        <div class="card-body">
                            {{-- 1. Ảnh chính --}}
                            <div class="form-group mb-4">
                                <label class="text-danger">1. Ảnh chính (Thumbnail) (*)</label>
                                <div class="mb-3 p-2 border rounded bg-light">
                                    <label class="d-block text-muted small mb-2">Ảnh đang dùng:</label>
                                    @if($tour->images)
                                        <img src="{{ asset('clients/assets/images/gallery-tours/' . $tour->images) }}" style="height: 100px; object-fit: cover; border-radius: 5px; border: 1px solid #ccc;">
                                    @else
                                        <span class="text-muted"><i class="fas fa-image"></i> Chưa có ảnh chính</span>
                                    @endif
                                </div>
                                <label class="small text-info">Chọn ảnh thay thế:</label>
                                <input type="file" name="image_main" id="main-image-input" class="form-control-file" accept="image/*">
                            </div>

                            {{-- 2. Gallery --}}
                            <div class="form-group border-top pt-3">
                                <label class="text-info">2. Ảnh chi tiết (Gallery)</label>
                                <div class="mb-3 p-2 border rounded bg-light">
                                    <label class="d-block text-muted small mb-2">Ảnh cũ (X để xóa):</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($tour->tourImages as $img)
                                            <div class="old-image-wrapper position-relative mr-2 mb-2">
                                                <img src="{{ asset('clients/assets/images/gallery-tours/' . $img->imageurl) }}" style="height: 60px; width: 60px; object-fit: cover; border-radius: 3px;">
                                                <button type="button" class="btn btn-danger btn-xs position-absolute" style="top:-5px; right:-5px; border-radius:50%; width:20px; height:20px; padding:0;" onclick="removeOldImage({{ $img->imageid }}, this)">
                                                    <i class="fas fa-times" style="font-size: 10px;"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <label class="small text-success">Thêm ảnh mới:</label>
                                <input type="file" name="image_gallery[]" id="gallery-image-input" class="form-control-file" accept="image/*" multiple>
                            </div>
                        </div>
                    </div>

                    {{-- THÔNG TIN PHỤ (VẪN CẦN ĐỂ HIỂN THỊ BADGE NGOÀI GRID) --}}
                    <div class="card card-outline card-secondary shadow-sm">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Trạng thái Tour</label>
                                <select name="availability" class="form-control">
                                    <option value="1" {{ $tour->availability == 1 ? 'selected' : '' }}>Mở bán</option>
                                    <option value="0" {{ $tour->availability == 0 ? 'selected' : '' }}>Tạm ngưng</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Thời lượng (VD: 3 Ngày 2 Đêm)</label>
                                <input type="text" name="duration" class="form-control" value="{{ old('duration', $tour->duration) }}">
                            </div>
                            <div class="form-group">
                                <label>Ghi chú khởi hành (VD: Thứ 7 hàng tuần)</label>
                                <input type="text" name="time" class="form-control" value="{{ old('time', $tour->time) }}">
                            </div>
                        </div>
                    </div>
                    <div class="card card-outline card-success mt-4">
    <div class="card-header">
        <h3 class="card-title text-bold"><i class="fas fa-bus mr-2"></i>Điểm đón & Phụ phí</h3>
        <button type="button" class="btn btn-success btn-sm float-right" onclick="addPickupRow()">
            <i class="fas fa-plus"></i> Thêm điểm đón
        </button>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead>
                <tr class="bg-light">
                    <th>Tên điểm đón (VD: Đón tại nhà)</th>
                    <th>Giờ</th>
                    <th>Phụ phí</th>
                    <th>Cách tính phí</th>
                    <th width="50"></th>
                </tr>
            </thead>
            <tbody id="pickup-container">
                @foreach($tour->pickupPoints as $pk)
                <tr>
                    <td><input type="text" name="pk_name[]" class="form-control" value="{{ $pk->pickup_name }}"></td>
                    <td><input type="time" name="pk_time[]" class="form-control" value="{{ $pk->pickup_time }}"></td>
                    <td><input type="number" name="pk_price[]" class="form-control" value="{{ $pk->extra_price }}"></td>
                    <td>
                        <select name="pk_type[]" class="form-control">
                            <option value="0" {{ $pk->fee_type == 0 ? 'selected' : '' }}>Mỗi khách</option>
                            <option value="1" {{ $pk->fee_type == 1 ? 'selected' : '' }}>Cả đoàn (Cố định)</option>
                        </select>
                    </td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="$(this).closest('tr').remove()"><i class="fas fa-trash"></i></button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
                </div>
            </div>

            <hr>

            {{-- QUẢN LÝ LỊCH TRÌNH CHI TIẾT --}}
            <div class="card card-outline card-primary shadow-sm mb-4">
                <div class="card-header">
                    <h3 class="card-title text-bold text-primary"><i class="fas fa-calendar-alt mr-2"></i>Các đợt khởi hành & Giá thực tế</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-add-schedule">
                            <i class="fas fa-plus mr-1"></i> Thêm ngày đi mới
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Ngày đi - Ngày về</th>
                                <th>Giá NL / Trẻ em</th>
                                <th>Số lượng</th>
                                <th>Đã đặt</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="schedule-list">
                            @forelse($tour->schedules as $sch)
                            <tr id="sch-row-{{ $sch->schedule_id }}">
                                <td>
                                    <span class="text-primary font-weight-bold">{{ date('d/m/Y', strtotime($sch->startdate)) }}</span>
                                    <i class="fas fa-arrow-right mx-1 small text-muted"></i>
                                    <span class="text-secondary">{{ $sch->enddate ? date('d/m/Y', strtotime($sch->enddate)) : '---' }}</span>
                                </td>
                                <td>{{ number_format($sch->priceadult, 0, ',', '.') }}đ / <small>{{ number_format($sch->pricechild, 0, ',', '.') }}đ</small></td>
                                <td>{{ $sch->quantity }} chỗ</td>
                                <td><span class="badge badge-info">{{ $sch->booked_count ?? 0 }} khách</span></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-danger border-0" onclick="deleteSchedule({{ $sch->schedule_id }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr id="no-schedule"><td colspan="5" class="text-center text-muted py-3">Chưa có lịch trình khởi hành nào.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <hr>
            
            {{-- LỊCH TRÌNH CHI TIẾT (TIMELINE) --}}
            <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                <h4 class="text-info m-0"><i class="fas fa-map-signs"></i> Lịch trình chi tiết theo ngày</h4>
                <button type="button" class="btn btn-sm btn-success shadow-sm" onclick="addTimeline()">
                    <i class="fas fa-plus"></i> Thêm ngày mới
                </button>
            </div>
            
            <div class="accordion" id="timeline-wrapper">
                @foreach($tour->timeline as $index => $item)
                    <div class="card card-outline card-secondary mb-2 timeline-item">
                        <div class="card-header p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-link text-left text-dark font-weight-bold flex-grow-1 text-decoration-none" type="button" data-toggle="collapse" data-target="#collapse-{{ $index }}">
                                    <i class="fas fa-angle-down mr-2 text-muted"></i> Ngày <span class="day-number">{{ $index + 1 }}</span>: <span class="preview-title text-primary">{{ $item->title }}</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger border-0" onclick="removeTimeline(this)"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        <div id="collapse-{{ $index }}" class="collapse {{ $index == 0 ? 'show' : '' }}" data-parent="#timeline-wrapper">
                            <div class="card-body bg-light">
                                <input type="text" name="timeline_title[]" class="form-control title-input mb-2" value="{{ $item->title }}" required onkeyup="updatePreviewTitle(this)">
                                <textarea name="timeline_description[]" class="form-control" rows="4">{{ $item->description }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card-footer bg-white text-right">
            <a href="{{ route('admin.tours.index') }}" class="btn btn-default mr-2 btn-lg">Hủy bỏ</a>
            <button type="submit" class="btn btn-warning btn-lg shadow"><i class="fas fa-save"></i> LƯU TẤT CẢ THAY ĐỔI</button>
        </div>
    </form>
</div>

{{-- MODAL THÊM LỊCH TRÌNH --}}
<div class="modal fade" id="modal-add-schedule" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold">Thêm đợt khởi hành mới</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ngày khởi hành <span class="text-danger">*</span></label>
                            <input type="date" id="new_sch_date" class="form-control" min="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ngày kết thúc <span class="text-danger">*</span></label>
                            <input type="date" id="new_sch_end_date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Giá Người lớn <span class="text-danger">*</span></label>
                            <input type="number" id="new_sch_price" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Giá Trẻ em</label>
                            <input type="number" id="new_sch_price_child" class="form-control" value="0">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Số lượng chỗ trống</label>
                    <input type="number" id="new_sch_qty" class="form-control" value="20">
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary px-4" id="btn-save-schedule">Lưu đợt này</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        .ck-editor__editable_inline { min-height: 250px; }
        .accordion .card-header button[aria-expanded="true"] i.fa-angle-down { transform: rotate(180deg); transition: 0.3s; }
        .old-image-wrapper img { border: 1px solid #ddd; padding: 2px; background: #fff; }
    </style>
@stop

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#editor')).catch(error => { console.error(error); });

        // AJAX THÊM LỊCH TRÌNH
        $('#btn-save-schedule').on('click', function() {
            const data = {
                _token: "{{ csrf_token() }}",
                tourid: "{{ $tour->tourid }}",
                startdate: $('#new_sch_date').val(),
                enddate: $('#new_sch_end_date').val(),
                priceadult: $('#new_sch_price').val(),
                pricechild: $('#new_sch_price_child').val(),
                quantity: $('#new_sch_qty').val()
            };

            if(!data.startdate || !data.priceadult) {
                alert('Vui lòng nhập ngày khởi hành và giá người lớn!');
                return;
            }

            $.ajax({
                url: "{{ route('admin.tours.schedule.add') }}",
                method: "POST",
                data: data,
                success: function(res) {
                    if(res.success) {
                        alert('Đã thêm thành công!');
                        location.reload();
                    }
                },
                error: function(err) { alert('Lỗi: ' + err.responseJSON.message); }
            });
        });

        function deleteSchedule(id) {
            if(confirm('Bạn có chắc muốn xóa đợt này?')) {
                $.ajax({
                    url: "/admin/tours/schedule/delete/" + id,
                    method: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function(res) {
                        if(res.success) $(`#sch-row-${id}`).fadeOut();
                    },
                    error: function(err) { alert(err.responseJSON.message); }
                });
            }
        }

        // XỬ LÝ ẢNH & TIMELINE
        function removeOldImage(imageId, btnElement) {
            if(confirm('Xóa ảnh này?')) {
                $('#tour-form').append(`<input type="hidden" name="delete_images[]" value="${imageId}">`);
                $(btnElement).closest('.old-image-wrapper').remove();
            }
        }

        function addTimeline() {
            const wrapper = document.getElementById('timeline-wrapper');
            const count = wrapper.querySelectorAll('.timeline-item').length + 1;
            const uniqueId = Date.now(); 
            const html = `
            <div class="card card-outline card-secondary mb-2 timeline-item">
                <div class="card-header p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-link text-left text-dark font-weight-bold flex-grow-1" type="button" data-toggle="collapse" data-target="#collapse-${uniqueId}">
                            Ngày <span class="day-number">${count}</span>: <span class="preview-title text-primary">Tiêu đề mới...</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeTimeline(this)"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div id="collapse-${uniqueId}" class="collapse show" data-parent="#timeline-wrapper">
                    <div class="card-body bg-light">
                        <input type="text" name="timeline_title[]" class="form-control title-input mb-2" onkeyup="updatePreviewTitle(this)" required>
                        <textarea name="timeline_description[]" class="form-control" rows="4"></textarea>
                    </div>
                </div>
            </div>`;
            wrapper.insertAdjacentHTML('beforeend', html);
        }

        function removeTimeline(btn) { 
            if(confirm('Xóa ngày này?')) {
                btn.closest('.timeline-item').remove(); 
                document.querySelectorAll('.timeline-item').forEach((item, index) => {
                    item.querySelector('.day-number').textContent = index + 1;
                });
            }
        }

        function updatePreviewTitle(input) {
            const preview = input.closest('.timeline-item').querySelector('.preview-title');
            preview.textContent = input.value || 'Tiêu đề...';
        }

        
        function addPickupRow() {
            let html = `
            <tr>
                <td><input type="text" name="pk_name[]" class="form-control" placeholder="Nhập tên điểm..." required></td>
                <td><input type="time" name="pk_time[]" class="form-control" required></td>
                <td><input type="number" name="pk_price[]" class="form-control" value="0"></td>
                <td>
                    <select name="pk_type[]" class="form-control">
                        <option value="0">Mỗi khách</option>
                        <option value="1">Cả đoàn (Cố định)</option>
                    </select>
                </td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="$(this).closest('tr').remove()"><i class="fas fa-trash"></i></button></td>
            </tr>`;
            $('#pickup-container').append(html);
        }
    </script>
@stop