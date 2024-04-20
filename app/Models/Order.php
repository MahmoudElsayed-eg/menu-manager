<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id',
        'order',
        'total_price',
    ];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d h:i a');
    }

    public function scopeFilters(Builder $query, array $filters): Builder
    {
        // dd($filters['by']);
        $query->when($filters['table_id'] ?? false, fn ($query, $value) => $query->where('table_id', $value))
            ->when($filters['date'] ?? false, fn ($query, $value) => $query->whereDate('created_at', $value))
            ->when($filters['from'] ?? false, fn ($query, $value) => $query->where('total_price', '>=', $value))
            ->when($filters['to'] ?? false, fn ($query, $value) => $query->where('total_price', '<=', $value))
            ->when($filters['by'] ?? false, fn ($query, $value) => $query->orderBy('created_at', $value == 'true' ? 'asc' : 'desc'), fn ($query, $value) => $query->orderBy('created_at', 'desc'));
        return $query;
    }

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }
}
