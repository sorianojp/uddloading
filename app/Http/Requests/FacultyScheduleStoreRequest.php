<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacultyScheduleStoreRequest extends FormRequest
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
            'subject_id' => ['required'],
            'room_id' => ['required'],
            'section_id' => ['required'],
            'time_start' => ['required', 'date_format:H:i'],
            'time_end' => ['required', 'date_format:H:i'],
            'monday' => ['sometimes', 'boolean'],
            'tuesday' => ['sometimes', 'boolean'],
            'wednesday' => ['sometimes', 'boolean'],
            'thursday' => ['sometimes', 'boolean'],
            'friday' => ['sometimes', 'boolean'],
            'saturday' => ['sometimes', 'boolean'],
            'sunday' => ['sometimes', 'boolean'],
            'override' => ['sometimes', 'boolean'],
        ];
    }
}
