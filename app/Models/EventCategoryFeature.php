<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategoryFeature extends Model
{
    protected $table = 'event_category_features';

    protected $fillable = [
        'event_category_id',
        'feature',
        'label',
        'is_enabled',
        'sort_order',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(
            EventCategory::class,
            'event_category_id'
        );
    }
}