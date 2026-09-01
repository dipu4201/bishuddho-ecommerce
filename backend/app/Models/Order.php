<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    public const STATUSES = [
        'pending', 'confirmed', 'processing', 'packed',
        'shipped', 'out_for_delivery', 'delivered',
        'cancelled', 'returned', 'refunded',
    ];

    protected $fillable = [
        'order_number', 'user_id', 'address_id', 'coupon_id',
        'customer_name', 'customer_phone', 'customer_email',
        'subtotal', 'discount_amount', 'delivery_fee', 'total',
        'payment_method', 'payment_status', 'payment_transaction_id',
        'status', 'note',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (empty($order->order_number)) {
                $order->order_number = 'BIS-' . now()->format('Y') . '-' . str_pad(
                    (string) (self::whereYear('created_at', now()->year)->count() + 1),
                    6, '0', STR_PAD_LEFT
                );
            }
        });

        static::updated(function (Order $order) {
            if ($order->isDirty('status')) {
                $order->statusHistories()->create([
                    'status' => $order->status,
                    'changed_by' => auth()->user()->email ?? 'system',
                ]);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class);
    }
}
