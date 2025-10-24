<?php

namespace App\Http\Requests\Review;

use App\Traits\FormRequestBooster;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReviewStoreRequest extends FormRequest
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
            'user_id' => ['required', 'string'],
            'rating' => ['required', 'nullable', 'min:1', 'max:5'],
            'title' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->injectWith();

        $this->merge([
            'user_id' => $this->input('user_id', auth()->user()->id),
        ]);
    }
}
