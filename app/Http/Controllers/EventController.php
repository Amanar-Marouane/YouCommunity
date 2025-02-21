<?php

namespace App\Http\Controllers;

use App\Models\{Comment, Event, Category, Rsvp};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Mail};
use App\Mail\MyMail;

class EventController
{

    public function showIndex()
    {
        $events = Event::all();
        return view("event.index", compact('events'));
    }

    public function showDetails($id)
    {
        $event = Event::find($id);
        $comments = Comment::where('event_id', $id)->get();
        return view("event.show", compact('event', "comments"));
    }

    public function softDelete($id)
    {
        $emails = Rsvp::where("event_id", $id)
            ->with("user")
            ->get()
            ->map(function ($rsvp) {
                return [
                    "name" => $rsvp->user?->name,
                    "email" => $rsvp->user?->email
                ];
            })->filter();

        $eventName = Event::find($id)->title;

        foreach ($emails as $email) {
            $data = [
                "name" => $email['name'],
                "event_name" => $eventName,
                "message" => "Event Has Been Canceled",
            ];
            Mail::to($email['email'])->queue(new MyMail($data));
        }

        Rsvp::where("event_id", $id)->delete();
        (new Event)->deleteSoft($id);

        return redirect('/profile')->with('success', "Event has been canceled successfully");
    }


    public function insert(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'category_id' => 'required|exists:categories,id',
                'begin_at' => 'required|date|after:today',
                'location' => 'required|string|max:255',
                'max_participants' => 'required|integer|min:10|max:1000',
            ]);
            $validatedData['user_id'] = Auth::id();

            Event::create($validatedData);

            return redirect()->back()->with('success', 'Event created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create event. Please try again.');
        }
    }

    public function edit($id)
    {
        $user_id = Auth::id();
        $allowed_events_id = Event::where('user_id', $user_id)->pluck('id')->toArray();
        if (!in_array($id, $allowed_events_id)) return redirect()->back()->with("error", "Access Denied");

        $event = Event::find($id);
        $categories = Category::all();
        return view("event.edit", compact("event", "categories"));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category_id' => 'required|exists:categories,id',
            'begin_at' => 'required|date|after:today',
            'location' => 'required|string|max:255',
            'max_participants' => 'required|integer|min:10|max:1000',
        ]);

        $event = Event::find($request->input("id"));

        if (!$event) {
            return redirect(route("profile"))->with("error", "Access Denied Or Target Not Found");
        }

        $event->update($validatedData);
        return redirect(route("profile"))->with("success", "Event updated successfully");
    }
}
