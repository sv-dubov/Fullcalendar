<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $events = Event::whereDate('start_time', '>=', $request->start_time)
                ->whereDate('end_time',   '<=', $request->end_time)
                ->get(['id', 'name', 'start_time', 'end_time']);
            return response()->json($events);
        }
        return view('welcome');
    }

    public function ajax(Request $request)
    {
        switch ($request->type) {
            case 'create':
                $event = Event::create([
                    'name' => $request->name,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                ]);
                return response()->json($event);
                break;
            case 'delete':
                $event = Event::find($request->id)->delete();
                return response()->json($event);
                break;
            default:
                break;
        }
    }
}
