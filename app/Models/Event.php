<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['is_deleted'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function deleteSoft($id)
    {
        $event = Event::find($id);
        $event ? $event->is_deleted = 1 : throw new Exception('Event not found');
        $event->save();
    }
}
