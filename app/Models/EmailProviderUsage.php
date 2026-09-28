<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EmailProvider;

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

    public function provider()
    {
        return $this->belongsTo(EmailProvider::class, 'provider_id');
    }
}