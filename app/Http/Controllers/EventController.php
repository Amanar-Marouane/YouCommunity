<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Exception;

class EventController
{

    public function showIndex()
    {
        $events = Event::all();
        return view("event.index", compact('events'));
    }

    public function showDetails(Request $request)
    {
        $id = $request->input("id");
        $event = Event::find($id);
        return view("event.show", compact('event'));
    }

    public function softDelete($id)
    {
        $message = 'Event has been deleted successfully';

        try {
            (new Event)->deleteSoft($id);
        } catch (Exception $e) {
            $message = 'Something Went Wrong';
        }

        return redirect('/profile')->with('message', $message);
    }
}
