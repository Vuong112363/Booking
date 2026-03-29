<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Clients\Tours as Tour; 
use App\Models\TourImage;
use App\Models\Booking;
use App\Models\Admin\TourSchedule;

class TourController extends Controller
{
    // Cấu hình đường dẫn ảnh để dễ quản lý và thay đổi sau này
    private $imagePath = 'clients/assets/images/gallery-tours';

    // ==========================================
    // 1. HIỂN THỊ DANH SÁCH (Tối ưu truy vấn)
    // ==========================================
    public function index(Request $request)
    {
        $query = Tour::query();

        // Tìm kiếm thông minh
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                if (is_numeric($keyword)) {
                    $q->where('tourid', $keyword);
                }
                $q->orWhere('title', 'like', "%$keyword%")
                  ->orWhere('destination', 'like', "%$keyword%");
            });
        }

        if ($request->filled('domain')) {
            $query->where('domain', $request->domain);
        }

        // Load kèm số lượng lịch trình và ảnh gallery để hiển thị nhanh
        $tours = $query->withCount('schedules')
                       ->orderBy('tourid', 'desc')
                       ->paginate(10);

        return view('admin.tours.index', compact('tours'));
    }

    public function create()
    {
        return view('admin.tours.create');
    }

    // ==========================================
    // 2. LƯU TOUR MỚI (Đã tích hợp Điểm đón & Transaction)
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|max:255',
            'domain'     => 'required|in:b,t,n',
            'image_main' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tour_includes' => 'nullable|array',
        'tour_excludes' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $tour = new Tour();
            $this->saveTourData($tour, $request); // Gán dữ liệu cơ bản

            // Xử lý ảnh chính
            if ($request->hasFile('image_main')) {
                $tour->images = $this->uploadFile($request->file('image_main'), 'main');
            }
            $tour->save();

            // Xử lý các bảng phụ qua Helper
            $this->handleTimeline($tour->tourid, $request);
            $this->handleGallery($tour->tourid, $request);
            $this->handlePickups($tour->tourid, $request);
            $this->handleInitialSchedule($tour->tourid, $request);

            DB::commit();
            return redirect()->route('admin.tours.index')->with('success', 'Đã tạo Tour mới thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        // Load Tour cùng toàn bộ quan hệ cần thiết
        $tour = Tour::with(['tourImages', 'schedules', 'pickupPoints'])->findOrFail($id);
        
        $tour->timeline = DB::table('tbl_timeline')
                            ->where('tourid', $id)
                            ->orderBy('timelineID', 'asc')
                            ->get();
                            
        return view('admin.tours.edit', compact('tour'));
    }

    // ==========================================
    // 3. CẬP NHẬT TOUR (Gọn gàng & An toàn)
    // ==========================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'      => 'required|max:255',
            'domain'     => 'required|in:b,t,n',
            'image_main' => 'nullable|image|max:2048',
            'tour_includes' => 'nullable|array',
        'tour_excludes' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $tour = Tour::findOrFail($id);
            $this->saveTourData($tour, $request);

            // Cập nhật ảnh chính (xóa ảnh cũ)
            if ($request->hasFile('image_main')) {
                $this->deleteFile($tour->images);
                $tour->images = $this->uploadFile($request->file('image_main'), 'main');
            }
            $tour->save();

            // Cập nhật các bảng phụ (Xóa cũ - Thêm mới để đảm bảo tính đồng bộ)
            $this->handleTimeline($id, $request);
            $this->handlePickups($id, $request);
            $this->handleGalleryUpdate($tour->tourid, $request);

            DB::commit();
            return redirect()->route('admin.tours.index')->with('success', 'Cập nhật Tour thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi cập nhật: ' . $e->getMessage());
        }
    }

    // ==========================================
    // 4. CÁC HÀM TRỢ GIÚP (PRIVATE HELPERS - NÂNG CẤP)
    // ==========================================

    private function saveTourData($tour, $request) {
        $tour->title          = $request->title;
        $tour->duration       = $request->duration;
        $tour->destination    = $request->destination;
        $tour->departure_city = $request->departure_city; // Cột mới thảo luận
        $tour->domain         = $request->domain;
        $tour->availability   = $request->availability ?? 1;
        $tour->description    = $request->description;
        $tour->time           = $request->time;
        $tour->tour_includes  = $request->tour_includes; 
    $tour->tour_excludes  = $request->tour_excludes;
    }

    private function handleTimeline($tourid, $request) {
        if ($request->has('timeline_title')) {
            DB::table('tbl_timeline')->where('tourid', $tourid)->delete();
            foreach ($request->timeline_title as $key => $title) {
                if (!empty($title)) {
                    DB::table('tbl_timeline')->insert([
                        'tourid'      => $tourid,
                        'title'       => $title,
                        'description' => $request->timeline_description[$key] ?? ''
                    ]);
                }
            }
        }
    }

    private function handlePickups($tourid, $request) {
        // Lưu ý: SQL của bạn dùng 'tour_id' (có dấu gạch dưới)
        DB::table('tbl_tour_pickups')->where('tourid', $tourid)->delete();
        if ($request->has('pk_name')) {
            foreach ($request->pk_name as $key => $name) {
                if (!empty($name)) {
                    DB::table('tbl_tour_pickups')->insert([
                        'tourid'     => $tourid,
                        'pickup_name' => $name,
                        'pickup_time' => $request->pk_time[$key],
                        'extra_price' => $request->pk_price[$key] ?? 0,
                        'fee_type'    => $request->pk_type[$key] ?? 0,
                    ]);
                }
            }
        }
    }

    private function handleGalleryUpdate($tourid, $request) {
        // Xóa ảnh cũ nếu có yêu cầu
        if ($request->has('delete_images')) {
            $images = TourImage::whereIn('imageid', $request->delete_images)->get();
            foreach ($images as $img) {
                $this->deleteFile($img->imageurl);
                $img->delete();
            }
        }
        $this->handleGallery($tourid, $request);
    }

    private function handleGallery($tourid, $request) {
        if ($request->hasFile('image_gallery')) {
            foreach ($request->file('image_gallery') as $file) {
                TourImage::create([
                    'tourid'     => $tourid,
                    'imageurl'   => $this->uploadFile($file, 'gallery'),
                    'uploadDate' => now()
                ]);
            }
        }
    }

    private function handleInitialSchedule($tourid, $request) {
        if ($request->filled('startdate') && $request->filled('priceadult')) {
            DB::table('tbl_tour_schedules')->insert([
                'tourid'     => $tourid,
                'startdate'  => $request->startdate,
                'enddate'    => $request->enddate,
                'priceadult' => $request->priceadult,
                'pricechild' => $request->pricechild ?? 0,
                'quantity'   => $request->quantity ?? 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
    public function addSchedule(Request $request)
{
    try {
        $request->validate([
            'tourid'     => 'required',
            'startdate'  => 'required|date',
            'priceadult' => 'required|numeric',
            'quantity'   => 'required|numeric',
        ]);

        // SỬA TẠI ĐÂY: tour_schedules -> tbl_tour_schedules
        \DB::table('tbl_tour_schedules')->insert([
            'tourid'     => $request->tourid,
            'startdate'  => $request->startdate,
            'enddate'    => $request->enddate,
            'priceadult' => $request->priceadult,
            'pricechild' => $request->pricechild ?? 0,
            'quantity'   => $request->quantity ?? 20,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Thêm lịch trình thành công!']);
        
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}
public function toggleAvailability(Request $request)
{
    try {
        $tour = Tour::findOrFail($request->id);
        $tour->availability = $request->status;
        $tour->save();

        return response()->json([
            'success' => true, 
            'message' => 'Cập nhật trạng thái thành công!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false, 
            'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
        ], 500);
    }
}

public function deleteSchedule($id)
{
    try {
        // SỬA TẠI ĐÂY: tour_schedules -> tbl_tour_schedules
        // Đảm bảo tên cột khóa chính của bạn là schedule_id
        \DB::table('tbl_tour_schedules')->where('schedule_id', $id)->delete();
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}

    private function uploadFile($file, $prefix) {
        $filename = time() . "_{$prefix}_" . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($this->imagePath), $filename);
        return $filename;
    }

    private function deleteFile($filename) {
        if ($filename) {
            $path = public_path($this->imagePath . '/' . $filename);
            if (File::exists($path)) File::close(File::delete($path));
        }
    }
}