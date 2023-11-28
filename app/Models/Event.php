<?php

namespace App\Models;

use App\Models\Theme;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\Province;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
	use HasFactory;
	protected $guarded = ['id'];
	protected $casts = ['start_date' => 'datetime', 'end_date' => 'datetime'];

	public function penyelenggara()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function province()
	{
		return $this->belongsTo(Province::class, 'location_province', 'code');
	}
	public function categories()
	{
		return $this->belongsTo(Category::class, 'category');
	}
	public function themes()
	{
		return $this->belongsTo(Theme::class, 'theme');
	}
	public function ticket()
	{
		return $this->hasMany(Ticket::class, 'event_id');
	}

	public function getRouteKeyName()
	{
		return 'slug';
	}
}
