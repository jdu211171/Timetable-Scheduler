<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subject_id' => 'required|exists:subjects,id',
            'user_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $user = User::find($value);
                    if ($user && $user->role !== 'teacher') {
                        $fail('The selected user must be a teacher.');
                    }
                },
            ],
            'group_id' => 'required|exists:groups,id',
            'room_id' => 'required|exists:rooms,id',
            'pair' => 'required|integer|between:1,9',
            'week_day' => 'required_if:repeat_weekly,true|in:Mon,Tue,Wed,Thu,Fri,Sat,Sun',
            'date' => 'required|date',
        ];
    }

}
