<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	use HasFactory;
	protected $guarded = ['id'];

	protected $casts = [
		'payment_payload' => 'array',
		'paid_at' => 'datetime',
		'expired_at' => 'datetime',
	];

	public function event()
	{
		return $this->belongsTo(Event::class, 'event_id');
	}
	public function ticket()
	{
		return $this->belongsTo(Ticket::class, 'ticket_id');
	}

	public function participants()
	{
		return $this->hasMany(
			TransactionParticipant::class,
			'transaction_id'
		);
	}

	public function paymentGatewayMethod(): BelongsTo
    {
        return $this->belongsTo(
            PaymentGatewayMethod::class,
            'payment_gateway_method_id'
        );
    }


}
