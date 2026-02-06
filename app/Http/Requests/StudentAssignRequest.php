<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentAssignRequest extends FormRequest
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
             'student_id'      => 'required|string|max:50',
            'section_id'      => 'required|exists:sections,id',
            'admission_year'  => 'required|integer|min:2000|max:' . date('Y'),
            'roll_number'     => 'required|integer|min:1',
        ];
    }
}
