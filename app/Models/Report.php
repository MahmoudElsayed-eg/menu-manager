<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Date;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'report'
    ];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d h:i a');
    }

    public function scopeFilters(Builder $query, array $filters): Builder
    {
        // dd($filters['by']);
        $query->when($filters['username'] ?? false, fn ($query, $value) => $query->where('username', 'like', "%$value%"))
            ->when($filters['date'] ?? false, fn ($query, $value) => $query->whereDate('created_at', $value));
        return $query;
    }
}
