<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function insert(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:1000',
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
        ]);

        Comment::create($validatedData);

        return redirect()->route('event.show', ['id' => $validatedData['event_id']])->with('success', 'Comment added!');
    }
}
