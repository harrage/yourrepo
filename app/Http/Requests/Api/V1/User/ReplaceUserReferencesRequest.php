<?php

namespace App\Http\Requests\Api\V1\User;

use Illuminate\Foundation\Http\FormRequest;

class ReplaceUserReferencesRequest extends FormRequest
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
            'categories' => ['array'],
            'categories.*' => ['integer', 'exists:categories,id'],
            'sources' => ['array'],
            'sources.*' => ['integer', 'exists:sources,id'],
            'authors' => ['array'],
            'authors.*' => ['integer', 'exists:authors,id'],
        ];
    }
}
