<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EventRegistration;
use App\Models\EventLineup;
use App\Models\Ticket;
use Carbon\Carbon;
use Validator;

class EventRegistrationController extends Controller
{
   public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'evt_name' => 'required|string|between:2,100',
            'evt_desc' => 'required|string|between:2,100',
            'location' => 'required|string|between:2,100',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $event_reg = EventRegistration::create($validator->validated());
        if ($request->event_lineup) {
            foreach($request->event_lineup as $key){
            //  print_r(Carbon::parse($key['date_and_time']));
            $eventLineup = new EventLineup();
            $eventLineup->evt_id = $event_reg -> id;
            $eventLineup->lineup_desc = $key['lineup_desc'];
            $eventLineup->date_and_time = Carbon::parse($key['date_and_time']);
            $eventLineup->save(); 
         }
        }
        if ($request->tickets) {
            foreach($request->tickets as $key){
            //  print_r(Carbon::parse($key['date_and_time']));
            $ticket = new Ticket();
            $ticket->evt_id = $event_reg -> id;
            $ticket->ticket_type = $key['ticket_type'];
            $ticket->capacity = $key['capacity'];
            $ticket->price = $key['price'];
            $ticket->available_ticket = $key['capacity'];
            $ticket->save(); 
         }
        }
        return response()->json([
            'message' => 'Event successfully registered',
            'user' => $event_reg -> id
        ], 201);
    }

    public function getAllEvent(Request $request) {
        $eventRegistration = EventRegistration::get()->toJson(JSON_PRETTY_PRINT);
        return response($eventRegistration, 200);
    }

    public function getEventByIdWithLineUps(Request $request,$id) {
        if (EventRegistration::where('id', $id) -> exists()) {
            $eventRegistration = EventRegistration::find($id);
            $eventLineup = $eventRegistration -> eventLineup;
            $ticket = $eventRegistration -> ticket;
            return response($eventRegistration -> toJson(JSON_PRETTY_PRINT), 200);
        } else {
            return response() -> json([
                "message" => "Event not found"
            ], 404);
        }
    }
    public function getEventById(Request $request,$id) {
        if (EventRegistration::where('id', $id)->exists()) {
        $eventRegistration = EventRegistration::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($eventRegistration, 200);
      } else {
        return response()->json([
          "message" => "Event not found"
        ], 404);
      }
    }
    public function getLineUpByEventId(Request $request, $id) {
        if (EventRegistration::where('id', $id) -> exists()) {
            $eventRegistration = EventRegistration::find($id);
            $eventLineup = $eventRegistration -> eventLineup;
            return response($eventLineup -> toJson(JSON_PRETTY_PRINT), 200);
        } else {
            return response() -> json([
                "message" => "Line up not found"
            ], 200);
        }
    }
    public function deleteEvent(Request $request, $id) {
        if (EventRegistration::where('id', $id) -> exists()) {
            EventRegistration::where('id', $id)->delete();
            return response() -> json([
                "message" => "Event deleted"
            ], 200);
        } else {
            return response() -> json([
                "message" => "Line up not found"
            ], 404);
        }
    }
    public function updateEvent(Request $request, $id) {
        $eventRegistration = EventRegistration::find($id);
        $input = $request->all();
        $eventRegistration->fill($input)->save();
        foreach ($request->event_lineup as $key => $value) {
            $eventLineup = EventLineup::find($value["id"]);
            $eventLineup->fill($value)->save();  
        }
        foreach ($request->tickets as $key => $value) {
        
           
            if (array_key_exists("id",$value)) {
                $tickets = Ticket::find($value["id"]);
                $tickets->fill($value)->save();
            }else{
            
                $ticket = new Ticket();
                $ticket->evt_id = $id;
                $ticket->ticket_type = $value['ticket_type'];
                $ticket->capacity = $value['capacity'];
                $ticket->price = $value['price'];
                $ticket->available_ticket = $value['capacity'];
                $ticket->save();
            }
             
        }
        return response() -> json([
                "message" => "Record Successfully Updated!"
            ], 200);
    }

}
