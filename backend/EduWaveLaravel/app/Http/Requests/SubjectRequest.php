<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255|unique:subjects,name',
        ];

        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $subjectId = $this->route('subject')->id;
            $rules['name'] = 'required|string|max:255|unique:subjects,name,' . $subjectId;
        }

        return $rules;
    }

}
