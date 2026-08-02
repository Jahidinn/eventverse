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

	public function individual()
	{
		return $this->belongsTo(User::class, 'organizer_id');
	}

	public function org()
	{
		return $this->belongsTo(Organisation::class, 'organizer_id');
	}

	public function province()
	{
		return $this->belongsTo(Province::class, 'location_province', 'code');
	}

	public function category()
	{
		return $this->belongsTo(EventCategory::class);
	}
	
	public function themes()
	{
		return $this->belongsTo(Theme::class, 'theme');
	}

	// Metode lama, nanti akan dihapus
	public function ticket()
	{
		return $this->hasMany(Ticket::class, 'event_id');
	}
	public function tickets()
	{
		return $this->hasMany(Ticket::class, 'event_id');
	}

	public function getRouteKeyName()
	{
		return 'slug';
	}

	public function images()
{
    return $this->hasMany(
        EventImage::class,
			'event_id',
			'event_id'
		)->orderBy('sort_order');
	}
}
