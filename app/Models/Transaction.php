<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	use HasFactory;
	protected $guarded = ['id'];

	protected static function booted(): void
	{
		static::created(function (Transaction $transaction) {
			if (blank($transaction->invoice_number)) {
				$transaction->forceFill([
					'invoice_number' => $transaction->buildInvoiceNumber(),
				])->saveQuietly();
			}
		});
	}

	public function buildInvoiceNumber(): string
	{
		$date = $this->created_at
			? $this->created_at->format('Ymd')
			: now()->format('Ymd');

		return 'INV-' . $date . '-' . str_pad((string) $this->getKey(), 6, '0', STR_PAD_LEFT);
	}

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

	public function reservation()
	{
		return $this->belongsTo(
			Reservation::class
		);
	}


}
