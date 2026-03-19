@include('clients.blocks.header')

@include('clients.blocks.banner', ['title' => 'Tours'])

<section class="tour-grid-page py-100 rel z-1">
    <div class="container">
        <div class="row">
            
            @include('clients.blocks.sidebar-tour')
            
            <div class="col-lg-9">
                <div class="shop-shorter rel z-3 mb-20">
                    <ul class="grid-list mb-15 me-2">
                        <li><a href="#"><i class="fal fa-border-all"></i></a></li>
                        <li><a href="#"><i class="far fa-list"></i></a></li>
                    </ul>
                    <div class="sort-text mb-15 me-4 me-xl-auto">
                        Hiển thị {{ $tours->count() }} / {{ $tours->total() }} Tours 
                    </div>
                    <div class="sort-text mb-15 me-4">
                        Sắp xếp theo:
                    </div>
                    <select name="sort_by" form="filterForm" onchange="document.getElementById('filterForm').submit();">
                        <option value="default" {{ !request('sort_by') || request('sort_by') == 'default' ? 'selected' : '' }}>Mặc định</option>
                        <option value="new" {{ request('sort_by') == 'new' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="old" {{ request('sort_by') == 'old' ? 'selected' : '' }}>Cũ nhất</option>
                        <option value="high-to-low" {{ request('sort_by') == 'high-to-low' ? 'selected' : '' }}>Giá: Cao đến Thấp</option>
                        <option value="low-to-high" {{ request('sort_by') == 'low-to-high' ? 'selected' : '' }}>Giá: Thấp đến Cao</option>
                    </select>
                </div>
                
                <div class="tour-grid-wrap">
                    <div class="row">
                        
                        @if($tours->isEmpty())
                            <div class="col-12">
                                <div class="empty-result-area text-center py-5 px-3 bg-white shadow-sm rounded border">
                                    <div class="icon mb-4">
                                        <i class="fal fa-search-minus text-secondary" style="font-size: 80px; opacity: 0.5;"></i>
                                    </div>
                                    <h3 class="mb-3">Rất tiếc, không tìm thấy tour nào!</h3>
                                    <p class="text-muted mb-4 fs-5">
                                        @if(request('destination'))
                                            Chúng tôi không tìm thấy kết quả nào phù hợp với điểm đến <strong class="text-danger">"{{ request('destination') }}"</strong>.
                                            <br>
                                        @endif
                                        Vui lòng kiểm tra lại bộ lọc, thử một từ khóa khác hoặc xóa bộ lọc để xem các tour khác.
                                    </p>
                                    <a href="{{ route('Tours') }}" class="theme-btn style-two bgc-primary mt-2">
                                        <span data-hover="Xóa bộ lọc & Xem tất cả">Xóa bộ lọc & Xem tất cả</span>
                                        <i class="fal fa-sync-alt"></i>
                                    </a>
                                </div>
                            </div>
                            
                        @else
                            @foreach($tours as $tour)
                            <div class="col-xl-4 col-md-6">
                                <div class="destination-item tour-grid style-three bgc-lighter block_tours" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                                    <div class="image">
                                        <span class="badge bgc-pink">Featured</span>
                                        <a href="#" class="heart"><i class="fas fa-heart"></i></a>
                                        <img src="{{ asset('clients/assets/images/gallery-tours/' . ($tour->display_image ?? 'default.jpg')) }}" alt="{{ $tour->title }}">
                                    </div>
                                    <div class="content">
                                        <div class="destination-header">
                                            <span class="location"><i class="fal fa-map-marker-alt"></i>{{ $tour->destination }}</span>
                                            <div class="ratting">
                                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                        <h6><a href="{{ route('tour-detail', $tour->tourid) }}">{{ $tour->title }}</a></h6>
                                        <ul class="blog-meta">
                                            <li><i class="far fa-clock"></i> {{ $tour->time }}</li>
                                            <li><i class="far fa-user"></i> {{ $tour->quantity }}</li>
                                        </ul>
                                        <div class="destination-footer">
                                            <span class="price"><span>{{ number_format($tour->priceadult, 0, ',', '.') }} VND</span>/Người</span>
                                            <a href="{{ route('tour-detail', $tour->tourid) }}" class="theme-btn style-two style-three">
                                                <i class="fal fa-arrow-right"></i>
                                            </a>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif

                    </div>
                </div>
                
                @if($tours->isNotEmpty())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $tours->links('pagination::bootstrap-5') }} </div>
                @endif
                
            </div>
        </div>
    </div>
</section>
@include('clients.blocks.footer')