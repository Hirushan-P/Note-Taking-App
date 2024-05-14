<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // $user = $this->user();
        // return $user != null && $user->tokenCan('create');

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(['Personal', 'Work', 'Other'])],
            'description' => ['required', 'string', 'max:500'],
            'completed' => ['sometimes', 'boolean'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'completed' => false, // Default value for 'completed'
        ]);
    }
}
