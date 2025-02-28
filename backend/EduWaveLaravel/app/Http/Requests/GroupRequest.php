<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255|unique:groups,name',
        ];

        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $groupId = $this->route('group')->id;
            $rules['name'] = 'required|string|max:255|unique:groups,name,' . $groupId;
        }

        return $rules;
    }

}
