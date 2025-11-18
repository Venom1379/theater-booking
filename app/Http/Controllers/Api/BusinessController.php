<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\City;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator; // ✅ Import Validator correctly




use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index()
    {
        return response()->json(Business::with(['category', 'city'])->get());
    }

    public function show($id)
    {
        $business = Business::with(['category', 'city', 'images', 'tags'])->findOrFail($id);
        return response()->json($business);
    }

    public function getByCategory($category_id)
    {
        $businesses = Business::where('category_id', $category_id)->with(['category', 'city'])->get();
        return response()->json($businesses);
    }

    public function getByCity($city_id)
    {
        $businesses = Business::where('city_id', $city_id)->with(['category', 'city'])->get();
        return response()->json($businesses);
    }
    public function getCityBySlug($slug)
    {
        $city = City::where('slug', $slug)->first();

        if (!$city) {
            return response()->json(['error' => 'City not found'], 404);
        }

        return response()->json($city);
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'category_id' => 'required|exists:categories,id',
    //         'city_id' => 'required|exists:cities,id',
    //         'address' => 'required|string',
    //         'phone' => 'nullable|string',
    //         'email' => 'nullable|email',
    //         'website' => 'nullable|url',
    //     ]);

    //     $business = Business::create([
    //         'name' => $request->name,
    //         'slug' => Str::slug($request->name),
    //         'description' => $request->description,
    //         'category_id' => $request->category_id,
    //         'city_id' => $request->city_id,
    //         'address' => $request->address,
    //         'phone' => $request->phone,
    //         'email' => $request->email,
    //         'website' => $request->website,
    //         'status' => 'pending',
    //     ]);

    //     return response()->json(['message' => 'Business added successfully', 'business' => $business], 201);
    // }
    public function store(Request $request)
    {
        // die('hello');
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'phone_2' => 'nullable|string|max:20',
            'email' => 'required|email',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Generate slug from name
        $slug = Str::slug($request->name, '-');

        // Handle file upload
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('business_logos', 'public');
        }

        // Create business entry
        $business = Business::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'phone' => $request->phone,
            'phone_2' => $request->phone_2,
            'email' => $request->email,
            'website' => $request->website,
            'logo' => $logoPath,
        ]);

        return response()->json(['message' => 'Business added successfully!', 'business' => $business], 201);
    }
    public function getUserBusinesses($user_id)
    {
        $businesses = Business::where('user_id', $user_id)->get();
        return response()->json($businesses);
    }
}
