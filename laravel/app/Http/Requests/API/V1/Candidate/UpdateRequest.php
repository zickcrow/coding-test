<?php

namespace App\Http\Requests\API\V1\Candidate;

use App\Models\Candidate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->scopes->find(5) !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'requiredIf:name,null|string|max:50',
            'education_institution_id' => 'nullable|exists:education_institutions,id',
            'birthday' => 'nullable|date',
            'experience' => 'nullable|numeric',
            'last_position_id' => 'nullable|exists:positions,id',
            'applied_position_id' => 'nullable|exists:positions,id',
            'skills' => 'nullable|array|exists:skills,name',
            'email' => 'nullable|email',
            'phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'resume' => 'nullable|file|mimes:pdf',
        ];
    }
}
