<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Tours extends Model
{
    use HasFactory;

    protected $table = 'tbl_tours';
    protected $primaryKey = 'tourid'; // Khai báo khóa chính để Laravel hiểu
    public $timestamps = false; // Hoặc true nếu bảng của bạn có created_at, updated_at

    // Các trường cho phép insert/update hàng loạt (Mass Assignment)
    protected $fillable = [
        'title', 
        'description', 
        'destination', 
        'duration', 
        'priceadult', 
        'pricechild', 
        'quantity', 
        'startdate', 
        'enddate', 
        'time',
        'images'
    ];

    /**
     * Lấy danh sách tất cả các tour (Đã tối ưu Query)
     */
public function getAllTours()
{
    $allTours = DB::table($this->table)->paginate(9); // mỗi trang 9 tour

    foreach ($allTours as $tour) {

        // nếu có ảnh trực tiếp
        if (!empty($tour->images)) {
            $tour->display_image = $tour->images;
        } 
        else {

            // lấy ảnh đầu tiên trong bảng images
            $firstImage = DB::table('tbl_images')
                ->where('tourid', $tour->tourid)
                ->value('imageUrl');

            $tour->display_image = $firstImage ?: 'default.jpg';
        }

    }

    return $allTours;
}

    /**
     * Lấy thông tin chi tiết của 1 tour cụ thể
     */
    public function getTourDetail($id)
    {
        // Lấy thông tin cơ bản của tour
        $getTourDetail = DB::table($this->table)
            ->where('tourid', $id) // Đã chuẩn hóa thành chữ thường 'tourid'
            ->first();

        // Nếu tour tồn tại thì mới query tiếp ảnh và lịch trình
        if ($getTourDetail) {
            // Lấy danh sách hình ảnh (giới hạn 5 ảnh như bạn muốn)
            $getTourDetail->images = DB::table('tbl_images')
                ->where('tourid', $getTourDetail->tourid)
                ->limit(5)
                ->pluck('imageUrl')
                ->toArray(); // Ép kiểu về Array để giao diện dễ dùng hàm foreach hoặc gọi chỉ số [0], [1]

            // Lấy danh sách lịch trình (timeline)
            $getTourDetail->timeline = DB::table('tbl_timeline')
                ->where('tourid', $getTourDetail->tourid)
                ->orderBy('timelineID', 'asc') // Sắp xếp theo ID hoặc ngày cho logic
                ->get();
                $getTourDetail->pickupPoints = DB::table('tbl_tour_pickups')
            ->where('tourid', $getTourDetail->tourid)
            ->get();
        }

        return $getTourDetail;
    }
    
public function tourImages()
    {
        // Thêm \App\Models\ phía trước TourImage::class để trỏ về đúng thư mục gốc Models
        return $this->hasMany(\App\Models\TourImage::class, 'tourid', 'tourid');
    }

    public function booking()
    {
        // Nhớ đảm bảo Model Booking của bạn đang nằm ở App\Models\Booking
        return $this->hasMany(\App\Models\Booking::class, 'tourid', 'tourid');
    }
    
    /**
     * Hàm hỗ trợ thêm mới Tour (Dùng cho trang Admin)
     */
    public function insertTour($data)
    {
        return DB::table($this->table)->insertGetId($data); // Trả về ID của tour vừa tạo
    }
    // Thêm hàm này vào trong class Tours
    public function schedules()
    {
        // Khai báo: 1 Tour có nhiều Lịch trình (Chỉ lấy các ngày chưa khởi hành)
        return $this->hasMany(TourSchedule::class, 'tourid', 'tourid')
                    ->whereDate('startdate', '>=', now())
                    ->orderBy('startdate', 'asc');
    }
    public function pickupPoints() {
    return $this->hasMany(\App\Models\TourPickup::class, 'tourid', 'tourid');
}

    public function searchTours($destination, $start_date, $end_date, $guests)
{
    $query = DB::table($this->table);

    // tìm theo điểm đến
    if(!empty($destination)){
        $query->where('destination','like','%'.$destination.'%');
    }

    // tìm theo ngày khởi hành
    if(!empty($start_date)){
        $query->whereDate('startdate','>=',$start_date);
    }

    // tìm theo ngày kết thúc
    if(!empty($end_date)){
        $query->whereDate('enddate','<=',$end_date);
    }

    // tìm theo số người
    if(!empty($guests)){
        $query->where('quantity','>=',$guests);
    }

    $allTours = $query->paginate(9)->appends(request()->query());

    foreach ($allTours as $tour) {

        if (!empty($tour->images)) {
            $tour->display_image = $tour->images;
        } 
        else {

            $firstImage = DB::table('tbl_images')
                ->where('tourid', $tour->tourid)
                ->value('imageUrl');

            $tour->display_image = $firstImage ?: 'default.jpg';
        }
    }

    return $allTours;
}

}
