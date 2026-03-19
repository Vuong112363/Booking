<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Booking extends Model
{

protected $table = 'tbl_bookings';

protected $primaryKey = 'bookingid';

public $timestamps = false;

protected $fillable = [

'tourid',
'userid',
'bookingdate',
'numadults',
'numchildren',
'totalprice',
'bookingstatus',
'specialrequest',
'paymentmethod',
    'deposit_amount',
    'paid_amount',
    'paymentstatus'

];


// Quan hệ User
public function user()
{
return $this->belongsTo(User::class,'userid','userid');
}


// Quan hệ Tour
public function tour()
{
return $this->belongsTo(\App\Models\Clients\Tours::class, 'tourid', 'tourid');
}

}