<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailProvider extends Model
{
    protected $fillable = [
        'code',
        'name',
        'driver',
        'hourly_limit',
        'priority',
        'is_active',
    ];

    protected $casts = [
        'hourly_limit' => 'integer',
        'priority' => 'integer',
        'is_active' => 'boolean',
    ];

    public function usages(): HasMany
    {
        return $this->hasMany(EmailProviderUsage::class, 'provider_id');
    }
}