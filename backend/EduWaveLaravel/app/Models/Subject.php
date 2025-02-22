<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
use App\Models\User;

class Subject extends Model
{

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'SubjectTeachers', 'subject_id', 'teacher_id');
    }

    /** @use HasFactory<\Database\Factories\SubjectFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
