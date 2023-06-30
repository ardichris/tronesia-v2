<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\EventTicketCollection;
use App\EventTicket;
use App\EventTransaction;

class EventTicketController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $event = EventTicket::with(['creator','updater'])->orderBy('created_at','DESC');
        return new EventTicketCollection($event->paginate(10));
    }

    public function attend(Request $request, $kode){
        $ticket = EventTicket::where('et_code', $kode)->first();
        if($ticket) {
            $status = EventTransaction::where('ticket_id',$ticket->id)->where('ticket_status','Attended')->first();
            if($status) {
                return response()->json(['data'=> ['status' => $status->ticket_status,'ticket'=>$ticket]],200);
            } else {
                $addAttend = EventTransaction::create(['ticket_id' => $ticket->id,
                                                        'ticket_status' => 'Attended',
                                                        'creator_id' => 2,
                                                        'updater_id' => 2]);
                return response()->json(['data'=> ['status' => 'Success','ticket'=>$ticket]],200);
            }
        } else {
            return response()->json(['data'=> ['status' => 'Not Found','ticket' => null]],200);
        }
    }
}
