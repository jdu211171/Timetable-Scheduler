<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Teacher as TeacherModel;
use Illuminate\Notifications\Notifiable;

class Teacher extends TeacherModel
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'is_admin',
    ];
}
