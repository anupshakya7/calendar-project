<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(){
        return view('schedule.index');
    }

    public function fetchEvents(){
        $events = Schedule::get(['id','title','start','end']);
        return response()->json($events);
    }

    public function store(Request $request){
        $event = Schedule::create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end
        ]);

        return response()->json($event);
    }

    public function update(Request $request){
        $event = Schedule::find($request->id);
        $event->update([
            'start' => $request->start,
            'end' => $request->end,
        ]);

        return response()->json('Event Updated');
    }

    public function destroy(Request $request){
        Schedule::destroy($request->id);
        return response()->json('Event Deleted');
    }
}
