<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomForm extends Model
{
	use HasFactory;
	protected $guarded = ['id'];

	public function value()
	{
		return $this->hasMany(TransactionForm::class, 'form_id', 'id');
	}
}
