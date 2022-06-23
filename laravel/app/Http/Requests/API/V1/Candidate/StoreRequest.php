<?php

namespace App\Http\Requests\API\V1\Candidate;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'string|required|max:100',
            'education_institution_id' => 'nullable|exists:education_institutions,id',
            'birthday' => 'nullable|date',
            'experience' => 'nullable|numeric',
            'last_position_id' => 'nullable|exists:positions,id',
            'applied_position_id' => 'nullable|exists:positions,id',
            'email' => 'nullable|email',
            'phone' => 'nullable|alpha_num|max:20',
            'resume' => 'nullable|file|mimes:pdf,doc,docx,odt,rtf,txt,html,htm',
        ];
    }
}
