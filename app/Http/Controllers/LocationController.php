<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Region;
use App\Models\District;
use App\Models\Ward;
use App\Models\Street;

class LocationController extends Controller
{
    public function getCountries()
    {
        $countries = Country::all();
        return response()->json($countries);
    }

    public function getRegions(Request $request)
    {
        $regions = Region::where('country_id', $request->country_id)->get();
        return response()->json($regions);
    }

    public function getDistricts(Request $request)
    {
        $districts = District::where('region_id', $request->region_id)->get();
        return response()->json($districts);
    }

    public function getWards(Request $request)
    {
        $wards = Ward::where('district_id', $request->district_id)->get();
        return response()->json($wards);
    }

    public function getStreets(Request $request)
    {
        $streets = Street::where('ward_id', $request->ward_id)->get();
        return response()->json($streets);
    }
}
