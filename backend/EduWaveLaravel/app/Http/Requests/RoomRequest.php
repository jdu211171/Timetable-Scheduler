<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255|unique:rooms,name',
        ];

        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $roomId = $this->route('room')->id;
            $rules['name'] = 'required|string|max:255|unique:rooms,name,' . $roomId;
        }

        return $rules;
    }

}
