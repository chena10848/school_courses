<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourse extends FormRequest
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
            'courseId' => [
                'integer',
                'required'
            ],
            'courseName' => [
                'string'
            ],
            'description' => [
                'string'
            ],
            'startTime' => [
                'regex:/^(0[0-9]|1[0-9]|2[0-3])[0-5][0-9]$/'
            ],
            'endTime' => [
                'regex:/^(0[0-9]|1[0-9]|2[0-3])[0-5][0-9]$/'
            ],
            'instructorId' => [
                'integer'
            ]
        ];
    }
}
