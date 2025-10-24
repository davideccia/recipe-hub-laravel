<?php

namespace App\Http\Requests\Review;

use App\Traits\FormRequestBooster;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReviewShowRequest extends FormRequest
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
                'user',
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
