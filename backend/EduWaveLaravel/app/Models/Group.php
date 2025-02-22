<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Subject;

class Group extends Model
{

    public function users()
    {
        return $this->belongsToMany(User::class, 'GroupMembers');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'GroupSubjects');
    }

    /** @use HasFactory<\Database\Factories\GroupFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
