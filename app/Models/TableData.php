<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TableData extends Model
{
    use HasFactory;
    protected $table = 'tableData';

    protected $fillable=[
        'barcode',
        'amount' ,
        'table_id',
        'printed',
    ];
    public function retail_data() : BelongsTo {
        return $this->belongsTo(Item::class,'barcode','barcode');
    }
    public function pics() : HasMany {
        return $this->hasMany(ItemPic::class,'barcode','barcode');
    }

    public function print_group() {
        $categoryData = CategoryData::where('barcode',$this->barcode)->first();
        $categoryData->load('category');
        $print_group = PrintGroup::find($categoryData->category->print_group_id);
        return $print_group->name;
    }
}
