<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
	protected $table = 'indonesia_provinces';
	use HasFactory;
	protected $guarded = ['id'];
}
