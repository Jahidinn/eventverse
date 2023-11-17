<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\Province;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
	use HasFactory;
	protected $guarded = ['id'];

	public function penyelenggara()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function province()
	{
		return $this->belongsTo(Province::class, 'location_province', 'code');
	}

	public function getRouteKeyName()
	{
		return 'slug';
	}
}
