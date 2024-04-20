<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPic extends Model
{
    use HasFactory;
    protected $table = 'itemPics';
    protected $fillable = [
        'pic',
        'category_data_id',
        'barcode',
    ];
}
