<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // $user = $this->user();
        // return $user != null && $user->tokenCan('update');
        
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $method = $this->method();

        if ($method === 'PUT') {
            return [
                'title' => ['required'],
                'category' => ['required', Rule::in(['Personal', 'Work', 'Other'])],
                'description' => ['required'],
                'completed' => ['sometimes', 'boolean'],
            ];
        } else {
            return [
                'title' => ['sometimes', 'required'],
                'category' => ['sometimes', 'required', Rule::in(['Personal', 'Work', 'Other'])],
                'description' => ['sometimes', 'required'],
                'completed' => ['sometimes', 'required', 'boolean'],
            ];
        }
    }
}
