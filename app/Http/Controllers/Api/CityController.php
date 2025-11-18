<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;

use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        return response()->json(City::all());
    }

    public function getCountries()
    {
        return response()->json(Country::all());
    }

    public function getStates($country_id)
    {
        $states = State::where('country_id', $country_id)->get();
        return response()->json($states);
    }

    public function getCities($state_id)
    {
        $cities = City::where('state_id', $state_id)->get();
        return response()->json($cities);
    }
}
