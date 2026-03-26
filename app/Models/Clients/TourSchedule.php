<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourSchedule extends Model
{
    use HasFactory;

    protected $table = 'tbl_tour_schedules';
    protected $primaryKey = 'schedule_id';
    
    protected $fillable = [
        'tourid', 'startdate', 'enddate', 'quantity', 'priceadult', 'pricechild'
    ];

    // Khai báo: 1 Lịch trình thuộc về 1 Tour
    public function tour()
    {
        return $this->belongsTo(Tours::class, 'tourid', 'tourid');
    }
}