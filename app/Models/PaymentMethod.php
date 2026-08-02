<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PaymentMethod extends Model
{
    protected $appends = [
        'icon_url',
    ];

    protected function iconUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => rtrim(config('payment.icon_base_url'), '/')
                . '/'
                . ltrim($this->icon, '/')
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PaymentCategory::class, 'payment_category_id');
    }

    public function gatewayMethods(): HasMany
    {
        return $this->hasMany(PaymentGatewayMethod::class);
    }
}