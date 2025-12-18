<?php

namespace App\Http\Requests\Recipe;

use App\Traits\FormRequestBooster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecipeIndexRequest extends FormRequest
{
    use FormRequestBooster;

    public function authorize(): bool
    {
        return Auth::hasUser();
    }

    public function rules(): array
    {
        return [
            'paginate' => ['nullable', 'boolean'],
            'per_page' => ['nullable', 'integer'],
            'page' => ['nullable', 'integer'],
            'search' => ['nullable', 'string'],
            'with' => ['nullable', 'array'],
            'with.*' => ['string', Rule::in([
                //
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
