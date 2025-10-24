<?php

namespace App\Http\Requests\Ingredient;

use Illuminate\Support\Facades\Auth;

class IngredientUpdateRequest extends IngredientStoreRequest
{
    public function rules(): array
    {
        return [
            ...parent::rules(),
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
