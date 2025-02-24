<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Subject;
use App\Models\Schedule;

class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the users (students) that belong to the group.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'GroupMembers');
    }

    /**
     * Get the subjects associated with the group.
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'GroupSubjects');
    }

    /**
     * Get the schedules associated with the group.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
