<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentGateway extends Model
{
    public function gatewayMethods(): HasMany
    {
        return $this->hasMany(PaymentGatewayMethod::class);
    }
}