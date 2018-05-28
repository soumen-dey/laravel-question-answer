<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question' => 'required|integer|exists:questions,id',
            'title' => 'required|string|max:190',
            'body' => 'required|nullable|string',
            'reference' => 'nullable|string|max:190',
            'anonymous' => 'nullable',
        ];
    }
}
