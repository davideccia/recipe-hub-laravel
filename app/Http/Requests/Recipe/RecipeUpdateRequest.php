<?php

namespace App\Http\Requests\Recipe;

use Illuminate\Support\Facades\Auth;

class RecipeUpdateRequest extends RecipeStoreRequest
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
            'user_id' => Auth::user()->id,
        ]);
    }
}
