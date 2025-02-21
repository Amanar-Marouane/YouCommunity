<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Event;
use Exception;
use Illuminate\Support\Facades\Auth;

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
        $message = 'Event has been deleted successfully';

        try {
            (new Event)->deleteSoft($id);
        } catch (Exception $e) {
            $message = 'Something Went Wrong';
        }

        return redirect('/profile')->with('message', $message);
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
}
