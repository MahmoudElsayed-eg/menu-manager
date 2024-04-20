<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryData extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'categoryData';
    protected $fillable = [
        'position',
        'barcode',
        'category_id',
        'key_id',
    ];

    public function pics(): HasMany
    {
        return $this->hasMany(ItemPic::class);
    }

    public function category() : BelongsTo {
        return $this->belongsTo(Category::class);
    }

}
