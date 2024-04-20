<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'category';

    protected $fillable = [
        'position',
        'name',
        'pic',
        'group_id',
        'print_group_id',
    ];


    public function scopeFilters(Builder $query, array $filters): Builder
    {
        return $query->when($filters['search'] ?? false, function ($query, $value) {
            $params = explode(' ', $value);
            for ($i = 0; $i < count($params); $i++) {
                $query->where('cat_title', 'Like', "%{$params[$i]}%");
            }
            return $query;
        });
    }

    public function categoryData(): HasMany
    {
        return $this->hasMany(CategoryData::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(PrintGroup::class);
    }
    // public function meals(): HasMany
    // {
    //     return $this->hasMany(Meal::class, 'meal_category')->where('deleted', false)->orderByDesc('meal_promo');
    // }
}
