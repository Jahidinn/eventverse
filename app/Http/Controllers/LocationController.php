<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Province;

class LocationController extends Controller
{
    /**
     * List Province
     */
    public function provinces()
    {
        return response()->json(
            Province::orderBy('name')->get(['code', 'name'])
        );
    }

    /**
     * List City by Province
     */
    public function cities($province)
    {
        return response()->json(
            City::where('province_code', $province)
                ->orderBy('name')
                ->get(['code', 'name'])
        );
    }
}
