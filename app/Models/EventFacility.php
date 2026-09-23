<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventFacility extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function tickets()
    {
        return $this->belongsToMany(
            Ticket::class,
            'ticket_facility',
            'facility_id',
            'ticket_id'
        )->withTimestamps();
    }
}
