<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Show;
use App\Models\Theater;
use App\Models\Slot;

class ShowController extends Controller
{
    public function index()
    {
        $shows = Show::with('theater', 'slots')->latest()->get();
        $theaters = Theater::latest()->get();
        return view('admin.shows.index', compact('shows','theaters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'theater_id' => 'required|exists:theaters,id',
            'name'       => 'required|string|max:255',
            'event_name' => 'nullable|string|max:255',
            'show_date'  => 'required|date',
        ]);

        Show::create($request->all());

        return redirect()->back()->with('success','Show added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'theater_id' => 'required|exists:theaters,id',
            'name'       => 'required|string|max:255',
            'event_name' => 'nullable|string|max:255',
            'show_date'  => 'required|date',
        ]);

        $show = Show::findOrFail($id);
        $show->update($request->all());

        return redirect()->back()->with('success','Show updated successfully!');
    }

    public function destroy($id)
    {
        $show = Show::findOrFail($id);
        $show->delete();
        return redirect()->back()->with('success','Show deleted successfully!');
    }
}
