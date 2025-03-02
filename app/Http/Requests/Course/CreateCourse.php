<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class CreateCourse extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'courseName' => [
                'string',
                'required'
            ],
            'description' => [
                'string',
                'required'
            ],
            'startTime' => [
                'required',
                'regex:/^(0[0-9]|1[0-9]|2[0-3])[0-5][0-9]$/'
            ],
            'endTime' => [
                'required',
                'regex:/^(0[0-9]|1[0-9]|2[0-3])[0-5][0-9]$/'
            ],
            'instructorId' => [
                'integer',
                'required'
            ]
        ];
    }
}
