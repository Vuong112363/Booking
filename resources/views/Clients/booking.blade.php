@include('Clients.blocks.header')
@include('Clients.blocks.banner', ['title' => 'Đặt Tour'])
@if(session('error'))
<div class="alert alert-danger">
{{ session('error') }}
</div> 
@endif
@if(session('success'))
    <div class="booking-notification" style="
        position: fixed;
        top: 100px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        background: #28a745;
        color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        justify-content: space-between;
        animation: slideInRight 0.5s ease-out;
    ">
        <div>
            <i class="fas fa-check-circle" style="margin-right: 10px; font-size: 1.2rem;"></i>
            <strong>Thành công!</strong> {{ session('success') }}
        </div>
        <button type="button" onclick="this.parentElement.remove()" style="
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            line-height: 1;
            margin-left: 15px;
        ">&times;</button>
    </div>

    <style>
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>

    <script>
        // Tự động đóng sau 5 giây
        setTimeout(function() {
            const notify = document.querySelector('.booking-notification');
            if(notify) notify.style.display = 'none';
        }, 5000);
    </script>
@endif  
    <section class="container" style="margin-top: 50px;">
<form action="{{ route('booking.store', ['id' => $tour->tourid]) }}" method="post" class ="booking-container">
    @csrf
            <!-- Contact Information -->
            <div class="booking-info">
                <h2 class="booking-header">Thông Tin Liên Lạc</h2>
                <div class="booking__infor">
                    <div class="form-group">
                        <label for="username">Họ và tên*</label>
                        <input type="text"
                            id="username"
                            name="username"
                            value="{{ session('username') ?? '' }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email*</label>
                        <input type="email"
                        name="email"
                        value="{{ session('email') ?? '' }}"
                        required>
                    </div>

                    <div class="form-group">
                        <label for="tel">Số điện thoại*</label>
                        <input type="tel" id="number" placeholder="Nhập số điện thoại liên hệ" name="tel" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Địa chỉ*</label>
                        <input type="tel"
                        name="tel"
                        value="{{ session('phoneNumber') ?? '' }}"
                        required>
                    </div>
                </div>


                <!-- Passenger Details -->
                <h2 class="booking-header">Hành Khách</h2>

                <div class="booking__quantity">
                    <div class="form-group quantity-selector">
                        <label>Người lớn</label>
                        <div class="input__quanlity">
                            <button type="button" class="quantity-btn">-</button>
                            <input type="number" name="numadults" id="numadults" value="1" readonly>
                            <button type="button" class="quantity-btn">+</button>
                        </div>
                    </div>

                    <div class="form-group quantity-selector">
                        <label>Trẻ em</label>
                        <div class="input__quanlity">
                            <button type="button" class="quantity-btn">-</button>
                            <input type="number" name="numchildren" id="numchildren" value="0" readonly>
                            <button type="button" class="quantity-btn">+</button>
                        </div>
                    </div>
                </div>
                <!-- Privacy Agreement Section -->
                <div class="privacy-section">
                    <p>Bằng cách nhấp chuột vào nút "ĐỒNG Ý" dưới đây, Khách hàng đồng ý rằng các điều kiện điều khoản
                        này sẽ được áp dụng. Vui lòng đọc kỹ điều kiện điều khoản trước khi lựa chọn sử dụng dịch vụ của
                        Lửa Việt Tours.</p>
                    <div class="privacy-checkbox">
                        <input type="checkbox" id="agree" name="agree" required>
                        <label for="agree">Tôi đã đọc và đồng ý với <a href="#" target="_blank">Điều khoản thanh
                                toán</a></label>
                    </div>
                </div>
                <!-- Payment Method -->
                <h2 class="booking-header">Phương Thức Thanh Toán</h2>

                <label class="payment-option d-block mb-3 p-3 border rounded">
                    <input type="radio" name="paymentmethod" value="paypal" required>
                    <img src="{{ asset('clients/assets/images/checkout/paypal.png') }}" alt="PayPal" style="height: 25px; margin: 0 10px;">
                    Thanh toán bằng PayPal
                </label>

<label class="payment-option d-block mb-3 p-3 border rounded">
    <input type="radio" name="paymentmethod" value="momo" required>
    <img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" alt="MoMo" style="height:25px;margin:0 10px;">
    Thanh toán cọc (30%) trực tuyến bằng Ví MoMo
</label>

<label class="payment-option d-block mb-3 p-3 border rounded">
    <input type="radio" name="paymentmethod" value="cash" required>
    <i class="fas fa-money-bill-wave text-success" style="font-size: 20px; margin: 0 10px;"></i>
    Tiền mặt / Chuyển khoản (Liên hệ tư vấn viên để cọc 30%)
</label>


            </div>

            <!-- Order Summary -->
            <div class="booking-summary">
                <div class="summary-section">
                    <div>
                        <p>Mã tour : {{ $tour->tourid }}</p>

                        <h4>{{ $tour->title }}</h4>

                        <p>Ngày khởi hành : {{ $tour->startdate }}</p>

                        <p>Ngày kết thúc : {{ $tour->enddate }}</p>
                    </div>

                    <div class="summary-item">
    <span>Người lớn:</span>
    <div>
        <span class="quantity__adults">1</span>
        <span>X</span>
        <span id="priceAdultDisplay">0 VNĐ</span>
    </div>
</div>

<div class="summary-item">
    <span>Trẻ em:</span>
    <div>
        <span class="quantity__children">0</span>
        <span>X</span>
        <span id="priceChildDisplay">0 VNĐ</span>
    </div>
</div>

<div class="summary-item total-price">
    <div>
        <span>Tổng cộng:</span>
        <span id="totalPrice">0 VNĐ</span>
    </div>
</div>
<div class="summary-item deposit-price">
    <div>
        <span style="color: #e53935; font-weight: bold;">Cần thanh toán cọc (30%):</span>
        <span id="depositPrice" style="color: #e53935; font-weight: bold; font-size: 1.2rem;">0 VNĐ</span>
    </div>
</div>
                    <div class="order-coupon">
                        <input type="text" name="mã giảm giá" style="width: 65%"><button type="button" style="width: 30%;" class="booking-btn">Áp dụng</button>
                    </div>

                    <button type="submit" class="booking-btn">Xác Nhận và Thanh Toán</button>
                </div>
            </div>
        </form>
        
        <input type="hidden" id="priceAdult" value="{{ $tour->priceadult }}">
<input type="hidden" id="priceChild" value="{{ $tour->pricechild }}">
    </section>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // 1. Lấy giá tiền và ép kiểu an toàn (Bảo vệ tuyệt đối khỏi lỗi NaN)
    const rawPriceAdult = "{{ $tour->priceadult ?? 0 }}";
    const rawPriceChild = "{{ $tour->pricechild ?? 0 }}";

    function cleanPrice(priceString) {
        if (!priceString) return 0;
        // Xóa mọi ký tự chữ, dấu phẩy, dấu chấm, chỉ giữ lại số
        let cleanString = priceString.toString().replace(/[^0-9]/g, "");
        let price = parseInt(cleanString);
        return isNaN(price) ? 0 : price;
    }

    const priceAdult = cleanPrice(rawPriceAdult);
    const priceChild = cleanPrice(rawPriceChild);

    // 2. Hàm tính tiền và cập nhật giao diện
    function updatePrice() {
        // Tìm ô input theo thuộc tính name (chính xác hơn dùng ID)
        let inputAdult = document.querySelector('input[name="numadults"]');
        let inputChild = document.querySelector('input[name="numchildren"]');

        // Ép buộc phải là số. Nếu bị rỗng hoặc lỗi, mặc định người lớn = 1, trẻ em = 0
        let adults = inputAdult && inputAdult.value ? parseInt(inputAdult.value) : 1;
        let children = inputChild && inputChild.value ? parseInt(inputChild.value) : 0;

        if (isNaN(adults) || adults < 1) adults = 1;
        if (isNaN(children) || children < 0) children = 0;

        // Tính toán
        let totalAdult = adults * priceAdult;
        let totalChild = children * priceChild;
        let grandTotal = totalAdult + totalChild;
        let depositTotal = grandTotal * 0.3; // Tính 30% cọc

        // --- CẬP NHẬT HIỂN THỊ (Dùng querySelectorAll để quét hết mọi chỗ trên trang) ---
        
        // Cập nhật số lượng
        document.querySelectorAll(".quantity__adults").forEach(el => el.innerText = adults);
        document.querySelectorAll(".quantity__children").forEach(el => el.innerText = children);

        // Cập nhật giá tiền
        document.querySelectorAll("#priceAdultDisplay").forEach(el => el.innerText = totalAdult.toLocaleString('vi-VN') + " VNĐ");
        document.querySelectorAll("#priceChildDisplay").forEach(el => el.innerText = totalChild.toLocaleString('vi-VN') + " VNĐ");
        document.querySelectorAll("#totalPrice").forEach(el => el.innerText = grandTotal.toLocaleString('vi-VN') + " VNĐ");
        document.querySelectorAll("#depositPrice").forEach(el => el.innerText = depositTotal.toLocaleString('vi-VN') + " VNĐ");
    }

    // 3. Xử lý nút Bấm Tăng / Giảm
    document.querySelectorAll(".quantity-btn").forEach(btn => {
        btn.addEventListener("click", function () {
            // Tìm ô input nằm ngay sát nút vừa bấm
            let input = this.parentNode.querySelector("input");
            if (!input) return;

            let value = parseInt(input.value);
            if (isNaN(value)) value = 0;

            let isAdult = input.name === "numadults";
            let min = isAdult ? 1 : 0; // Người lớn luôn >= 1

            if (this.textContent.trim() === "+") {
                value++;
            } else if (this.textContent.trim() === "-") {
                if (value > min) {
                    value--;
                }
            }

            input.value = value; // Gắn số mới vào ô input
            updatePrice();       // Tính lại tiền
        });
    });

    // 4. Chạy hàm tính tiền (Có độ trễ 0.2s để chờ giao diện tải xong hoàn toàn)
    setTimeout(updatePrice, 200);
});
</script>
@include('Clients.blocks.footer')