<?php

namespace App\Http\Requests\Recipe;

use App\Traits\FormRequestBooster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecipeShowRequest extends FormRequest
{
    use FormRequestBooster;

    public function authorize(): bool
    {
        return Auth::hasUser();
    }

    public function rules(): array
    {
        return [
            'with' => ['nullable', 'array'],
            'with.*' => ['string', Rule::in([
                'ingredients',
                'images',
            ])],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->injectWith();

        $this->merge([
            //
        ]);
    }
}
