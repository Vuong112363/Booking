@extends('adminlte::page')

@section('title', 'Thêm Tour Mới')

@section('content_header')
    <h1>Tạo Tour Mới</h1>
@stop

@section('content')
<div class="card card-primary shadow">
    <div class="card-header">
        <h3 class="card-title text-bold">Nhập thông tin Tour</h3>
    </div>
    
    <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="card-body">
            {{-- 0. Hiển thị lỗi Validation --}}
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
                        <input type="text" name="title" class="form-control" placeholder="Nhập tên tour..." required value="{{ old('title') }}">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Điểm đến (*)</label>
                                <input type="text" name="destination" class="form-control" placeholder="VD: Nha Trang" required value="{{ old('destination') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Vùng miền (*)</label>
                                <select name="domain" class="form-control" required>
                                    <option value="b" {{ old('domain') == 'b' ? 'selected' : '' }}>Miền Bắc</option>
                                    <option value="t" {{ old('domain') == 't' ? 'selected' : '' }}>Miền Trung</option>
                                    <option value="n" {{ old('domain') == 'n' ? 'selected' : '' }}>Miền Nam</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Mô tả tổng quan</label>
                        <textarea name="description" id="editor" class="form-control" rows="5">{{ old('description') }}</textarea>
                    </div>
                </div>

                {{-- CỘT PHẢI: HÌNH ẢNH & ĐIỂM ĐÓN --}}
                <div class="col-md-5">
                    {{-- 1. Card Hình ảnh --}}
                    <div class="card card-outline card-info shadow-none border mb-3">
                        <div class="card-header">
                            <h3 class="card-title text-bold small"><i class="fas fa-images"></i> Tải lên hình ảnh</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-4">
                                <label class="text-danger small">1. Ảnh chính (Thumbnail) (*)</label>
                                <input type="file" name="image_main" id="main-image-input" class="form-control-file" accept="image/*" required>
                                <div id="main-image-preview" class="mt-2" style="display: none;">
                                    <img src="" class="img-thumbnail border-danger" style="height: 120px; width: 100%; object-fit: cover; border-radius: 8px;">
                                </div>
                            </div>

                            <div class="form-group border-top pt-3">
                                <label class="text-info small">2. Ảnh chi tiết (Gallery)</label>
                                <input type="file" name="image_gallery[]" id="gallery-image-input" class="form-control-file" accept="image/*" multiple>
                                <div id="gallery-image-preview" class="d-flex flex-wrap mt-2 gap-2"></div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Card Điểm đón (Nâng cấp từ trang Edit) --}}
                    <div class="card card-outline card-success shadow-none border">
                        <div class="card-header p-2">
                            <h3 class="card-title text-bold small mt-1"><i class="fas fa-bus mr-1"></i> Điểm đón & Phụ phí</h3>
                            <button type="button" class="btn btn-success btn-xs float-right" onclick="addPickupRow()">
                                <i class="fas fa-plus"></i> Thêm điểm đón
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr class="bg-light small text-center">
                                        <th>Tên điểm đón</th>
                                        <th width="75">Giờ</th>
                                        <th width="80">Phí</th>
                                        <th width="105">Cách tính</th>
                                        <th width="30"></th>
                                    </tr>
                                </thead>
                                <tbody id="pickup-container">
                                    {{-- Rows sẽ được thêm qua JavaScript --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            {{-- 3. THÔNG TIN GIÁ & THỜI GIAN --}}
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Thời lượng (Duration)</label>
                        <input type="text" name="time" class="form-control" placeholder="VD: Khởi hành T7 hàng tuần" value="{{ old('time') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Text phụ (Time)</label>
                        <input type="text" name="duration" class="form-control" placeholder="VD: 3N2Đ" value="{{ old('duration') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Giá người lớn (VNĐ) (*)</label>
                        <input type="number" name="priceadult" class="form-control" placeholder="Nhập giá cơ bản..." required value="{{ old('priceadult') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Giá trẻ em (VNĐ)</label>
                        <input type="number" name="pricechild" class="form-control" value="{{ old('pricechild', 0) }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Số chỗ (Đợt đầu)</label>
                        <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 20) }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select name="availability" class="form-control">
                            <option value="1" {{ old('availability') == '1' ? 'selected' : '' }}>Mở bán</option>
                            <option value="0" {{ old('availability') == '0' ? 'selected' : '' }}>Tạm ngưng</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Ngày khởi hành đợt 1</label>
                        <input type="date" name="startdate" class="form-control" value="{{ old('startdate') }}" min="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Ngày về đợt 1</label>
                        <input type="date" name="enddate" class="form-control" value="{{ old('enddate') }}">
                    </div>
                </div>
            </div>

            <hr>

            {{-- 4. LỊCH TRÌNH CHI TIẾT (Timeline) --}}
            <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                <h4 class="text-info m-0 font-weight-bold"><i class="fas fa-calendar-alt mr-2"></i>Lịch trình chi tiết theo ngày</h4>
                <button type="button" class="btn btn-sm btn-success shadow-sm" onclick="addTimeline()">
                    <i class="fas fa-plus"></i> Thêm ngày mới
                </button>
            </div>
            
            <div class="accordion" id="timeline-wrapper">
    {{-- Nếu là trang Create, để sẵn 1 form trống. Nếu trang Edit, dùng vòng lặp @foreach --}}
    <div class="card card-outline card-secondary mb-3 timeline-item shadow-sm border">
        <div class="card-header p-2 bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <button class="btn btn-link text-left text-dark font-weight-bold flex-grow-1 text-decoration-none" type="button" data-toggle="collapse" data-target="#collapse-0">
                    <i class="fas fa-angle-down mr-2 text-primary"></i> 
                    Ngày <span class="day-number">1</span>: 
                    <span class="preview-title text-primary">Hà Nội - Điểm đến...</span>
                </button>
                <button type="button" class="btn btn-sm btn-danger border-0 shadow-sm" onclick="removeTimeline(this)" title="Xóa ngày này">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>

        <div id="collapse-0" class="collapse show" data-parent="#timeline-wrapper">
            <div class="card-body">
                <div class="form-group">
                    <label class="text-muted small">Tiêu đề hành trình (VD: Hà Nội - Sapa - Bản Cát Cát)</label>
                    <input type="text" name="timeline_title[]" class="form-control title-input font-weight-bold" placeholder="Nhập lộ trình di chuyển..." onkeyup="updatePreviewTitle(this)" required>
                </div>
                <div class="form-group mb-0">
                    <label class="text-muted small">Mô tả chi tiết (Các bữa ăn, điểm tham quan, hoạt động...)</label>
                    {{-- Thêm class timeline-editor để JS nhận diện gắn CKEditor --}}
                    <textarea name="timeline_description[]" class="form-control timeline-editor" rows="4"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
        <div class="row mt-4">
    {{-- Cột: Dịch vụ bao gồm --}}
    <div class="col-md-6 border-right">
        <h6 class="text-bold text-success"><i class="fa fa-check-circle"></i> Dịch vụ bao gồm</h6>
        
        {{-- Ô nhập nhanh --}}
        <div class="form-group mb-2">
            <textarea id="bulk-include" class="form-control form-control-sm" rows="2" placeholder="Dán danh sách tại đây, mỗi dịch vụ 1 dòng rồi nhấn Enter..."></textarea>
            <button type="button" class="btn btn-xs btn-info mt-1" onclick="handleBulkAdd('bulk-include', 'box-includes', 'tour_includes[]')">
                <i class="fas fa-bolt"></i> Thêm hàng loạt
            </button>
        </div>

        <div id="box-includes" class="mb-2 shadow-sm p-2 bg-white rounded" style="max-height: 300px; overflow-y: auto;">
            {{-- Dùng old() để không bị mất dữ liệu nếu Admin nhập thiếu thông tin khác bị load lại trang --}}
            @if(old('tour_includes'))
                @foreach(old('tour_includes') as $item)
                    <div class="input-group mb-2">
                        <input type="text" name="tour_includes[]" class="form-control" value="{{ $item }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.parentElement.remove()"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                @endforeach
            @else
                {{-- Mặc định để sẵn 1 ô trống --}}
                <div class="input-group mb-2">
                    <input type="text" name="tour_includes[]" class="form-control" placeholder="Nhập dịch vụ...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.parentElement.remove()"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            @endif
        </div>
        <button type="button" class="btn btn-outline-success btn-sm btn-block" onclick="addNewRow('box-includes', 'tour_includes[]')">+ Thêm 1 dòng</button>
    </div>

    {{-- Cột: Không bao gồm --}}
    <div class="col-md-6">
        <h6 class="text-bold text-danger"><i class="fa fa-times-circle"></i> Không bao gồm</h6>
        
        {{-- Ô nhập nhanh --}}
        <div class="form-group mb-2">
            <textarea id="bulk-exclude" class="form-control form-control-sm" rows="2" placeholder="Dán danh sách chi phí không bao gồm tại đây..."></textarea>
            <button type="button" class="btn btn-xs btn-info mt-1" onclick="handleBulkAdd('bulk-exclude', 'box-excludes', 'tour_excludes[]')">
                <i class="fas fa-bolt"></i> Thêm hàng loạt
            </button>
        </div>

        <div id="box-excludes" class="mb-2 shadow-sm p-2 bg-white rounded" style="max-height: 300px; overflow-y: auto;">
            @if(old('tour_excludes'))
                @foreach(old('tour_excludes') as $item)
                    <div class="input-group mb-2">
                        <input type="text" name="tour_excludes[]" class="form-control" value="{{ $item }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.parentElement.remove()"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="input-group mb-2">
                    <input type="text" name="tour_excludes[]" class="form-control" placeholder="Nhập chi phí ngoài...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.parentElement.remove()"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            @endif
        </div>
        <button type="button" class="btn btn-outline-danger btn-sm btn-block" onclick="addNewRow('box-excludes', 'tour_excludes[]')">+ Thêm 1 dòng</button>
    </div>
</div>

        <div class="card-footer text-right bg-white border-top">
            <a href="{{ route('admin.tours.index') }}" class="btn btn-default btn-lg mr-2 border">Hủy bỏ</a>
            <button type="submit" class="btn btn-primary btn-lg shadow px-5"><i class="fas fa-save mr-1"></i> LƯU TOUR MỚI</button>
        </div>
    </form>
</div>
@stop

@section('css')
    <style>
        .ck-editor__editable_inline { min-height: 250px; }
        .gap-2 { gap: 0.5rem; }
        .btn-link:hover, .btn-link:focus { text-decoration: none; }
        .accordion .card-header button[aria-expanded="true"] i.fa-angle-down {
            transform: rotate(180deg);
            transition: transform 0.3s;
        }
        .accordion .card-header button[aria-expanded="false"] i.fa-angle-down {
            transition: transform 0.3s;
        }
        /* CSS cho bảng điểm đón thu nhỏ */
        #pickup-container input, #pickup-container select { 
            font-size: 13px; 
            padding: 2px 5px;
            height: 30px;
        }
    </style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        // Hiển thị thông báo Thành công khi được Redirect về đây
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        @endif

        // Bắt luôn cả thông báo Lỗi nếu có
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Thất bại!',
                text: '{{ session('error') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
            });
        @endif
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        // 1. CKEditor
        ClassicEditor.create(document.querySelector('#editor')).catch(error => { console.error(error); });

        // 2. Preview Ảnh Chính (thumbnail)
        const mainInput = document.getElementById('main-image-input');
        const mainPreview = document.getElementById('main-image-preview');

        mainInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    mainPreview.querySelector('img').src = event.target.result;
                    mainPreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                mainPreview.style.display = 'none';
            }
        });

        // 3. Preview Gallery
        const galleryInput = document.getElementById('gallery-image-input');
        const galleryPreview = document.getElementById('gallery-image-preview');

        galleryInput.addEventListener('change', function(e) {
            galleryPreview.innerHTML = ''; 
            const files = Array.from(e.target.files);
            if (files.length > 5) alert("Bạn chỉ nên chọn tối đa 5 ảnh chi tiết.");

            files.slice(0, 5).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const imgBox = document.createElement('div');
                    imgBox.className = 'mr-2 mb-2';
                    imgBox.innerHTML = `<img src="${event.target.result}" class="img-thumbnail" style="height: 60px; width: 60px; object-fit: cover; border-radius: 5px;">`;
                    galleryPreview.appendChild(imgBox);
                }
                reader.readAsDataURL(file);
            });
        });

        // 4. Lịch trình động (Timeline)
        function addTimeline() {
            const wrapper = document.getElementById('timeline-wrapper');
            const count = wrapper.querySelectorAll('.timeline-item').length + 1;
            const uniqueId = Date.now(); 

            const html = `
            <div class="card card-outline card-secondary mb-2 timeline-item border shadow-none">
                <div class="card-header p-2" id="heading-${uniqueId}">
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-link text-left text-dark font-weight-bold flex-grow-1 text-decoration-none" type="button" data-toggle="collapse" data-target="#collapse-${uniqueId}" aria-expanded="true">
                            <i class="fas fa-angle-down mr-2 text-muted"></i> Ngày <span class="day-number">${count}</span>: 
                            <span class="preview-title text-primary">Tiêu đề mới...</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger border-0" onclick="removeTimeline(this)"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div id="collapse-${uniqueId}" class="collapse show" data-parent="#timeline-wrapper">
                    <div class="card-body bg-light">
                        <div class="form-group">
                            <label>Tiêu đề ngày</label>
                            <input type="text" name="timeline_title[]" class="form-control title-input" onkeyup="updatePreviewTitle(this)" required>
                        </div>
                        <div class="form-group mb-0">
                            <label>Mô tả chi tiết</label>
                            <textarea name="timeline_description[]" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>
            </div>`;
            wrapper.insertAdjacentHTML('beforeend', html);
            reindexDays(); 
        }

        function removeTimeline(btn) {
            if(confirm('Xác nhận xóa ngày này khỏi lịch trình?')) {
                btn.closest('.timeline-item').remove();
                reindexDays(); 
            }
        }

        function updatePreviewTitle(input) {
            const previewSpan = input.closest('.timeline-item').querySelector('.preview-title');
            previewSpan.textContent = input.value ? input.value : 'Đang cập nhật...';
        }

        function reindexDays() {
            document.querySelectorAll('.timeline-item').forEach((item, index) => {
                item.querySelector('.day-number').textContent = index + 1;
            });
        }

        // 5. Thêm Điểm đón (Logic đầy đủ giống Edit)
        function addPickupRow() {
            const html = `
            <tr>
                <td><input type="text" name="pk_name[]" class="form-control" placeholder="Địa điểm..." required></td>
                <td><input type="time" name="pk_time[]" class="form-control" required></td>
                <td><input type="number" name="pk_price[]" class="form-control" value="0"></td>
                <td>
                    <select name="pk_type[]" class="form-control">
                        <option value="0">Mỗi khách</option>
                        <option value="1">Cả đoàn</option>
                    </select>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-link text-danger p-0" onclick="$(this).closest('tr').remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>`;
            document.getElementById('pickup-container').insertAdjacentHTML('beforeend', html);
        }
    </script>
    <script>
// Hàm thêm hàng loạt từ Textarea
function handleBulkAdd(textareaId, containerId, inputName) {
    const textarea = document.getElementById(textareaId);
    const container = document.getElementById(containerId);
    const lines = textarea.value.split('\n'); // Tách theo dòng

    lines.forEach(line => {
        const cleanLine = line.trim();
        if (cleanLine !== "") {
            const div = document.createElement('div');
            div.className = 'input-group mb-2 animate__animated animate__fadeInIn'; // Thêm hiệu ứng nếu có animate.css
            div.innerHTML = `
                <input type="text" name="${inputName}" class="form-control" value="${cleanLine}">
                <div class="input-group-append">
                    <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            container.appendChild(div);
        }
    });

    textarea.value = ""; // Xóa trắng textarea sau khi thêm xong
}

// Giữ lại hàm thêm 1 dòng cũ cho nhu cầu nhập lẻ
function addNewRow(containerId, inputName) {
    const container = document.getElementById(containerId);
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" name="${inputName}" class="form-control" placeholder="Nhập nội dung...">
        <div class="input-group-append">
            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
}
// Khởi tạo CKEditor cho các ô textarea đã có sẵn lúc load trang
document.querySelectorAll('.timeline-editor').forEach((el) => {
    ClassicEditor.create(el).catch(error => console.error(error));
});

function addTimeline() {
    const wrapper = document.getElementById('timeline-wrapper');
    const count = wrapper.querySelectorAll('.timeline-item').length + 1;
    const uniqueId = Date.now(); 

    const html = `
    <div class="card card-outline card-secondary mb-3 timeline-item shadow-sm border animate__animated animate__fadeIn">
        <div class="card-header p-2 bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <button class="btn btn-link text-left text-dark font-weight-bold flex-grow-1 text-decoration-none" type="button" data-toggle="collapse" data-target="#collapse-${uniqueId}">
                    <i class="fas fa-angle-down mr-2 text-primary"></i> Ngày <span class="day-number">${count}</span>: 
                    <span class="preview-title text-primary">Tiêu đề mới...</span>
                </button>
                <button type="button" class="btn btn-sm btn-danger border-0 shadow-sm" onclick="removeTimeline(this)">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
        <div id="collapse-${uniqueId}" class="collapse show" data-parent="#timeline-wrapper">
            <div class="card-body">
                <div class="form-group">
                    <label class="text-muted small">Tiêu đề hành trình</label>
                    <input type="text" name="timeline_title[]" class="form-control title-input font-weight-bold" onkeyup="updatePreviewTitle(this)" required>
                </div>
                <div class="form-group mb-0">
                    <label class="text-muted small">Mô tả chi tiết</label>
                    <textarea id="editor-${uniqueId}" name="timeline_description[]" class="form-control"></textarea>
                </div>
            </div>
        </div>
    </div>`;
    
    wrapper.insertAdjacentHTML('beforeend', html);

    // KÍCH HOẠT CKEDITOR CHO Ô TEXTAREA VỪA ĐƯỢC TẠO RA
    ClassicEditor.create(document.querySelector(`#editor-${uniqueId}`)).catch(error => console.error(error));

    // Cuộn trang xuống thẻ vừa tạo cho mượt
    window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
}

function removeTimeline(btn) {
    if(confirm('Bạn có chắc chắn muốn xóa lịch trình ngày này?')) {
        btn.closest('.timeline-item').remove();
        // Đánh lại số thứ tự Ngày
        document.querySelectorAll('.timeline-item').forEach((item, index) => {
            item.querySelector('.day-number').textContent = index + 1;
        });
    }
}

function updatePreviewTitle(input) {
    const preview = input.closest('.timeline-item').querySelector('.preview-title');
    preview.textContent = input.value || 'Đang cập nhật...';
}
</script>
@stop