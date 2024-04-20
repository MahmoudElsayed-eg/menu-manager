<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'zone_id',
        'position',
        'numPersons',
        'numChairs',
        'x',
        'y',
        'width',
        'height',
        'round',
        'textcolor',
        'tablecolor',
        'merged',
        'status',
    ];
    
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function data() : HasMany {
        return $this->hasMany(TableData::class);
    }

    public function orders() : HasMany {
        return $this->hasMany(Order::class);
    }
}
