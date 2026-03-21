<?php

namespace App\Http\Requests\Strategy;

use Illuminate\Foundation\Http\FormRequest;

class StrategyStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'description' => ['required', 'string'],
            'parameters' => ['required', 'array'],
        ];
    }
}
