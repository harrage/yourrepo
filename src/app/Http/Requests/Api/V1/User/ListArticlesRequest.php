<?php

namespace App\Http\Requests\Api\V1\User;

use App\Traits\Http\Requests\HasFilters;
use Illuminate\Foundation\Http\FormRequest;

class ListArticlesRequest extends FormRequest
{
    use HasFilters;

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
            'category' => ['exists:categories,id'],
            'source' => ['exists:sources,id'],
            'date_from' => ['date'],
            'date_to' => ['date'],
            'keywords' => ['string'],
        ];
    }
}
