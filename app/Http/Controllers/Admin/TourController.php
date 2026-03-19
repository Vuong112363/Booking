<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
// Gọi Model Tours từ thư mục Clients và gán bí danh là Tour để code ngắn gọn
use App\Models\Clients\Tours as Tour; 
use App\Models\TourImage;
use App\Models\Booking;

class TourController extends Controller
{
    // ==========================================
    // 1. HIỂN THỊ DANH SÁCH & TÌM KIẾM
    // ==========================================
    public function index(Request $request)
    {
        $query = Tour::query();

        // Tìm kiếm theo ID, Tên, hoặc Điểm đến
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                if (is_numeric($keyword)) {
                    $q->where('tourid', $keyword);
                }
                $q->orWhere('title', 'like', '%' . $keyword . '%')
                  ->orWhere('destination', 'like', '%' . $keyword . '%');
            });
        }

        // Lọc theo vùng miền
        if ($request->filled('domain')) {
            $query->where('domain', $request->domain);
        }

        $tours = $query->orderBy('tourid', 'desc')->paginate(10);
        return view('admin.tours.index', compact('tours'));
    }

    // ==========================================
    // 2. FORM THÊM MỚI
    // ==========================================
    public function create()
    {
        return view('admin.tours.create');
    }

    // ==========================================
    // 3. XỬ LÝ LƯU TOUR MỚI VÀ ẢNH
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'priceadult' => 'required|numeric',
            'domain' => 'required|in:b,t,n',
            'image_main' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_gallery' => 'array|max:5',
            'image_gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $tour = new Tour();
        $tour->title = $request->title;
        $tour->duration = $request->duration;
        $tour->destination = $request->destination;
        $tour->domain = $request->domain;
        $tour->startdate = $request->startdate;
        $tour->enddate = $request->enddate;
        $tour->priceadult = $request->priceadult;
        $tour->pricechild = $request->pricechild ?? 0;
        $tour->quantity = $request->quantity ?? 0;
        $tour->availability = $request->availability;
        $tour->description = $request->description;
        $tour->time = $request->time;

        // Xử lý Ảnh chính (Thumbnail)
        if ($request->hasFile('image_main')) {
            $file = $request->file('image_main');
            $filename = time() . '_main_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('clients/assets/images/gallery-tours'), $filename);
            $tour->images = $filename;
        }

        // PHẢI LƯU TOUR TRƯỚC ĐỂ CÓ ID
        $tour->save();
        if ($request->has('timeline_title')) {
    foreach ($request->timeline_title as $key => $title) {
        if (!empty($title)) { // Tránh lưu các ngày bị bỏ trống
            DB::table('tbl_timeline')->insert([
                'tourid'      => $tour->tourid,
                'title'       => $title,
                'description' => $request->timeline_description[$key] ?? ''
            ]);
        }
    }
}

        // Xử lý Ảnh Gallery
        if ($request->hasFile('image_gallery')) {
            foreach ($request->file('image_gallery') as $galleryFile) {
                $galleryName = time() . '_gallery_' . uniqid() . '.' . $galleryFile->getClientOriginalExtension();
                $galleryFile->move(public_path('clients/assets/images/gallery-tours'), $galleryName);

                TourImage::insert([
                    'tourid' => $tour->tourid,
                    'imageurl' => $galleryName,
                    'description' => 'Ảnh chi tiết ' . $tour->title,
                    'uploadDate' => now()
                ]);
            }
        }

        return redirect()->route('admin.tours.index')->with('success', 'Đã thêm Tour mới và tải ảnh thành công!');
    }

    // ==========================================
    // 4. FORM CHỈNH SỬA
    // ==========================================
    public function edit($id)
    {
        // Load Tour kèm theo mảng ảnh Gallery qua relationship 'tourImages'
        $tour = Tour::with('tourImages')->findOrFail($id);
        $tour->timeline = DB::table('tbl_timeline')
                            ->where('tourid', $id)
                            ->orderBy('timelineID', 'asc') // Sắp xếp theo thứ tự thêm vào
                            ->get();
        return view('admin.tours.edit', compact('tour'));
    }

    // ==========================================
    // 5. CẬP NHẬT TOUR VÀ ẢNH
    // ==========================================
public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'priceadult' => 'required|numeric',
            'domain' => 'required|in:b,t,n',
            'image_main' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_gallery' => 'array|max:5',
            'image_gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $tour = Tour::findOrFail($id);
        
        // 1. Cập nhật các trường dữ liệu text
        $tour->title = $request->title;
        $tour->duration = $request->duration;
        $tour->destination = $request->destination;
        $tour->domain = $request->domain;
        $tour->startdate = $request->startdate;
        $tour->enddate = $request->enddate;
        $tour->priceadult = $request->priceadult;
        $tour->pricechild = $request->pricechild ?? 0;
        $tour->quantity = $request->quantity ?? 0;
        $tour->availability = $request->availability;
        $tour->description = $request->description;
        $tour->time = $request->time;

        // 2. Cập nhật Ảnh Chính (CHỈ XỬ LÝ 1 LẦN)
        if ($request->hasFile('image_main')) {
            // Xóa ảnh cũ đi
            if ($tour->images) {
                $oldImagePath = public_path('clients/assets/images/gallery-tours/' . $tour->images);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
            // Lưu ảnh mới
            $file = $request->file('image_main');
            $filename = time() . '_main_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('clients/assets/images/gallery-tours'), $filename);
            $tour->images = $filename;
        }

        // Lưu toàn bộ thông tin tour (CHỈ GỌI LỆNH SAVE 1 LẦN Ở ĐÂY)
        $tour->save();

        // 3. Xử lý Lịch trình (Timeline)
        if ($request->has('timeline_title')) {
            // Xóa lịch trình cũ trong DB
            DB::table('tbl_timeline')->where('tourid', $id)->delete();

            // Thêm lại lịch trình mới
            foreach ($request->timeline_title as $key => $title) {
                if (!empty($title)) {
                    DB::table('tbl_timeline')->insert([
                        'tourid'      => $tour->tourid,
                        'title'       => $title,
                        'description' => $request->timeline_description[$key] ?? ''
                    ]);
                }
            }
        }

        // 4. XÓA CÁC ẢNH CŨ TRONG GALLERY NẾU NGƯỜI DÙNG BẤM NÚT "X"
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $img = TourImage::find($imageId);
                if ($img) {
                    // Xóa file vật lý trong folder
                    $imagePath = public_path('clients/assets/images/gallery-tours/' . $img->imageurl);
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
                    // Xóa trong database
                    $img->delete();
                }
            }
        }

        // 5. Thêm Ảnh Gallery Mới (Không xóa ảnh cũ, chỉ add thêm)
        if ($request->hasFile('image_gallery')) {
            foreach ($request->file('image_gallery') as $galleryFile) {
                $galleryName = time() . '_gallery_' . uniqid() . '.' . $galleryFile->getClientOriginalExtension();
                $galleryFile->move(public_path('clients/assets/images/gallery-tours'), $galleryName);

                TourImage::insert([
                    'tourid' => $tour->tourid,
                    'imageurl' => $galleryName,
                    'description' => 'Ảnh chi tiết ' . $tour->title,
                    'uploadDate' => now()
                ]);
            }
        }

        return redirect()->route('admin.tours.index')->with('success', 'Đã cập nhật Tour thành công!');
    }
    // ==========================================
    // 6. XÓA TOUR VÀ DỌN DẸP ẢNH TRÊN SERVER
    // ==========================================
public function delete($id)
    {
        $tour = Tour::with(['tourImages', 'booking'])->findOrFail($id);

        // NẾU CÓ NGƯỜI ĐẶT TOUR RỒI THÌ KHÔNG CHO XÓA, CHỈ CHO ĐỔI TRẠNG THÁI TẠM NGƯNG
        if ($tour->booking()->count() > 0) {
            return redirect()->route('admin.tours.index')->with('error', 'Không thể xóa Tour này vì đã có người đặt. Bạn chỉ có thể chuyển trạng thái sang Tạm ngưng!');
        }

        // 1. Xóa file ảnh chính
        if ($tour->images) {
            $imagePath = public_path('clients/assets/images/gallery-tours/' . $tour->images);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        // 2. Xóa các file ảnh Gallery
        foreach ($tour->tourImages as $galleryImg) {
            $galleryPath = public_path('clients/assets/images/gallery-tours/' . $galleryImg->imageurl);
            if (File::exists($galleryPath)) {
                File::delete($galleryPath);
            }
        }
DB::table('tbl_timeline')->where('tourid', $id)->delete();
        TourImage::where('tourid', $id)->delete();
        $tour->delete();

        return redirect()->route('admin.tours.index')->with('success', 'Đã xóa toàn bộ Tour và dữ liệu ảnh!');
    }
}