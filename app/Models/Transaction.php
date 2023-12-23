<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	use HasFactory;
	protected $guarded = ['id'];

	public function event()
	{
		return $this->belongsTo(Event::class, 'event_id');
	}
	public function ticket()
	{
		return $this->belongsTo(Ticket::class, 'ticket_id');
	}
}
