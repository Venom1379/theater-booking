<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class SlotController extends Controller
{
    public function index()
    {
        $slots = Slot::orderBy('id')->get();
        return view('admin.slots.index', compact('slots'));
    }

    /**
     * Handle bulk create + update + delete in one form submit.
     * Expect arrays:
     *  - id[] (blank for new rows)
     *  - slot_name[]
     *  - start_time[]
     *  - end_time[]
     *  - price[]
     *  - status[] (optional)
     *  - deleted_ids[] (optional) -> IDs to delete
     */
    public function saveAll(Request $request)
    {
        // Basic validation — arrays must line up.
        $request->validate([
            'slot_name' => 'required|array',
            'start_time' => 'required|array',
            'end_time' => 'required|array',
            'price' => 'required|array',
            // each element validation (can be stricter as needed)
            'slot_name.*' => 'required|string|max:255',
            'start_time.*' => 'required|date_format:H:i',
            'end_time.*' => 'required|date_format:H:i',
            'price.*' => 'required|numeric|min:0',
        ]);

        // Wrap in transaction
        DB::transaction(function () use ($request) {
            // 1) Delete rows requested
            $deleted = $request->input('deleted_ids', []);
            if (!empty($deleted)) {
                Slot::whereIn('id', $deleted)->delete();
            }

            // 2) Iterate rows and create/update accordingly
            $ids = $request->input('id', []); // may contain empty strings for new rows
            $names = $request->input('slot_name', []);
            $starts = $request->input('start_time', []);
            $ends = $request->input('end_time', []);
            $prices = $request->input('price', []);
            $statuses = $request->input('status', []); // optional

            $count = count($names);
            for ($i = 0; $i < $count; $i++) {
                $rowId = isset($ids[$i]) && $ids[$i] !== '' ? intval($ids[$i]) : null;
                $data = [
                    'slot_name' => $names[$i],
                    'start_time' => $starts[$i],
                    'end_time' => $ends[$i],
                    'price' => $prices[$i],
                    'status' => $statuses[$i] ?? 'active',
                ];

                if ($rowId) {
                    // update if exists
                    $slot = Slot::find($rowId);
                    if ($slot) {
                        $slot->update($data);
                    } else {
                        // if id not found, create new (defensive)
                        Slot::create($data);
                    }
                } else {
                    // new row
                    Slot::create($data);
                }
            }
        });

        return redirect()->route('admin.slots.index')->with('success', 'Slots saved successfully.');
    }

    // optional single delete:
    public function destroy($id)
    {
        Slot::findOrFail($id)->delete();
        return back()->with('success', 'Slot deleted.');
    }
}
