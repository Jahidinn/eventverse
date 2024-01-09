<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganisationMember extends Model
{
	use HasFactory;
	protected $guarded = ['id'];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function org()
	{
		return $this->belongsTo(Organisation::class, 'org_id');
	}
}
