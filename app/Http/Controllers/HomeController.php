<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Provinces;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	public function index()
	{

		return view('apps.home');
	}
}
