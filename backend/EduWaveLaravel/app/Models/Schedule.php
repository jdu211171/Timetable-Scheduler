<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;
use App\Models\User;
use App\Models\Group;
use App\Models\Room;

class Schedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subject_id',
        'user_id',
        'group_id',
        'room_id',
        'pair',
        'week_day',
        'date',
    ];

    /**
     * Get the subject associated with the schedule.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the teacher associated with the schedule.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the group associated with the schedule.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the room associated with the schedule.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
