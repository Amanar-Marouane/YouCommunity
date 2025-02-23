<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['is_deleted', "title", "description", "category_id", "begin_at", "location", "max_participants", "user_id"];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deleteSoft($id)
    {
        $event = Event::find($id);
        $event ? $event->is_deleted = 1 : throw new Exception('Event not found');
        $event->save();
    }

    public function current_participants_count()
    {
        return $this->hasMany(Rsvp::class);
    }

    public function is_reserved()
    {
        return $this->current_participants_count()->where('user_id', Auth::id());
    }
}
