<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'reservation_code',
        'event_id',
        'ticket_id',
        'session_id',
        'quantity',
        'status',
        'expired_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    /**
     * Event yang di-reserve.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Tiket yang di-reserve.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}