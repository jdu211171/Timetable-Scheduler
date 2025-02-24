<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|in:student,teacher,admin',
            'unique_id' => 'nullable|required_if:role,student|unique:users,unique_id',
        ];

        if ($this->method() === 'POST') {
            $rules['email'] .= '|unique:users,email';
            $rules['password'] = 'required|string|min:8|confirmed';
        } elseif ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $userId = $this->route('user');
            $rules['email'] .= '|unique:users,email,' . $userId;
            $rules['password'] = 'sometimes|string|min:8|confirmed';
            $rules['unique_id'] .= ',' . $userId;
        }

        return $rules;
    }

}
