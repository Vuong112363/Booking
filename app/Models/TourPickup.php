<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TourPickup extends Model {
    // Cấu hình model điểm đón của tour
    protected $table = 'tbl_tour_pickups';
    protected $primaryKey = 'pickup_id';
    public $timestamps = false;
    protected $fillable = ['tourid', 'pickup_name', 'pickup_time', 'extra_price', 'fee_type'];

}
