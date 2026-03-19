@include('Clients.blocks.header')


        <!-- Page Banner Start -->
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
        <!-- Page Banner End -->

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
                        <div class="gallery-item .gallery-between">
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
        <!-- Tour Gallery End -->
        
        
        <!-- Tour Header Area start -->
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
        <!-- Tour Header Area end -->
        
        
        <!-- Tour Details Area start -->
        <section class="tour-details-page pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="tour-details-content">
                            <h3>Khám Phá Tour</h3>
                            <p>{!! $tourDetail->description !!}</p>
                            <div class="row pb-55">
                                <div class="col-md-6">
                                    <div class="tour-include-exclude mt-30">
                                        <h5>Dịch vụ bao gồm</h5>
                                        <ul class="list-style-one check mt-25">
                                            <li><i class="far fa-check"></i> Đưa đón tận nơi</li>
                                            <li><i class="far fa-check"></i> 1 bữa ăn mỗi ngày</li>
                                            <li><i class="far fa-check"></i> Tiệc tối trên du thuyền & chương trình âm nhạc</li>
                                            <li><i class="far fa-check"></i> Tham quan 7 địa điểm nổi bật trong thành phố</li>
                                            <li><i class="far fa-check"></i> Nước suối miễn phí trên xe</li>
                                            <li><i class="far fa-check"></i> Xe du lịch cao cấp</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="tour-include-exclude mt-30">
                                        <h5>Không bao gồm</h5>
                                        <ul class="list-style-one mt-25">
                                            <li><i class="far fa-times"></i> Tiền tip (boa)</li>
                                            <li><i class="far fa-times"></i> Đưa đón tại khách sạn</li>
                                            <li><i class="far fa-times"></i> Ăn trưa, đồ ăn & thức uống ngoài chương trình</li>
                                            <li><i class="far fa-times"></i> Nâng cấp tùy chọn (dịch vụ bổ sung)</li>
                                            <li><i class="far fa-times"></i> Các dịch vụ phát sinh thêm</li>
                                            <li><i class="far fa-times"></i> Bảo hiểm du lịch</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <h3>Lịch trình</h3>
                        <div class="tour-activities mt-30 mb-45">
                            <div class="tour-activity-item">
                                <i class="flaticon-hiking"></i>
                                <b>Hiking</b>
                            </div>
                            <div class="tour-activity-item">
                                <i class="flaticon-fishing"></i>
                                <b>Fishing</b>
                            </div>
                            <div class="tour-activity-item">
                                <i class="flaticon-man"></i>
                                <b>Kayak shooting</b>
                            </div>
                            <div class="tour-activity-item">
                                <i class="flaticon-kayak-1"></i>
                                <b>Kayak</b>
                            </div>
                            <div class="tour-activity-item">
                                <i class="flaticon-bonfire"></i>
                                <b>Campfire</b>
                            </div>
                            <div class="tour-activity-item">
                                <i class="flaticon-flashlight"></i>
                                <b>Night Exploring</b>
                            </div>
                            <div class="tour-activity-item">
                                <i class="flaticon-cycling"></i>
                                <b>Biking</b>
                            </div>
                            <div class="tour-activity-item">
                                <i class="flaticon-meditation"></i>
                                <b>Yoga</b>
                            </div>
                        </div>

                        <h3>Lịch trình chi tiết</h3>
                        <div class="accordion-two mt-25 mb-60" id="faq-accordion-two">
                            @php
                                $day = 1;
                            @endphp
                            @foreach($tourDetail->timeline as $index => $timeline)
                            <div class="accordion-item">
                                <h5 class="accordion-header">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo{{ $timeline->timelineID }}" aria-expanded="false" aria-controls="collapseTwo{{ $timeline->timelineID}}">
                                       Ngày {{ $day++ }}- {{ $timeline->title }}
                                    </button>
                                </h5>
                                <div id="collapseTwo{{ $timeline->timelineID }}" class="accordion-collapse collapse" data-bs-parent="#faq-accordion-two">
                                    <div class="accordion-body">
                                        <p>{!! $timeline->description !!}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>


                        <h3>Maps</h3>
                        <div class="tour-map mt-30 mb-50">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d96777.16150026117!2d-74.00840582560909!3d40.71171357405996!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1706508986625!5m2!1sen!2sbd" style="border:0; width: 100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                        <h3>Clients Reviews</h3>
                        <div class="clients-reviews bgc-black mt-30 mb-60">
                            <div class="left">
                                <b>4.8</b>
                                <span>(586 reviews)</span>
                                <div class="ratting">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                            <div class="right">
                                <div class="ratting-item">
                                    <span class="title">Services</span>
                                    <span class="line"><span style="width: 80%;"></span></span>
                                    <div class="ratting">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                </div>
                                <div class="ratting-item">
                                    <span class="title">Guides</span>
                                    <span class="line"><span style="width: 70%;"></span></span>
                                    <div class="ratting">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                </div>
                                <div class="ratting-item">
                                    <span class="title">Price</span>
                                    <span class="line"><span style="width: 80%;"></span></span>
                                    <div class="ratting">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                </div>
                                <div class="ratting-item">
                                    <span class="title">Safety</span>
                                    <span class="line"><span style="width: 80%;"></span></span>
                                    <div class="ratting">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                </div>
                                <div class="ratting-item">
                                    <span class="title">Foods</span>
                                    <span class="line"><span style="width: 80%;"></span></span>
                                    <div class="ratting">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                </div>
                                <div class="ratting-item">
                                    <span class="title">Hotels</span>
                                    <span class="line"><span style="width: 80%;"></span></span>
                                    <div class="ratting">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <h3>Clients Comments</h3>
                        <div class="comments mt-30 mb-60">
                            <div class="comment-body" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                                <div class="author-thumb">
                                    <img src="assets/images/blog/comment-author1.jpg" alt="Author">
                                </div>
                                <div class="content">
                                    <h6>Lonnie B. Horwitz</h6>
                                    <div class="ratting">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="time">Venice, Rome and Milan – 9 Days 8 Nights</span>
                                    <p>Tours and travels play a crucial role in enriching lives by offering unique experiences, cultural exchanges, and the joy of exploration.</p>
                                    <a class="read-more" href="#">Reply <i class="far fa-angle-right"></i></a>
                                </div>
                            </div>
                            <div class="comment-body comment-child" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                                <div class="author-thumb">
                                    <img src="assets/images/blog/comment-author2.jpg" alt="Author">
                                </div>
                                <div class="content">
                                    <h6>William G. Edwards</h6>
                                    <div class="ratting">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="time">Venice, Rome and Milan – 9 Days 8 Nights</span>
                                    <p>Tours and travels play a crucial role in enriching lives by offering unique experiences, cultural exchanges, and the joy of exploration.</p>
                                    <a class="read-more" href="#">Reply <i class="far fa-angle-right"></i></a>
                                </div>
                            </div>
                            <div class="comment-body" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                                <div class="author-thumb">
                                    <img src="assets/images/blog/comment-author3.jpg" alt="Author">
                                </div>
                                <div class="content">
                                    <h6>Jaime B. Wilson</h6>
                                    <div class="ratting">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="time">Venice, Rome and Milan – 9 Days 8 Nights</span>
                                    <p>Tours and travels play a crucial role in enriching lives by offering unique experiences, cultural exchanges, and the joy of exploration.</p>
                                    <a class="read-more" href="#">Reply <i class="far fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- Đánh giá và bình luận  FROM-->
                        <h3>Add Reviews</h3>
@if(session()->has('userid'))

<form action="{{ route('review.store') }}" method="post">
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

<textarea name="comment" class="form-control" rows="5" required></textarea>

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

<div class="alert alert-warning">
Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để đánh giá tour.
</div>

@endif
                    </div>
                    <div class="col-lg-4 col-md-8 col-sm-10 rmt-75">
                        <div class="blog-sidebar tour-sidebar">
                           
                            <div class="widget widget-booking" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                                <h5 class="widget-title">Đặt Tour</h5>
<form action="{{ route('booking.store', ['id' => $tourDetail->tourid]) }}" method="post">
@csrf
                                    <div class="date mb-25">
                                        <b>Ngày bắt đầu:</b>
                                        <input type="type" disabled value="{{ date('d-m-Y', strtotime($tourDetail->startdate)) }}"name="startdate"disabled>
                                    </div>
                                    <hr>
                                    <div class="date mb-25">
                                        <b>Ngày kết thúc:</b>
                                        <input type="type" disabled value="{{ date('d-m-Y', strtotime($tourDetail->enddate)) }}"name="enddate"disabled>
                                    </div>
                                    <hr>
                                    <div class="time py-5">
                                        <b>Thời gian :</b>
                                        <p>{{ $tourDetail->time }}</p>
                                        <input type="hidden" name="time">
                                    </div>
                                    <hr class="mb-25">
                                    <h6>Vé:</h6>
                                    <ul class="tickets clearfix">
                                        <li>
                                            Trẻ em 5 => 11 tuổi <span class="price">{{ number_format($tourDetail->pricechild, 0, ',', '.') }} VND</span>
                                            
                                        </li>
                                        <li>
                                            Người lớn <span class="price">{{ number_format($tourDetail->priceadult, 0, ',', '.') }} VND</span>
                                           
                                        </li>
                                    </ul>
@if(session()->has('userid'))

<a href="{{ route('booking.index', ['id' => $tourDetail->tourid]) }}"
class="theme-btn style-two w-100 mt-15 mb-5">
Đặt ngay
</a>

@else

<button type="button" onclick="showLoginNotification()" 
class="theme-btn style-two w-100 mt-15 mb-5">
Đặt ngay
</button>

@endif
                                    <div class="text-center">
                                        <a href="{{ route('contact') }}">Bạn cần hỗ trợ?</a>
                                    </div>
                                </form>
                            </div>
                            
                            <div class="widget widget-contact" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                                <h5 class="widget-title">Cần trợ giúp?</h5>
                                <ul class="list-style-one">
                                    <li><i class="far fa-envelope"></i> <a href="emilto:helpxample@gmail.com">Goviet@gmail.com</a></li>
                                    <li><i class="far fa-phone-volume"></i> <a href="callto:+000(123)45688">+000 (123) 456 88</a></li>
                                </ul>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Tour Details Area end -->
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
</script>  
        
@include('clients.blocks.new_letter')
@include('clients.blocks.footer')