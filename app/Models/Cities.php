<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
	protected $table = 'indonesia_cities';
	use HasFactory;
	protected $guarded = ['id'];
}
