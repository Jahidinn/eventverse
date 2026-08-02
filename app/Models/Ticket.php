<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
	use HasFactory;
	protected $guarded = ['id'];

	public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'ticket_id');
    }

	# HELPER AVALIABLE TICKET
	public function getAvailableQuantityAttribute(): int
	{
		return max(
			$this->ticket_quota
			- $this->reserved_quantity
			- $this->sold_quantity,
			0
		);
	}
}
