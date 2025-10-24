<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;

class UserUpdateRequest extends UserStoreRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('update', $this->user);
    }

    public function rules(): array
    {
        return [
            ...parent::rules(),
            'with' => ['nullable', 'array'],
            'with.*' => ['string', Rule::in([
                //
            ])],
            'email' => ['required', 'string', Rule::unique('users', 'email')->ignore($this->user?->id)],
            'password' => ['exclude'],
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
