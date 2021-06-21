<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $events = Event::where('start_time', '>=', $request->start)
                ->where('end_time', '<=', $request->end)
                ->get();
            return response()->json(EventResource::collection($events));
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
                return response()->json(EventResource::collection($event));
            case 'delete':
                Event::find($request->id)->delete();
                return [];
            default:
                break;
        }
    }
}
