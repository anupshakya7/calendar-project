<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        return view('schedule.index');
    }

    public function fetchEvents()
    {
        $events = Schedule::where('status', true)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'title_ne' => $item->title_ne,
                'description' => $item->description,
                'description_ne' => $item->description_ne,
                'icon' => $item->icon,
                'mobile_visible' => $item->title_ne,
                'start' => $item->start_date,
                'end' => $item->end_date,
                'quantity' => $item->quantity
            ];
        });

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'title_ne' => 'required',
            'description' => 'nullable',
            'description_ne' => 'nullable',
            'quantity' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'icon' => 'nullable',
            'mobile_visible' => 'required|integer',
        ]);

        $event = Schedule::create($validatedData);

        return response()->json($event);
    }

    public function update(Request $request)
    {
        if ($request->title) {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'title_ne' => 'required',
                'description' => 'nullable',
                'description_ne' => 'nullable',
                'quantity' => 'required|integer',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'icon' => 'nullable',
                'mobile_visible' => 'required|integer',
            ]);
        }else{
             $validatedData = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ]);
        }

        $event = Schedule::find($request->id);
        $event->update($validatedData);

        return response()->json('Event Updated');
    }

    public function destroy(Request $request)
    {
        Schedule::destroy($request->id);
        return response()->json('Event Deleted');
    }
}
