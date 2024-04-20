<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';

    protected $table = 'pos_items';


    function scopeGetItems(Builder $query, array $sections): Builder
    {
        foreach ($sections as $department) {
            $query->orWhere('department', $department);
        }
        return $query;
    }

    function scopeGetItemsByBarcode(Builder $query, array $barcodes): Builder
    {
        if (count($barcodes) == 0) {
            return $query->where('barcode', '');
        }
        foreach ($barcodes as $barcode) {
            $query->orWhere('barcode', $barcode);
        }
        return $query;
    }
}
