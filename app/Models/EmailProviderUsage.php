<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailProviderUsage extends Model
{
    protected $fillable = [
        'provider',
        'window_start',
        'sent_count',
    ];

    protected $casts = [
        'window_start' => 'datetime',
        'sent_count' => 'integer',
    ];
}