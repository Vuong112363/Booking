<?php

namespace App\Models\Admin; // Bỏ chữ \Setting ở cuối đi bạn nhé

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    // Tên bảng trong DB (Nếu bạn đặt tên bảng là 'settings' thì Laravel tự hiểu, 
    // nhưng nếu bạn đặt tên khác như 'tbl_setting' thì hãy thêm dòng dưới đây)
    // protected $table = 'settings'; 

    protected $fillable = ['key', 'value'];
    
    // Nếu bạn có cột created_at và updated_at trong DB thì để true, không thì để false
    public $timestamps = true; 
    
}