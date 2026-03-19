<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'tbl_reviews';
    protected $primaryKey = 'reviewid';

    public $timestamps = false;

    protected $fillable = [
        'tourid',
        'userid',
        'rating',
        'comment',
        'createdat'
    ];
}