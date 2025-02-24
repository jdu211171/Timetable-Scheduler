<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
use App\Models\User;
use App\Models\Schedule;

class Subject extends Model
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
     * Get the groups associated with the subject.
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'GroupSubjects');
    }

    /**
     * Get the teachers that teach the subject.
     */
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'SubjectTeachers', 'subject_id', 'teacher_id');
    }

    /**
     * Get the schedules associated with the subject.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
