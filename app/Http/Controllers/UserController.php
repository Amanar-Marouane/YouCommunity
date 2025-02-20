<?php

namespace App\Http\Controllers;

use App\Models\{Category, User};
use Illuminate\Support\Facades\Auth;

class UserController
{
    public function showIndex()
    {
        $user = Auth::user();
        $categories = Category::all();
        $events = Auth::user()->userEvents;
        return view("user.index", compact("user", "categories", "events"));
    }
}
