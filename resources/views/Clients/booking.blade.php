@include('Clients.blocks.header')

<style>
    :root {
        --gv-primary:#4CBEE1;
        --gv-accent: #ff5722;
        --gv-success: #28a745;
        --gv-bg-light: #f8f9fa;
        --gv-border: #e9ecef;
        --gv-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    body { background-color: var(--gv-bg-light); font-family: 'Inter', sans-serif; }

    /* Fix lỗi Menu đè - Đảm bảo nội dung luôn dưới header */
    .booking-wrapper { margin-top: 100px; margin-bottom: 80px; }

    /* Stepper Tiến trình */
    .booking-steps { display: flex; justify-content: space-around; margin-bottom: 40px; position: relative; }
    .step-item { text-align: center; flex: 1; position: relative; z-index: 1; }
    .step-item::after { content: ''; position: absolute; top: 18px; left: 50%; width: 100%; height: 2px; background: #dee2e6; z-index: -1; }
    .step-item:last-child::after { display: none; }
    .step-number { width: 36px; height: 36px; background: #fff; border: 2px solid #dee2e6; border-radius: 50%; display: inline-block; line-height: 32px; font-weight: 700; color: #adb5bd; margin-bottom: 8px; transition: 0.3s; }
    .step-item.active .step-number { background: var(--gv-primary); border-color: var(--gv-primary); color: #fff; box-shadow: 0 0 15px rgba(3, 42, 99, 0.2); }
    .step-text { font-size: 13px; font-weight: 600; color: #adb5bd; text-transform: uppercase; }
    .step-item.active .step-text { color: var(--gv-primary); }

    /* Card Layout Premium */
    .glass-card { background: #fff; border: none; border-radius: 16px; box-shadow: var(--gv-shadow); margin-bottom: 30px; overflow: hidden; border: 1px solid rgba(0,0,0,0.03); }
    .card-head { padding: 20px 25px; border-bottom: 1px solid #f1f3f5; display: flex; align-items: center; background: #fafbfc; }
    .card-head i { font-size: 1.2rem; color: var(--gv-primary); margin-right: 15px; }
    .card-head h5 { margin: 0; font-weight: 700; color: #1a1a1a; letter-spacing: -0.5px; }
    .card-body-custom { padding: 30px; }

    /* Input & Form Styling */
    .form-group label { font-weight: 600; font-size: 0.88rem; color: #4a5568; margin-bottom: 10px; }
    .form-control-custom { border-radius: 10px; border: 1.5px solid #e2e8f0; padding: 12px 16px; transition: 0.3s; width: 100%; font-size: 0.95rem; }
    .form-control-custom:focus { border-color: var(--gv-primary); box-shadow: 0 0 0 4px rgba(3, 42, 99, 0.08); outline: none; }

    /* Quantity Control (Fixed Layout) */
    .passenger-row { display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px dashed #edf2f7; }
    .passenger-row:last-child { border-bottom: none; }
    .qty-group { display: flex; align-items: center; background: #f8f9fa; border: 1px solid #e2e8f0; border-radius: 12px; padding: 5px; }
    .qty-btn { width: 34px; height: 34px; border: none; border-radius: 8px; background: #fff; color: var(--gv-primary); font-weight: 800; cursor: pointer; transition: 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.04); }
    .qty-btn:hover { background: var(--gv-primary); color: #fff; }
    .qty-input-box { 
        width: 40px !important; 
        border: none !important; 
        background: transparent !important; 
        font-weight: 800 !important; 
        font-size: 1.2rem !important; 
        color: #1e293b !important; /* Ép màu chữ phải đậm */
        text-align: center !important; 
        padding: 0 !important; 
        margin: 0 !important;
        display: block !important;
        opacity: 1 !important;
    }

    /* Pickup Selection (Grid Modern) */
    .pickup-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
    .pickup-card { 
        display: block; border: 2px solid #edf2f7; border-radius: 14px; padding: 18px; 
        cursor: pointer; transition: all 0.3s ease; position: relative; background: #fff; margin-bottom: 0;
    }
    .pickup-card:hover { border-color: #cbd5e0; transform: translateY(-2px); }
    input[type="radio"]:checked + .pickup-card { border-color: var(--gv-primary); background: #f0f7ff; box-shadow: 0 5px 15px rgba(3,42,99,0.1); }
    .pickup-info .name { display: block; font-weight: 700; color: #1a202c; font-size: 1rem; }
    .pickup-info .time { display: block; font-size: 0.85rem; color: #718096; margin-top: 4px; }
    .pickup-price { color: var(--gv-accent); font-weight: 800; font-size: 1.05rem; margin-top: 12px; display: block; }
    .fee-badge { font-size: 10px; text-transform: uppercase; background: #edf2f7; padding: 2px 8px; border-radius: 4px; color: #4a5568; font-weight: 600; margin-left: 5px; }

    /* Payment List */
    .pay-list label { display: flex; align-items: center; border: 2px solid #edf2f7; padding: 20px; border-radius: 14px; cursor: pointer; transition: 0.3s; }
    input[type="radio"]:checked + label { border-color: var(--gv-primary); background: #f0f7ff; }

    /* Sticky Calculation Sidebar (Transparent & Clear) */
    .sidebar-sticky { position: sticky; top: 110px; }
    .receipt { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.12); border: 1px solid rgba(3,42,99,0.05); }
    .receipt-header { background: #e64a19; color: #fff; padding: 22px; text-align: center; }
    .calc-area { background: #f8fafc; border-radius: 16px; padding: 20px; margin: 20px 0; border: 1px dashed #cbd5e1; }
    .calc-row { display: flex; justify-content: space-between; margin-bottom: 12px; }
    .calc-label { font-size: 0.9rem; color: #64748b; font-weight: 500; }
    .calc-val { color: #e64a19; font-weight: 700; font-size: 0.95rem; }
    .math-text { font-size: 11px; display: block; color: #94a3b8; font-style: italic; margin-top: 2px; }
    .grand-total { border-top: 2px solid #e2e8f0; padding-top: 18px; margin-top: 10px; display: flex; justify-content: space-between; align-items: center; }
    .deposit-box { background: #fff1f2; border: 1px solid #ffe4e6; border-radius: 12px; padding: 18px; text-align: center; margin-top: 20px; }

    /* Privacy & Button */
    .privacy-section { background: #fefcbf; border: 1px solid #faf089; padding: 15px; border-radius: 10px; font-size: 13px; color: #744210; }
    .booking-btn { background: var(--gv-accent); color: #fff; border: none; border-radius: 12px; padding: 18px; font-weight: 800; font-size: 1.1rem; transition: 0.3s; cursor: pointer; text-transform: uppercase; width: 100%; box-shadow: 0 8px 20px rgba(255,87,34,0.25); }
    .booking-btn:hover { background: #e64a19; transform: translateY(-2px); box-shadow: 0 12px 25px rgba(255,87,34,0.3); }
</style>

<div class="booking-wrapper container">
    {{-- THÊM KHỐI HIỂN THỊ LỖI (Để biết Controller báo lỗi gì thay vì load lại trang trắng) --}}
    @if(session('error'))
        <div class="alert alert-danger mb-4 shadow-sm border-0">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mb-4 shadow-sm border-0">
            <ul class="mb-0">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="booking-steps">
        <div class="step-item active"><span class="step-number">1</span><div class="step-text">Liên hệ</div></div>
        <div class="step-item active"><span class="step-number">2</span><div class="step-text">Dịch vụ</div></div>
        <div class="step-item"><span class="step-number">3</span><div class="step-text">Thanh toán</div></div>
    </div>

    <form action="{{ route('booking.store', ['id' => $tour->tourid]) }}" method="post" id="mainBookingForm">
        @csrf
        <input type="hidden" name="schedule_id" value="{{ $schedule->schedule_id ?? request('schedule_id') }}">
        <input type="hidden" name="tourid" value="{{ $tour->tourid }}"> {{-- Đồng bộ tourid --}}
        <input type="hidden" name="total_price_hidden" id="total_price_hidden">
        
        {{-- THÊM 2 TRƯỜNG ẨN NÀY ĐỂ TRUYỀN PHỤ PHÍ VÀ MÃ GIẢM GIÁ VỀ CONTROLLER --}}
        <input type="hidden" name="pickup_fee_total_hidden" id="pickup_fee_total_hidden" value="0">
        <input type="hidden" name="coupon_code_hidden" id="coupon_code_hidden" value="">

        <div class="row">
            <div class="col-lg-8">
                <div class="glass-card">
                    <div class="card-head"><i class="fas fa-id-card"></i><h5>Thông tin người đặt tour</h5></div>
                    <div class="card-body-custom">
                        <div class="row">
                            <div class="col-md-6 form-group mb-4">
                                <label>Họ và tên khách hàng *</label>
                                <input type="text" name="username" class="form-control-custom" value="{{ session('username') }}" required placeholder="Ví dụ: Nguyễn Văn A">
                            </div>
                            <div class="col-md-6 form-group mb-4">
                                <label>Số điện thoại liên hệ *</label>
                                <input type="tel" name="tel" class="form-control-custom" value="{{ session('phoneNumber') }}" required placeholder="Dùng để gọi xác nhận đón">
                            </div>
                            <div class="col-md-12 form-group mb-4">
                                <label>Địa chỉ Email nhận vé điện tử *</label>
                                <input type="email" name="email" class="form-control-custom" value="{{ session('email') }}" required placeholder="chungtoi@example.com">
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Địa chỉ thường trú *</label>
                                <input type="text" name="dia_chi" class="form-control-custom" value="{{ session('address') }}" required placeholder="Nhập địa chỉ của bạn">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="card-head"><i class="fas fa-users"></i><h5>Số lượng hành khách</h5></div>
                    <div class="card-body-custom">
                        <div class="passenger-row">
                            <div>
                                <span class="d-block font-weight-bold">Người lớn</span>
                                <small class="text-muted">{{ number_format($schedule->priceadult ?? $tour->priceadult) }}đ / người</small>
                            </div>
                            <div class="qty-group">
                                <button type="button" class="qty-btn" onclick="updateQty('numadults', -1)">-</button>
                                <input type="number" name="numadults" id="numadults" value="1" class="qty-input-box" readonly>
                                <button type="button" class="qty-btn" onclick="updateQty('numadults', 1)">+</button>
                            </div>
                        </div>
                        <div class="passenger-row">
                            <div>
                                <span class="d-block font-weight-bold">Trẻ em</span>
                                <small class="text-muted">{{ number_format($schedule->pricechild ?? $tour->pricechild) }}đ / người</small>
                            </div>
                            <div class="qty-group">
                                <button type="button" class="qty-btn" onclick="updateQty('numchildren', -1)">-</button>
                                <input type="number" name="numchildren" id="numchildren" value="0" class="qty-input-box" readonly>
                                <button type="button" class="qty-btn" onclick="updateQty('numchildren', 1)">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="card-head"><i class="fas fa-map-marked-alt"></i><h5>Điểm đón & Phụ phí di chuyển</h5></div>
                    <div class="card-body-custom">
                        <div class="pickup-grid">
                            @if(isset($tour->pickupPoints) && count($tour->pickupPoints) > 0)
                                @foreach($tour->pickupPoints as $point)
                                <div class="pickup-item">
                                    <input type="radio" name="pickup_id" id="pk-{{ $point->pickup_id }}" value="{{ $point->pickup_id }}" 
       data-price="{{ $point->extra_price }}" data-type="{{ $point->fee_type }}" 
       style="position: absolute; opacity: 0; z-index: -1;" required>
                                    <label for="pk-{{ $point->pickup_id }}" class="pickup-card">
                                        <div class="pickup-info">
                                            <span class="name">{{ $point->pickup_name }}</span>
                                            <span class="time"><i class="far fa-clock mr-1"></i> Xe đón lúc: {{ date('H:i', strtotime($point->pickup_time)) }}</span>
                                        </div>
                                        <span class="pickup-price">+{{ number_format($point->extra_price) }}đ
                                            <span class="fee-badge">{{ $point->fee_type == 0 ? 'Mỗi khách' : 'Cả đoàn' }}</span>
                                        </span>
                                    </label>
                                </div>
                                @endforeach
                            @else
                                <p class="text-muted w-100 text-center py-3 border rounded border-dashed">
                                    <i class="fas fa-info-circle mr-2"></i> Tour này chưa có điểm đón cố định. Chúng tôi sẽ liên hệ bạn để sắp xếp.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="card-head"><i class="fas fa-wallet"></i><h5>Lựa chọn phương thức thanh toán</h5></div>
                    <div class="card-body-custom pay-list">
                        <div class="mb-3">
                            <input type="radio" name="paymentmethod" value="momo" id="momo" class="d-none" required>
                            <label for="momo">
                                <img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" width="35">
                                <div class="ml-4">
                                    <span class="d-block font-weight-bold">Thanh toán Ví MoMo</span>
                                    <small class="text-muted">An toàn, nhanh chóng, cọc 30% tức thì</small>
                                </div>
                            </label>
                        </div>
                        <div class="mb-3">
                            <input type="radio" name="paymentmethod" value="paypal" id="paypal" class="d-none">
                            <label for="paypal">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" width="65">
                                <div class="ml-4">
                                    <span class="d-block font-weight-bold">Cổng PayPal</span>
                                    <small class="text-muted">Hỗ trợ thẻ quốc tế và ví PayPal</small>
                                </div>
                            </label>
                        </div>
                        <div>
                            <input type="radio" name="paymentmethod" value="cash" id="cash" class="d-none">
                            <label for="cash">
                                <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                                <div class="ml-4">
                                    <span class="d-block font-weight-bold">Chuyển khoản / Tiền mặt</span>
                                    <small class="text-muted">Chúng tôi sẽ gọi lại hướng dẫn chuyển tiền cọc</small>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                <div class="sidebar-sticky">
                    <div class="receipt">
                        <div class="receipt-header">
                            <h6 class="m-0 text-uppercase font-weight-bold letter-spacing-1">Chi tiết hóa đơn tạm tính</h6>
                        </div>
                        <div class="p-4">
                            <div class="border-bottom pb-3 mb-3">
                                <span class="badge badge-primary mb-2">#{{ $tour->tourid }}</span>
                                <h6 class="font-weight-bold text-dark mb-1">{{ $tour->title }}</h6>
                                <div class="small text-muted"><i class="far fa-calendar-alt mr-1"></i> Khởi hành: {{ date('d/m/Y', strtotime($schedule->startdate ?? $tour->startdate)) }}</div>
                            </div>

                            <div class="calc-area">
                                <div class="calc-row">
                                    <div>
                                        <span class="calc-label d-block">Tiền vé người lớn</span>
                                        <span class="math-text" id="math-adult">1 x 0đ</span>
                                    </div>
                                    <span class="calc-val" id="val-adult">0đ</span>
                                </div>
                                <div class="calc-row" id="row-child" style="display:none">
                                    <div>
                                        <span class="calc-label d-block">Tiền vé trẻ em</span>
                                        <span class="math-text" id="math-child">0 x 0đ</span>
                                    </div>
                                    <span class="calc-val" id="val-child">0đ</span>
                                </div>
                                <div class="calc-row" id="row-pk" style="display:none">
                                    <div>
                                        <span class="calc-label d-block text-primary">Phụ phí đón</span>
                                        <span class="math-text" id="math-pk">...</span>
                                    </div>
                                    <span class="calc-val text-primary" id="val-pk">+0đ</span>
                                </div>
                                <div class="calc-row text-success" id="row-voucher" style="display:none">
                                    <div>
                                        <span class="calc-label d-block text-success font-weight-bold">Mã giảm giá</span>
                                        <span class="math-text" id="math-voucher">Giảm 0%</span>
                                    </div>
                                    <span class="calc-val" id="val-voucher">-0đ</span>
                                </div>
                            </div>

                            <div class="grand-total">
                                <h6 class="font-weight-bold text-dark mb-0">TỔNG CỘNG:</h6>
                                <h4 class="text-danger font-weight-bold mb-0" id="res-total">0đ</h4>
                            </div>

                            <div class="deposit-box">
                                <span class="small font-weight-bold text-uppercase text-danger d-block">Tiền cọc cần thanh toán (30%)</span>
                                <h4 class="text-danger font-weight-bold mb-1 mt-1" id="res-deposit">0đ</h4>
                                <small class="text-muted italic">Số tiền này dùng để đảm bảo chỗ của bạn</small>
                            </div>

                            <div class="mt-4">
                                <div class="input-group shadow-sm border rounded-lg overflow-hidden">
                                    <input type="text" id="coupon_input" class="form-control border-0" placeholder="Mã quà tặng">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary px-3" type="button" id="btn-coupon">Áp dụng</button>
                                    </div>
                                </div>
                                <div id="coupon-msg" class="mt-2 small"></div>
                            </div>
                            
                            <div class="privacy-section mt-4 mb-5 shadow-sm">
                                <p class="mb-3">Bằng cách nhấp chuột vào nút "ĐỒNG Ý" dưới đây, Khách hàng đồng ý rằng các điều kiện điều khoản này sẽ được áp dụng. Vui lòng đọc kỹ điều kiện điều khoản trước khi lựa chọn sử dụng dịch vụ của <strong>GoViet Tours</strong>.</p>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="agree" name="agree" required>
                                    <label class="custom-control-label font-weight-bold" for="agree">Tôi đã đọc và đồng ý với <a href="#" target="_blank" class="text-primary underline">Điều khoản dịch vụ và chính sách thanh toán</a></label>
                                </div>
                            </div>
                            <button type="submit" class="booking-btn mt-4 shadow-lg">
                                XÁC NHẬN & THANH TOÁN <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-center mt-3 text-muted small">
                        <i class="fas fa-shield-alt mr-1"></i> Thanh toán an toàn 256-bit SSL
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Hàm cập nhật số lượng
    function updateQty(id, delta) {
        let el = document.getElementById(id);
        let val = parseInt(el.value) + delta;
        if (id === 'numadults' && val < 1) val = 1;
        if (id === 'numchildren' && val < 0) val = 0;
        el.value = val;
        window.calculateLogic();
    }

    document.addEventListener("DOMContentLoaded", function() {
        const PR_A = parseInt("{{ $schedule->priceadult ?? $tour->priceadult ?? 0 }}");
        const PR_C = parseInt("{{ $schedule->pricechild ?? $tour->pricechild ?? 0 }}");
        let discPct = 0;

        window.calculateLogic = function() {
            let nA = parseInt(document.getElementById('numadults').value);
            let nC = parseInt(document.getElementById('numchildren').value);
            let totalKhach = nA + nC;

            // 1. Phép tính giá Tour
            let sumA = nA * PR_A;
            let sumC = nC * PR_C;
            let base = sumA + sumC;

            // 2. Phép tính Pickup
            let sumPk = 0;
            let pk = document.querySelector('input[name="pickup_id"]:checked');
            if (pk) {
                let price = parseInt(pk.dataset.price);
                if (pk.dataset.type == "0") { // Phụ phí mỗi người
                    sumPk = price * totalKhach;
                    document.getElementById('math-pk').innerText = `${totalKhach} người x ${price.toLocaleString()}đ`;
                } else { // Phí cố định
                    sumPk = price;
                    document.getElementById('math-pk').innerText = `Cố định theo chuyến`;
                }
                document.getElementById('row-pk').style.display = 'flex';
                document.getElementById('val-pk').innerText = '+' + sumPk.toLocaleString() + 'đ';
            }

            // 3. Phép tính Voucher
            let discAmt = base * (discPct / 100);
            if (discPct > 0) {
                document.getElementById('row-voucher').style.display = 'flex';
                document.getElementById('val-voucher').innerText = '-' + discAmt.toLocaleString() + 'đ';
                document.getElementById('math-voucher').innerText = `Giảm ${discPct}% tổng tour`;
            }

            // 4. Tổng cuối & Cọc 30%
            let grand = base + sumPk - discAmt;
            let dep = Math.round(grand * 0.3);

            // Giao diện Sidebar
            document.getElementById('val-adult').innerText = sumA.toLocaleString() + 'đ';
            document.getElementById('math-adult').innerText = `${nA} người lớn x ${PR_A.toLocaleString()}đ`;
            
            if (nC > 0) {
                document.getElementById('row-child').style.display = 'flex';
                document.getElementById('val-child').innerText = sumC.toLocaleString() + 'đ';
                document.getElementById('math-child').innerText = `${nC} trẻ em x ${PR_C.toLocaleString()}đ`;
            } else {
                document.getElementById('row-child').style.display = 'none';
            }

            document.getElementById('res-total').innerText = grand.toLocaleString() + 'đ';
            document.getElementById('res-deposit').innerText = dep.toLocaleString() + 'đ';
            
            // GÁN DỮ LIỆU CHO CÁC Ô ẨN ĐỂ GỬI ĐI
            document.getElementById('total_price_hidden').value = grand;
            document.getElementById('pickup_fee_total_hidden').value = sumPk;
        }

        // Lắng nghe thay đổi radio pickup
        document.querySelectorAll('input[name="pickup_id"]').forEach(r => r.addEventListener('change', window.calculateLogic));

        // Coupon AJAX
        document.getElementById('btn-coupon').addEventListener('click', function() {
            let code = document.getElementById('coupon_input').value;
            if(!code) return;
            $.post("{{ route('coupon.check') }}", { _token: "{{ csrf_token() }}", coupon_code: code }, function(res) {
                if(res.success) {
                    discPct = res.discount;
                    document.getElementById('coupon_code_hidden').value = code; // LƯU MÃ VÀO Ô ẨN
                    document.getElementById('coupon-msg').innerHTML = `<span class="text-success fw-bold">✅ Áp dụng thành công!</span>`;
                } else {
                    discPct = 0;
                    document.getElementById('coupon_code_hidden').value = '';
                    document.getElementById('coupon-msg').innerHTML = `<span class="text-danger">❌ ${res.message}</span>`;
                }
                window.calculateLogic();
            });
        });

        window.calculateLogic();
    });
</script>

@include('Clients.blocks.footer')