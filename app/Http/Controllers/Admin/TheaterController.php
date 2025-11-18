<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theater;
use Illuminate\Http\Request;

class TheaterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $theaters = Theater::latest()->get();
        return view('admin.theaters.index', compact('theaters'));
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1'
        ]);

        Theater::create([
            'name'     => $request->name,
            'location' => $request->location,
            'capacity' => $request->capacity,
        ]);

        return redirect()->back()->with('success', 'Theater added successfully!');
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1'
        ]);

        $theater = Theater::findOrFail($id);

        $theater->update([
            'name'     => $request->name,
            'location' => $request->location,
            'capacity' => $request->capacity,
        ]);

        return redirect()->back()->with('success', 'Theater updated successfully!');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy($id)
    {
        $theater = Theater::findOrFail($id);
        $theater->delete();

        return redirect()->back()->with('success', 'Theater deleted successfully!');
    }
}
