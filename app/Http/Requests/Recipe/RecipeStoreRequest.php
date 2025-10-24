<?php

namespace App\Http\Requests\Recipe;

use App\Traits\FormRequestBooster;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RecipeStoreRequest extends FormRequest
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
                //
            ])],
            'user_id' => ['required', 'string', Rule::exists('users', 'id')],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'public' => ['nullable', 'boolean'],
            'difficulty' => ['required', 'integer', 'min:1', 'max:10'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*' => ['array'],
            'ingredients.*.ingredient_id' => ['string', Rule::exists('ingredients', 'id')],
            'ingredients.*.measurement_unit_id' => ['string', Rule::exists('measurement_units', 'id')],
            'ingredients.*.quantity' => ['numeric:', 'min:1'],
            'ingredients.*.notes' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->injectWith();

        $this->merge([
            'user_id' => auth()->user()->id,
        ]);
    }
}
