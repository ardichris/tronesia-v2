<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\EventCollection;
use App\Event;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $event = Event::where('unit_id',$user->unit_id)->with(['creator','updater'])->orderBy('created_at','DESC');
        return new EventCollection($event->paginate(10));
    }
}
