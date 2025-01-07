<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Student as StudentModel;
use Illuminate\Notifications\Notifiable;


class Student extends StudentModel
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'unique_id',
    ];
}
