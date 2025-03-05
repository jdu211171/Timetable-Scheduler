<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Group;
use App\Models\Subject;
use App\Models\Schedule;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'unique_id',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the groups that the user (student) belongs to.
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'GroupMembers');
    }

    /**
     * Get the subjects that the user (teacher) teaches.
     */
    public function subjectsTaught()
    {
        return $this->belongsToMany(Subject::class, 'SubjectTeachers', 'user_id', 'subject_id');
    }

    /**
     * Get the schedules taught by the user (teacher).
     */
    public function schedulesTaught()
    {
        return $this->hasMany(Schedule::class, 'user_id');
    }
}
