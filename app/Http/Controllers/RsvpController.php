<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rsvp;

class RsvpController extends Controller
{
    public function reserve(Request $request)
    {
        $user_id = Auth::id();
        $event_id = $request->id;
        Rsvp::create([
            "user_id" => $user_id,
            "event_id" => $event_id,
        ]);
        return redirect()->back()->with("success", "You've reserved your place");
    }

    public function cancel(Request $request)
    {
        $user_id = Auth::id();
        $event_id = $request->id;
        Rsvp::where('user_id', $user_id)
            ->where('event_id', $event_id)
            ->delete();

        return redirect()->back()->with("success", "You've canceled your RSVP.");
    }
}
