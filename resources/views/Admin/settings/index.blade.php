@extends('adminlte::page')

@section('title', 'Cài đặt hệ thống')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-cogs text-info"></i> Quản lý Cài đặt hệ thống</h1>
    </div>
@stop

@section('css')
<style>
    /* Tuỳ chỉnh tab */
    .nav-tabs .nav-link { color: #475569; font-weight: 500; border: none; border-bottom: 3px solid transparent; padding: 12px 20px; }
    .nav-tabs .nav-link:hover { color: #17a2b8; border-bottom: 3px solid #cbd5e1; }
    .nav-tabs .nav-link.active { color: #17a2b8; border-bottom: 3px solid #17a2b8; background: transparent; font-weight: bold; }
    
    /* Khu vực preview ảnh */
    .image-preview-box { border: 2px dashed #cbd5e1; border-radius: 8px; padding: 15px; text-align: center; background: #f8fafc; transition: all 0.3s; }
    .image-preview-box:hover { border-color: #17a2b8; background: #f0f9ff; }
    .image-preview-box img { max-height: 120px; object-fit: contain; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    
    /* Input group chuyên nghiệp */
    .input-group-text { background-color: #f8fafc; color: #64748b; border-right: none; }
    .input-group .form-control { border-left: none; }
    .input-group .form-control:focus { box-shadow: none; border-color: #ced4da; }
    .input-group:focus-within .input-group-text, .input-group:focus-within .form-control { border-color: #17a2b8; color: #17a2b8; }
</style>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="card card-outline card-info shadow-sm border-0">
                <div class="card-header p-0 pt-2 border-bottom">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-general-tab" data-toggle="pill" href="#tab-general" role="tab"><i class="fas fa-desktop mr-1"></i> Cấu hình chung</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-ai-tab" data-toggle="pill" href="#tab-ai" role="tab"><i class="fas fa-robot mr-1"></i> AI (Gemini)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-momo-tab" data-toggle="pill" href="#tab-momo" role="tab"><i class="fas fa-wallet mr-1"></i> Thanh toán MoMo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-social-tab" data-toggle="pill" href="#tab-social" role="tab"><i class="fas fa-share-alt mr-1"></i> Mạng xã hội</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-advanced-tab" data-toggle="pill" href="#tab-advanced" role="tab"><i class="fas fa-code mr-1"></i> Nâng cao</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-email-tab" data-toggle="pill" href="#tab-email" role="tab"><i class="fas fa-envelope mr-1"></i> Email (SMTP)</a>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body p-4">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        
                        <div class="tab-pane fade show active" id="tab-general" role="tabpanel">
                            <div class="row">
                                <div class="col-md-7 border-right pr-4">
                                    <h5 class="text-info mb-4"><i class="fas fa-info-circle"></i> Thông tin doanh nghiệp</h5>
                                    
                                    <div class="form-group">
                                        <label>Tên Website</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-globe"></i></span></div>
                                            <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? 'GoViet Travel' }}">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Hotline</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-phone-alt"></i></span></div>
                                                <input type="text" name="hotline" class="form-control" value="{{ $settings['hotline'] ?? '' }}" placeholder="09xxxxxxx">
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Email liên hệ</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                                                <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? '' }}" placeholder="lienhe@goviet.com">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Địa chỉ văn phòng</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span></div>
                                            <textarea name="company_address" class="form-control" rows="2" placeholder="Nhập địa chỉ công ty...">{{ $settings['company_address'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-5 pl-4">
                                    <h5 class="text-info mb-4"><i class="fas fa-images"></i> Nhận diện thương hiệu</h5>
                                    
                                    <div class="form-group">
                                        <label>Logo Website</label>
                                        <div class="custom-file mb-2">
                                            <input type="file" name="site_logo" class="custom-file-input" id="logo_input" accept="image/*">
                                            <label class="custom-file-label text-muted">Chọn file logo (PNG, JPG)...</label>
                                        </div>
                                        <div class="image-preview-box mt-2">
                                            <img id="logo_preview" src="{{ isset($settings['site_logo']) ? asset($settings['site_logo']) : asset('clients/assets/images/logos/logo.png') }}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group mt-4">
                                        <label>Favicon (Icon tab trình duyệt)</label>
                                        <div class="d-flex align-items-center">
                                            @if(isset($settings['site_favicon']))
                                                <img src="{{ asset($settings['site_favicon']) }}" class="mr-3 shadow-sm rounded" style="width: 40px; height: 40px; object-fit: cover; border: 1px solid #ddd;">
                                            @else
                                                <div class="mr-3 d-flex align-items-center justify-content-center bg-light rounded" style="width: 40px; height: 40px; border: 1px solid #ddd;"><i class="fas fa-globe text-muted"></i></div>
                                            @endif
                                            <input type="file" name="site_favicon" class="form-control-file" accept=".ico,.png">
                                        </div>
                                        <small class="text-muted d-block mt-1">Khuyên dùng ảnh vuông 32x32px (.ico, .png)</small>
                                    </div>
                                    
                                    <hr>
                                    <div class="form-group">
                                        <label>Banner Trang Chủ (Hero)</label>
                                        <div class="custom-file mb-2">
                                            <input type="file" name="hero_banner" class="custom-file-input" id="hero_banner_input" accept="image/*">
                                            <label class="custom-file-label text-muted">Chọn ảnh banner to...</label>
                                        </div>
                                        <div class="image-preview-box mt-2">
                                            <img id="banner_preview" src="{{ isset($settings['hero_banner']) ? asset($settings['hero_banner']) : asset('clients/assets/images/hero/hero.jpg') }}" class="w-100" style="object-fit: cover;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-ai" role="tabpanel">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="text-center mb-4">
                                        <i class="fas fa-robot fa-3x text-info mb-2"></i>
                                        <h4>Trợ lý Trí tuệ nhân tạo (Gemini)</h4>
                                        <p class="text-muted">Cấu hình API Key để kích hoạt Bot Chat tự động trả lời khách hàng.</p>
                                    </div>
                                    
                                    <div class="alert alert-default-info shadow-sm border-info">
                                        <i class="fas fa-info-circle text-info mr-1"></i> Vui lòng lấy API Key miễn phí tại trang <a href="https://aistudio.google.com/" target="_blank" class="font-weight-bold text-info text-decoration-underline">Google AI Studio</a>.
                                    </div>
                                    
                                    <div class="form-group mt-4">
                                        <label>Gemini API Key</label>
                                        <div class="input-group input-group-lg">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-key text-warning"></i></span></div>
                                            <input type="password" name="gemini_api_key" class="form-control font-weight-bold text-primary" value="{{ $settings['gemini_api_key'] ?? '' }}" placeholder="AIzaSyAxxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
                                        </div>
                                        <small class="text-muted mt-2 d-block"><i class="fas fa-shield-alt text-success"></i> API Key của bạn được mã hóa và bảo mật an toàn.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-momo" role="tabpanel">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="text-center mb-4">
                                        <div class="d-inline-block bg-light p-3 rounded-circle mb-2 shadow-sm">
                                            <i class="fas fa-wallet fa-2x" style="color: #a50064;"></i>
                                        </div>
                                        <h4 style="color: #a50064;">Cổng thanh toán MoMo</h4>
                                    </div>
                                    
                                    <div class="alert alert-light border shadow-sm">
                                        <i class="fas fa-info-circle text-info"></i> Lấy các thông số dưới đây tại trang quản trị <a href="https://business.momo.vn" target="_blank" class="font-weight-bold">MoMo For Business</a>.
                                    </div>
                                    
                                    <div class="form-group mt-3">
                                        <label>Partner Code</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-id-badge"></i></span></div>
                                            <input type="text" name="momo_partner_code" class="form-control" value="{{ $settings['momo_partner_code'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Access Key</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-unlock-alt"></i></span></div>
                                            <input type="text" name="momo_access_key" class="form-control" value="{{ $settings['momo_access_key'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Secret Key</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user-secret"></i></span></div>
                                            <input type="password" name="momo_secret_key" class="form-control" value="{{ $settings['momo_secret_key'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Môi trường thanh toán</label>
                                        <select name="momo_environment" class="form-control custom-select">
                                            <option value="https://test-payment.momo.vn/v2/gateway/api/create" {{ ($settings['momo_environment'] ?? '') != 'https://payment.momo.vn/v2/gateway/api/create' ? 'selected' : '' }}>Chế độ TEST (Sandbox - Dùng để thử nghiệm)</option>
                                            <option value="https://payment.momo.vn/v2/gateway/api/create" {{ ($settings['momo_environment'] ?? '') == 'https://payment.momo.vn/v2/gateway/api/create' ? 'selected' : '' }}>Chế độ LIVE (Production - Thu tiền thật)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-social" role="tabpanel">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="form-group mb-4">
                                        <label><i class="fab fa-facebook text-primary fa-lg mr-1"></i> Facebook Fanpage URL</label>
                                        <div class="input-group input-group-lg">
                                            <div class="input-group-prepend"><span class="input-group-text bg-white"><i class="fab fa-facebook-f text-primary"></i></span></div>
                                            <input type="url" name="social_facebook" class="form-control" value="{{ $settings['social_facebook'] ?? '' }}" placeholder="https://facebook.com/yourpage">
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label><i class="fab fa-youtube text-danger fa-lg mr-1"></i> YouTube Channel URL</label>
                                        <div class="input-group input-group-lg">
                                            <div class="input-group-prepend"><span class="input-group-text bg-white"><i class="fab fa-youtube text-danger"></i></span></div>
                                            <input type="url" name="social_youtube" class="form-control" value="{{ $settings['social_youtube'] ?? '' }}" placeholder="https://youtube.com/c/yourchannel">
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label><i class="fas fa-comment-dots text-info fa-lg mr-1"></i> Số Zalo (Liên hệ nhanh)</label>
                                        <div class="input-group input-group-lg">
                                            <div class="input-group-prepend"><span class="input-group-text bg-white"><strong class="text-primary">Zalo</strong></span></div>
                                            <input type="text" name="social_zalo" class="form-control" value="{{ $settings['social_zalo'] ?? '' }}" placeholder="09xxxxxxx">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-advanced" role="tabpanel">
                            <div class="alert alert-warning shadow-sm border-warning">
                                <i class="fas fa-exclamation-triangle"></i> <strong>Cảnh báo:</strong> Chỉ thêm mã vào đây nếu bạn hiểu rõ về HTML/JS. Chèn sai mã có thể làm hỏng giao diện website.
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label><i class="fas fa-code text-info"></i> Header Scripts</label>
                                    <small class="text-muted d-block mb-2">Thường dùng cho: Google Analytics, Facebook Pixel, thẻ Meta.</small>
                                    <textarea name="header_scripts" class="form-control bg-dark text-light" rows="10" placeholder="<script>...</script>" style="font-family: monospace;">{{ $settings['header_scripts'] ?? '' }}</textarea>
                                    <small class="text-muted mt-1 d-block">Mã được chèn trước thẻ <code>&lt;/head&gt;</code></small>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label><i class="fas fa-code text-info"></i> Footer Scripts</label>
                                    <small class="text-muted d-block mb-2">Thường dùng cho: Livechat bên thứ 3 (Tawk.to, Messenger), Custom JS.</small>
                                    <textarea name="footer_scripts" class="form-control bg-dark text-light" rows="10" placeholder="<script>...</script>" style="font-family: monospace;">{{ $settings['footer_scripts'] ?? '' }}</textarea>
                                    <small class="text-muted mt-1 d-block">Mã được chèn trước thẻ <code>&lt;/body&gt;</code></small>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-email" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mail Driver</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-server"></i></span></div>
                                            <input type="text" name="mail_driver" class="form-control" value="{{ $settings['mail_driver'] ?? 'smtp' }}" placeholder="smtp">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Mail Host</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-network-wired"></i></span></div>
                                            <input type="text" name="mail_host" class="form-control" value="{{ $settings['mail_host'] ?? 'smtp.gmail.com' }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Mail Port</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-door-open"></i></span></div>
                                            <input type="text" name="mail_port" class="form-control" value="{{ $settings['mail_port'] ?? '587' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mail Username (Email gửi đi)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-at"></i></span></div>
                                            <input type="email" name="mail_username" class="form-control" value="{{ $settings['mail_username'] ?? '' }}" placeholder="vi-du@gmail.com">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Mail Password (Mật khẩu ứng dụng)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-key"></i></span></div>
                                            <input type="password" name="mail_password" class="form-control" value="{{ $settings['mail_password'] ?? '' }}">
                                        </div>
                                        <small class="text-info mt-1 d-block"><i class="fas fa-info-circle"></i> Sử dụng "Mật khẩu ứng dụng" của Google, không phải mật khẩu đăng nhập cá nhân.</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Mail Encryption</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
                                            <select name="mail_encryption" class="form-control custom-select">
                                                <option value="tls" {{ ($settings['mail_encryption'] ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                                                <option value="ssl" {{ ($settings['mail_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer bg-white border-top p-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <div class="form-group mb-3 mb-md-0 border p-3 rounded bg-light" style="min-width: 380px;">
                            <label class="d-block mb-2 font-weight-bold"><i class="fas fa-hard-hat text-warning mr-1"></i> Chế độ bảo trì website</label>
                            <div class="custom-control custom-switch custom-switch-off-success custom-switch-on-danger custom-control-inline align-items-center">
                                <input type="checkbox" name="maintenance_mode" class="custom-control-input" id="maintenance_mode" value="1" {{ ($settings['maintenance_mode'] ?? 0) == 1 ? 'checked' : '' }}>
                                <label class="custom-control-label" for="maintenance_mode" style="cursor: pointer;">
                                    <span id="maintenance_status_text" class="{{ ($settings['maintenance_mode'] ?? 0) == 1 ? 'text-danger font-weight-bold' : 'text-success font-weight-bold' }}">
                                        {{ ($settings['maintenance_mode'] ?? 0) == 1 ? 'ĐANG BẬT (Đóng cửa website)' : 'ĐANG TẮT (Hoạt động bình thường)' }}
                                    </span>
                                </label>
                            </div>
                            <small class="d-block mt-2 text-muted">Bật khi nâng cấp hệ thống. Chỉ có tài khoản Admin mới xem được trang chủ.</small>
                        </div>

                        <button type="submit" class="btn btn-info btn-lg px-5 shadow-sm rounded-pill font-weight-bold">
                            <i class="fas fa-save mr-1"></i> LƯU CÀI ĐẶT
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: "{{ session('error') }}",
            });
        @endif
        // Hàm cập nhật ảnh khi chọn file
        function readURL(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(previewId).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
                $(input).next('.custom-file-label').html(input.files[0].name);
            }
        }

        $('#hero_banner_input').change(function() { readURL(this, '#banner_preview'); });
        $('#logo_input').change(function() { readURL(this, '#logo_preview'); });

        // Giữ tab đang chọn sau khi F5
        let activeTab = localStorage.getItem('activeSettingTab');
        if (activeTab) {
            $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
        }
        $('.nav-tabs a').on('shown.bs.tab', function(e) {
            localStorage.setItem('activeSettingTab', $(e.target).attr('href'));
        });

        // Toggle Text Chế độ bảo trì
        $('#maintenance_mode').change(function() {
            if($(this).is(':checked')) {
                $('#maintenance_status_text').text('ĐANG BẬT (Đóng cửa website)').addClass('text-danger').removeClass('text-success');
            } else {
                $('#maintenance_status_text').text('ĐANG TẮT (Hoạt động bình thường)').addClass('text-success').removeClass('text-danger');
            }
        });
    });
</script>
@stop