<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EventRegistration;
use App\Models\EventLineup;
use App\Models\Ticket;
use App\Models\BookingHistory;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Validator;


class TicketController extends Controller
{
   public function getTicketDetails(Request $request,$id) {
        if (EventRegistration::where('id', $id) -> exists()) {
            $eventRegistration = EventRegistration::find($id);
            $ticket = $eventRegistration -> ticket;
            return response($eventRegistration -> toJson(JSON_PRETTY_PRINT), 200);
        } else {
            return response() -> json([
                "message" => "Event not found"
            ], 404);
        }
    }

    public function ticketBooking(Request $request) {
         $ticketHistory = [];
         if ($request->tickets) {
             foreach ($request->tickets as $key=> $value) {
                 $ff=json_encode($value);
                 if (array_key_exists('booked',$value)) {
                    array_push($ticketHistory, (object)[ 
                        'ticket_type'=> json_decode($ff)->ticket_type,
                        'booked'=> json_decode($ff)->booked,
                     ]);
                 }
                
             }
         }
    
        if ($request->tickets[0]["evt_id"]) {
            $bookingHistory = new BookingHistory();
            $bookingHistory->evt_id = $request->tickets[0]["evt_id"];
            $bookingHistory->customer_name = $request->customer_name;
            $bookingHistory->customer_email = $request->customer_email;
            $bookingHistory->phone_number = $request->phone_number;
            $bookingHistory->ticket_history = json_encode($ticketHistory);
            $bookingHistory->save();  
        }

        foreach ($request->tickets as $key => $value) {
            if (array_key_exists("id",$value)) {
                $tickets = Ticket::find($value["id"]);
                $tickets->fill($value)->save();
            } 
        }
       
        return response()->json([
            'message' => 'Booked Ticket successfully',
        ], 201);
        
    }

    public function getAllBookedTicket(Request $request) {
        $bookingHistory = BookingHistory::get()->toJson(JSON_PRETTY_PRINT);
        return response($bookingHistory, 200);
    }
    public function getAllTickets(Request $request) {
        $bookingHistory = Ticket::get()->toJson(JSON_PRETTY_PRINT);
        return response($bookingHistory, 200);
    }
    public function getTicketStaticsById(Request $request) {
        $bookingHistory = DB::table('tickets')
                 ->select('evt_id','available_ticket','ticket_type', DB::raw('MAX(available_ticket) as available_ticket'),DB::raw('MIN(capacity) as capacity'))
                 ->groupBy('evt_id','ticket_type')
                 ->get();
            return response($bookingHistory -> toJson(JSON_PRETTY_PRINT), 200);
    }
}
