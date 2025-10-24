<?php

namespace App\Http\Requests\Review;

class ReviewUpdateRequest extends ReviewStoreRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('update', $this->review);
    }

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
            'user_id' => $this->review?->user_id ?? $this->input('user_id', auth()->user()->id),
        ]);
    }
}
