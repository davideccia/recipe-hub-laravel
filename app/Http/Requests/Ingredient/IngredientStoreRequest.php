<?php

namespace App\Http\Requests\Ingredient;

use App\Traits\FormRequestBooster;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class IngredientStoreRequest extends FormRequest
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
            'user_id' => ['nullable', Rule::exists('users', 'id')],
            'name' => ['required', 'string'],
            'allergens' => ['nullable', 'array'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->injectWith();

        $this->merge([
            'user_id' => Auth::user()?->id,
        ]);
    }
}
