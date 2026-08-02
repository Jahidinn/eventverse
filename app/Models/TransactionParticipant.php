<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionParticipant extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function forms()
	{
		return $this->hasMany(
			TransactionForm::class,
			'participant_id'
		);
	}
}
