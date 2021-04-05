<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\EventRegistration;

use Validator;

class EventRegistrationController extends Controller
{
   public function register(Request $request) {
       
        $validator = Validator::make($request->all(), [
            'evt_name' => 'required|string|between:2,100',
            'evt_desc' => 'required|string|between:2,100',
            'city' => 'required|string|between:2,100',
            'state' => 'required|string|between:2,100',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $event_reg = EventRegistration::create(array_merge($validator->validated(),['golden_ticket' => json_encode($request->golden_ticket),
        'platinum_ticket' => json_encode($request->platinum_ticket) ,'silver_ticket' => json_encode($request->silver_ticket)
        ]));

        //  $eventRegistration = new EventRegistration();
        // $eventRegistration->golden_ticket = json_encode($request->golden_ticket);
        // $eventRegistration->save();
        
        return response()->json([
            'message' => 'Event successfully registered',
            'user' => $event_reg -> id
        ], 201);
    }

    public function getAllEvent(Request $request) {

        $eventRegistration = EventRegistration::get()->toJson(JSON_PRETTY_PRINT);
        return response($eventRegistration, 200);

    }

    public function getEventById(Request $request,$id) {

        if (EventRegistration::where('evt_id', $id)->exists()) {
        $eventRegistration = EventRegistration::where('evt_id', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($eventRegistration, 200);
      } else {
        return response()->json([
          "message" => "Event not found"
        ], 404);
      }

    }

}
