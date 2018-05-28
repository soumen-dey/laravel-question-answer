<?php

namespace App\Http\Requests\Topic;

use Illuminate\Foundation\Http\FormRequest;

class StoreTopicQuestionRequest extends FormRequest
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
            'topic' => 'required|integer|exists:topics,id',
            'title' => 'required|string|max:190',
            'body' => 'required|nullable|string',
            'reference' => 'nullable|string|max:190',
            'anonymous' => 'nullable',
        ];
    }
}
