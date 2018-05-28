<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|string|max:190',
            'bio' => 'nullable',
            'qualification' => 'nullable|string|max:190',
            'working' => 'nullable|string|max:190',
            'college' => 'nullable|string|max:190',
            'designation' => 'nullable|string|max:190',
            'dob' => 'nullable|string|max:190',
            'city' => 'nullable|integer|exists:cities,id',
        ];
    }
}
