<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryZone extends Model
{
    protected $fillable = [
        'name', 'name_bn', 'fee', 'free_delivery_threshold',
        'estimated_days_min', 'estimated_days_max', 'is_active',
    ];

    protected $casts = [
        'fee' => 'decimal:2',
        'free_delivery_threshold' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
