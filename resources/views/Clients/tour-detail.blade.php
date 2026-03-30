<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@include('Clients.blocks.header')

        <section class="page-banner-two rel z-1">
            <div class="container-fluid">
                <hr class="mt-0">
                <div class="container">
                    <div class="banner-inner pt-15 pb-25">
                        <h2 class="page-title mb-10" data-aos="fade-left" data-aos-duration="1500" data-aos-offset="50">{{ $tourDetail->destination }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center mb-20" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1500" data-aos-offset="50">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active">{{ $tourDetail->title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <div class="tour-gallery">
            <div class="container-fluid">
                <div class="row gap-10 justify-content-center rel">
                    <div class="col-lg-4 col-md-6">
                        <div class="gallery-item">
                           <img src="{{ asset('clients/assets/images/gallery-tours/' . ($tourDetail->images[0] ?? 'default.jpg')) }}" alt="Destination">
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('clients/assets/images/gallery-tours/' . ($tourDetail->images[1] ?? 'default.jpg')) }}" alt="Destination">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="gallery-item gallery-between">
                            <img src="{{ asset('clients/assets/images/gallery-tours/' . ($tourDetail->images[2] ?? 'default.jpg')) }}" alt="Destination">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="gallery-item">
                            <img src="{{ asset('clients/assets/images/gallery-tours/' . ($tourDetail->images[3] ?? 'default.jpg')) }}" alt="Destination">
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('clients/assets/images/gallery-tours/' . ($tourDetail->images[4] ?? 'default.jpg')) }}" alt="Destination">
                        </div>
                    </div>
                    <div class="col-lg-12">
                       <div class="gallery-more-btn">
                            <a href="{{ route('contact') }}" class="theme-btn style-two bgc-secondary">
                                <span data-hover="See All Photos">See All Photos</span>
                                <i class="fal fa-arrow-right"></i>
                            </a>
                       </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="tour-header-area pt-70 rel z-1">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-xl-6 col-lg-7">
                        <div class="tour-header-content mb-15" data-aos="fade-left" data-aos-duration="1500" data-aos-offset="50">
                            <span class="location d-inline-block mb-10"><i class="fal fa-map-marker-alt"></i> {{ $tourDetail->destination }}</span>
                            <div class="section-title pb-5">
                                <h2>{{ $tourDetail->title  }}</h2>
                            </div>
                            <div class="ratting">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5 text-lg-end" data-aos="fade-right" data-aos-duration="1500" data-aos-offset="50">
                        <div class="tour-header-social mb-10">
                            <a href="#"><i class="far fa-share-alt"></i>Share tours</a>
                            <a href="#"><i class="fas fa-heart bgc-secondary"></i>Wish list</a>
                        </div>
                    </div>
                </div>
                <hr class="mt-50 mb-70">
            </div>
        </section>
        <section class="tour-details-page pb-100">
            <div class="container">
                <div class="row">
    <div class="col-lg-8">
        <div class="tour-details-content">
            <h3>Khám Phá Tour</h3>
            <div class="description-content mb-40">
                {!! $tourDetail->description !!}
            </div>
    

                        <h3>Lịch trình chi tiết</h3>
<div class="accordion-two mt-25 mb-60 shadow-sm rounded" id="faq-accordion-two">
    @php $day = 1; @endphp
    @foreach($tourDetail->timeline as $index => $timeline)
    <div class="accordion-item border-0 border-bottom">
        <h5 class="accordion-header">
            <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }} fw-bold" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#collapseTimeline{{ $timeline->timelineID }}" 
                    aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" 
                    aria-controls="collapseTimeline{{ $timeline->timelineID }}">
                
                {{-- Đóng khung chữ NGÀY X cực đẹp bằng CSS Bootstrap --}}
                <span class="badge bg-primary text-white me-3 px-3 py-2 rounded-pill">
                    NGÀY {{ $day++ }}
                </span> 
                {{ str_replace(['Ngày '.$index.':', 'Ngày '.($index+1).':'], '', $timeline->title) }}
            </button>
        </h5>
        <div id="collapseTimeline{{ $timeline->timelineID }}" 
             class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" 
             data-bs-parent="#faq-accordion-two">
            <div class="accordion-body bg-light p-4" style="line-height: 1.8; color: #555;">
                {{-- Nhờ có CKEditor ở Backend, phần in ra này sẽ tự động nhận các thẻ <p>, <b>, <ul>... --}}
                {!! $timeline->description !!}
            </div>
        </div>
    </div>
    @endforeach
</div>
                        <div class="row pb-55">
                {{-- Dịch vụ bao gồm --}}
                <div class="col-md-6">
                    <div class="tour-include-exclude mt-30 p-4 shadow-sm bg-white border-top border-success border-4 rounded h-100">
                        <h5 class="mb-0"><i class="fas fa-check-circle text-success me-2"></i> Dịch vụ bao gồm</h5>
                        <ul class="list-style-one check mt-25">
                            @if(!empty($tourDetail->tour_includes))
                                @foreach($tourDetail->tour_includes as $item)
                                    <li><i class="far fa-check text-success"></i> {{ $item }}</li>
                                @endforeach
                            @else
                                <li class="text-muted italic">Thông tin đang được cập nhật...</li>
                            @endif
                        </ul>
                    </div>
                </div>

                {{-- Không bao gồm --}}
                <div class="col-md-6">
                    <div class="tour-include-exclude mt-30 p-4 shadow-sm bg-white border-top border-danger border-4 rounded h-100">
                        <h5 class="mb-0"><i class="fas fa-times-circle text-danger me-2"></i> Không bao gồm</h5>
                        <ul class="list-style-one mt-25">
                            @if(!empty($tourDetail->tour_excludes))
                                @foreach($tourDetail->tour_excludes as $item)
                                    <li><i class="far fa-times text-danger"></i> {{ $item }}</li>
                                @endforeach
                            @else
                                <li class="text-muted italic">Thông tin đang được cập nhật...</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div> {{-- End row pb-55 --}}
            
        </div> {{-- End tour-details-content --}}
                        <div class="tour-details-tabs mt-60">
    <ul class="nav nav-tabs border-0 mb-30" id="tourTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold px-4" id="policy-tab" data-bs-toggle="tab" data-bs-target="#policy" type="button" role="tab">Chính sách & Quy định</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold px-4" id="note-tab" data-bs-toggle="tab" data-bs-target="#note" type="button" role="tab">Lưu ý khi đi Tour</button>
        </li>
    </ul>

    <div class="tab-content p-4 bg-white shadow-sm rounded border shadow-sm" id="tourTabContent">
        {{-- TAB 1: CHÍNH SÁCH --}}
        <div class="tab-pane fade show active" id="policy" role="tabpanel">
            <div class="policy-item mb-4">
                <h5 class="text-primary mb-3"><i class="fas fa-child me-2"></i> Chính sách giá vé trẻ em</h5>
                <ul class="list-style-two">
                    <li><strong>Trẻ em dưới 05 tuổi:</strong> Miễn phí vé tour (ngủ chung giường với bố mẹ, tự lo chi phí ăn uống và vé tham quan nếu có phát sinh). Hai người lớn chỉ kèm 1 trẻ em miễn phí, trẻ em thứ 2 tính 50% giá vé.</li>
                    <li><strong>Trẻ em từ 10 tuổi trở lên:</strong> Tính 75% giá tour (có suất ăn riêng, ghế ngồi riêng trên xe, ngủ chung giường với bố mẹ).</li>
                    
                </ul>
            </div>

            <div class="policy-item mb-4 border-top pt-3">
                <h5 class="text-danger mb-3"><i class="fas fa-file-invoice-dollar me-2"></i> Điều kiện hoàn/hủy tour</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="bg-light">
                            <tr class="text-center">
                                <th>Thời điểm thông báo hủy</th>
                                <th>Phí phạt (% trên tổng giá tour và không bao gồm dịch vụ khác )</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Ngay sau khi đặt cọc / Trước 5 ngày</td> <td class="text-center text-danger font-weight-bold">0%</td></tr>
                            <tr><td>Từ 3 - 5 ngày trước khởi hành</td> <td class="text-center text-danger font-weight-bold">50%</td></tr>
                            <tr><td>Trong vòng 02 ngày trước khởi hành</td> <td class="text-center text-danger font-weight-bold">100%</td></tr>
                        </tbody>
                    </table>
                </div>
                <p class="small text-muted italic mb-0">* Lưu ý: Thời gian hủy tour được tính cho ngày làm việc (không tính Thứ 7, Chủ Nhật và các ngày Lễ Tết).</p>
                <p class="small text-muted italic">* Đối với các tour Lễ/Tết, chính sách phạt hủy có thể áp dụng mức nghiêm ngặt hơn.</p>
            </div>
        </div>

        {{-- TAB 2: LƯU Ý --}}
        <div class="tab-pane fade" id="note" role="tabpanel">
            <h5 class="text-warning mb-3"><i class="fas fa-info-circle me-2"></i> Thông tin lưu ý quan trọng</h5>
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-style-three">
                        <li><strong>Tập trung & Đón khách:</strong> Quý khách vui lòng có mặt tại điểm hẹn trước 15-30 phút. Điểm đón cụ thể sẽ được cập nhật khi tư vấn hoặc chốt đoàn.</li>
                        <li><strong>Giấy tờ tùy thân:</strong> Cần mang theo bản gốc CMND/CCCD/Hộ chiếu (còn hạn trên 6 tháng). Trẻ em đi kèm mang theo bản sao Giấy khai sinh có mộc đỏ.</li>
                        <li><strong>Quy định lưu trú:</strong> Giờ nhận phòng khách sạn thường là sau 14h00 và giờ trả phòng là trước 12h00.</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-style-three">
                        <li><strong>Hành lý & Tư trang:</strong> Mang theo hành lý gọn nhẹ, quần áo phù hợp với thời tiết điểm đến. Quý khách tự bảo quản tài sản, tư trang có giá trị.</li>
                        <li><strong>Dinh dưỡng:</strong> Không mang thực phẩm có mùi, đồ uống có cồn từ bên ngoài vào nhà hàng/khách sạn để tránh bị tính phí phụ thu.</li>
                        <li><strong>Sức khỏe:</strong> Quý khách có bệnh lý nền vui lòng mang theo thuốc đặc trị cá nhân và thông báo trước cho công ty.</li>
                    </ul>
                </div>
            </div>
            
            <div class="policy-item mt-3 border-top pt-3">
                <h5 class="text-secondary mb-2 fs-6"><i class="fas fa-shield-alt me-2"></i> Điều khoản bất khả kháng</h5>
                <p class="small text-muted text-justify">
                    Trong những trường hợp khách quan như: khủng bố, thiên tai (bão lũ, động đất...), dịch bệnh, hoặc do có sự cố, thay đổi lịch trình của các phương tiện vận chuyển công cộng (máy bay, tàu hỏa...), công ty sẽ giữ quyền thay đổi lộ trình, ngày giờ khởi hành hoặc hủy tour nhằm đảm bảo sự an toàn cho khách hàng. Công ty sẽ hoàn trả lại chi phí chưa sử dụng thực tế và không chịu trách nhiệm bồi thường thêm bất kỳ thiệt hại nào khác.
                </p>
            </div>

            <div class="alert alert-info mt-3 py-2 small mb-0">
                <i class="fas fa-headset me-2"></i> Trước ngày khởi hành 01-02 ngày, Hướng dẫn viên sẽ gọi điện thoại hoặc gửi tin nhắn để thông báo chi tiết biển số xe, số điện thoại liên lạc và dặn dò các thông tin cuối cùng.
            </div>
        </div>
    </div>
</div>

                        <h3>Maps</h3>
                        <div class="tour-map mt-30 mb-50">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3833.8025892838914!2d108.16737971020954!3d16.075730739200644!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314218e6e72e66f5%3A0x81aceed31aec3816!2zMTM3IMSQxrDhu51uZyBOZ3V54buFbiBUaOG7iyBUaOG6rXAsIFRoYW5oIEtow6ogVMOieSwgVGhhbmggS2jDqiwgxJDDoCBO4bq1bmcgNTAwMDAsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1774768769607!5m2!1svi!2s" width="950" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        
                    
                        <h3>Đánh giá của khách hàng</h3>
                        <div class="clients-reviews bgc-black mt-30 mb-60">
                            <div class="left">
                                <b>{{ $averageRating }}</b>
                                <span>({{ $totalReviews }} reviews)</span>
                                <div class="ratting">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($averageRating))
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            
                            <div class="right">
                                @for($i = 5; $i >= 1; $i--)
                                <div class="ratting-item">
                                    <span class="title">{{ $i }} Sao</span>
                                    
                                    <span class="line"><span style="width: {{ $ratingPercentages[$i] ?? 0 }}%;"></span></span>
                                    
                                    <div class="ratting text-white" style="font-size: 14px; margin-left: 10px;">
                                        ({{ $ratingCounts[$i] ?? 0 }})
                                    </div>
                                </div>
                                @endfor
                            </div>
                        </div>
                        <h3>Ý kiến của khách hàng ({{ $totalReviews }})</h3>
                        <div class="comments mt-30 mb-60">
                            
                            @forelse($reviews as $review)
                                <div class="comment-body" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                        <div class="author-thumb">
                            <img src="{{ isset($review->user->avatar) && $review->user->avatar ? asset('clients/assets/images/avatars/' . $review->user->avatar) : asset('clients/assets/images/avatars/default.png') }}" alt="Author">
                        </div>
                                    <div class="content">
                                        <h6>{{ $review->user->name ?? $review->user->username ?? 'Khách hàng' }}</h6>
                                        
                                        <div class="ratting">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        
                                        <span class="time">{{ \Carbon\Carbon::parse($review->createdat)->format('d/m/Y H:i') }}</span>
                                        
                                        <p>{{ $review->comment }}</p>
                                        @if(!empty($review->admin_reply))
                            <div class="admin-reply-box mt-10 p-3" style="background-color: #f8f9fa; border-left: 3px solid #ff6a00; border-radius: 5px;">
                                <h6 style="color: #ff6a00; font-size: 14px; margin-bottom: 5px;"><i class="fas fa-headset"></i> Phản hồi từ quản trị viên:</h6>
                                <p class="mb-0" style="font-size: 14px;">{{ $review->admin_reply }}</p>
                            </div>
                        @endif
                                        
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info">
                                    Chưa có đánh giá nào cho tour này. Hãy là người đầu tiên để lại nhận xét!
                                </div>
                            @endforelse

                        </div>
                        
                        <hr class="mt-50 mb-40">

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <h3>Add Reviews</h3>

                        @if(session()->has('userid'))
                            @if($hasBooked)
                                <form action="{{ route('review.store') }}" method="post" class="mt-30">
                                    @csrf
                                    <input type="hidden" name="tourid" value="{{ $tourDetail->tourid }}">
                                    
                                    <div class="comment-review-wrap">
                                        <div class="comment-ratting-item">
                                            <span class="title">Đánh giá tour</span>
                                            <div class="form-group">
                                                <select name="rating" class="form-control" required>
                                                    <option value="5">⭐⭐⭐⭐⭐ (5 sao)</option>
                                                    <option value="4">⭐⭐⭐⭐ (4 sao)</option>
                                                    <option value="3">⭐⭐⭐ (3 sao)</option>
                                                    <option value="2">⭐⭐ (2 sao)</option>
                                                    <option value="1">⭐ (1 sao)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <hr class="mt-30 mb-40">
                                    <h5>Leave Feedback</h5>
                                    <div class="row gap-20 mt-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" value="{{ session('username') ?? '' }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" value="{{ session('email') ?? '' }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Comments</label>
                                                <textarea name="comment" class="form-control" rows="5" placeholder="Chia sẻ trải nghiệm của bạn về tour này..." required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-0">
                                                <button type="submit" class="theme-btn bgc-secondary style-two">
                                                    <span data-hover="Submit reviews">Submit reviews</span>
                                                    <i class="fal fa-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <div class="alert alert-info mt-30">
                                    <i class="fas fa-info-circle"></i> Bạn cần đặt và trải nghiệm tour này để có thể viết đánh giá.
                                </div>
                            @endif

                        @else
                            <div class="alert alert-warning mt-30">
                                <i class="fas fa-exclamation-triangle"></i> Vui lòng <a href="{{ route('login') }}" style="text-decoration: underline; font-weight: bold;">đăng nhập</a> để đánh giá tour.
                            </div>
                        @endif

                    </div>
                    
                    <div class="col-lg-4 col-md-8 col-sm-10 rmt-75">
                        <div class="blog-sidebar tour-sidebar">
                            
                            <div class="widget widget-tour-info mb-40 shadow-sm p-4 rounded bg-white" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
    <h5 class="widget-title mb-3">Thông tin chung</h5>
    <ul class="list-unstyled mb-0">
        @if(!empty($tourDetail->title))
        <li class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2 hover-bg p-2 rounded">
            <div class="d-flex align-items-center">
                <i class="far fa-clock text-primary me-2 fs-5"></i>
                <strong>Tên tour:</strong>&nbsp; {{ $tourDetail->title }}
            </div>
            <span class="badge bg-success">Hot</span>
        </li>
        @endif

        @if(!empty($tourDetail->tourid))
        <li class="d-flex align-items-center mb-3 border-bottom pb-2 hover-bg p-2 rounded">
            <i class="far fa-calendar-alt text-primary me-2 fs-5"></i>
            <strong>Mã tour:</strong> {{ $tourDetail->tourid }}
        </li>
        @endif

        @if(!empty($tourDetail->time))
        <li class="d-flex align-items-center mb-3 border-bottom pb-2 hover-bg p-2 rounded">
            <i class="far fa-clock text-primary me-2 fs-5"></i>
            <strong>Thời gian:</strong> {{ $tourDetail->time }}
        </li>
        @endif

        @if(!empty($tourDetail->destination))
        <li class="d-flex align-items-center mb-3 border-bottom pb-2 hover-bg p-2 rounded">
            <i class="far fa-map-marker-alt text-primary me-2 fs-5"></i>
            <strong>Điểm đến:</strong> {{ $tourDetail->destination }}
        </li>
        @endif

        @if(!empty($tourDetail->quantity))
        <li class="d-flex align-items-center mb-3 hover-bg p-2 rounded">
            <i class="far fa-users text-primary me-2 fs-5"></i>
            <strong>Quy mô tour:</strong> Tối đa {{ $tourDetail->quantity }} khách
        </li>
        @endif
    </ul>

    
</div>


<style>
.hover-bg:hover {
    background-color: #f8f9fa;
    transition: 0.3s;
}
.tour-details-tabs .nav-tabs .nav-link {
    border: none;
    color: #666;
    background: #f8f9fa;
    margin-right: 10px;
    border-radius: 5px;
    transition: 0.3s;
}
.tour-details-tabs .nav-tabs .nav-link.active {
    background: #ff6a00; /* Màu thương hiệu GoViet của bạn */
    color: white;
}
.list-style-two, .list-style-three {
    list-style: none;
    padding-left: 0;
}
.list-style-two li::before {
    content: "\f058";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    color: #28a745;
    margin-right: 10px;
}
.list-style-three li::before {
    content: "\f0a1";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    color: #ffc107;
    margin-right: 10px;
}
</style>
                            
                            <div class="widget widget-booking" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                                <h5 class="widget-title">Đặt Tour</h5>
                                <form id="booking-form" action="{{ route('booking.index', ['id' => $tourDetail->tourid]) }}" method="get">
                                    
                                    <div class="form-group mb-20">
                                        <label class="fw-bold mb-2"><i class="fas fa-calendar-alt"></i> Chọn lịch khởi hành:</label>
                                        <select name="schedule_id" id="schedule_id" class="form-control" required style="max-height: 200px; overflow-y: auto; padding: 10px;">
                                            <option value="" disabled selected>-- Vui lòng chọn ngày --</option>
                                            @forelse($schedules as $schedule)
                                                <option value="{{ $schedule->schedule_id }}" 
                                                        data-price-adult="{{ $schedule->priceadult }}" 
                                                        data-price-child="{{ $schedule->pricechild }}"
                                                        data-quantity="{{ $schedule->quantity }}">
                                                    Khởi hành: {{ date('d/m', strtotime($schedule->startdate)) }} - Về: {{ date('d/m/Y', strtotime($schedule->enddate)) }}
                                                </option>
                                            @empty
                                                <option value="" disabled>Hiện tại đã hết lịch khởi hành</option>
                                            @endforelse
                                        </select>
                                        <small class="text-muted mt-2 d-block"><i class="fas fa-info-circle"></i> Vui lòng chọn ngày để xem giá vé tương ứng.</small>
                                    </div>

                                    <hr>
                                    <ul class="tickets clearfix mb-25">
                                        <li class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-bold">Giá vé Người lớn:</span> 
                                            <span class="price text-danger fw-bold fs-5" id="display_price_adult">0 VND</span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">Giá vé Trẻ em:</span> 
                                            <span class="price text-danger fw-bold fs-5" id="display_price_child">0 VND</span>
                                        </li>
                                    </ul>

                                    @php
                                        $nextSchedule = $schedules->where('quantity', '>', 0)->sortBy('startdate')->first();
                                        $isPast = $nextSchedule && \Carbon\Carbon::parse($nextSchedule->startdate)->endOfDay()->isPast();
                                        $isFull = !$nextSchedule; 
                                        $isClosed = $tourDetail->availability == 0;
                                    @endphp

                                    @if($isPast || $isFull || $isClosed)
                                        <div class="alert alert-danger text-center py-2" style="font-size: 13px;">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            @if($isPast) Tour đã khởi hành @elseif($isFull) Đã hết chỗ @else Đang tạm ngưng @endif
                                        </div>
                                        <a href="{{ route('contact') }}" class="theme-btn w-100 style-two bg-secondary text-center">Liên hệ tư vấn</a>
                                    @else
                                        @if(session()->has('userid'))
    <button type="submit" class="theme-btn style-two w-100 text-center">Tiếp tục đặt tour</button>
@else
                                            <button type="button" onclick="showLoginNotification()" class="theme-btn style-two w-100 text-center">Tiếp tục đặt tour</button>
                                        @endif
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
        </section>
        <div id="login-warning" style="
display:none;
position:fixed;
top:100px;
right:20px;
background:#dc3545;
color:white;
padding:18px 25px;
border-radius:8px;
box-shadow:0 4px 10px rgba(0,0,0,0.2);
z-index:9999;
">
⚠ Vui lòng đăng nhập để đặt tour
</div>

<script>
function showLoginNotification(){
    const box = document.getElementById("login-warning");
    box.style.display = "block";
    setTimeout(function(){
        box.style.display = "none";
    },5000);
}

document.addEventListener("DOMContentLoaded", function() {
    const scheduleSelect = document.getElementById("schedule_id");
    const priceAdultDisplay = document.getElementById("display_price_adult");
    const priceChildDisplay = document.getElementById("display_price_child");

    function formatMoney(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount) + ' VND';
    }

    // Hàm chỉ cập nhật hiển thị giá vé (không tính tổng)
    function updateBookingSummary() {
        if (!scheduleSelect.value) return; // Không làm gì nếu chưa chọn ngày
        
        const selectedOption = scheduleSelect.options[scheduleSelect.selectedIndex];
        
        // Lấy giá từ data attributes của option vừa được chọn
        const priceAdult = parseInt(selectedOption.getAttribute("data-price-adult")) || 0;
        const priceChild = parseInt(selectedOption.getAttribute("data-price-child")) || 0;
        
        // Cập nhật hiển thị đơn giá
        priceAdultDisplay.innerText = priceAdult > 0 ? formatMoney(priceAdult) : '0 VND';
        priceChildDisplay.innerText = priceChild > 0 ? formatMoney(priceChild) : '0 VND';
    }

    // Lắng nghe sự kiện thay đổi ngày để đổi giá
    scheduleSelect.addEventListener("change", updateBookingSummary);

    // Xử lý cho thư viện NiceSelect nếu template có dùng
    if (window.jQuery) {
        $(scheduleSelect).on('change', function() {
            updateBookingSummary();
        });
    }

    // Nếu lúc load trang mà có sẵn ngày được chọn thì cập nhật giá luôn
    if(scheduleSelect.value){
        updateBookingSummary();
    }
});
</script>  
        
@include('clients.blocks.new_letter')
@include('clients.blocks.footer')