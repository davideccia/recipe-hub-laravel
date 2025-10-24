<?php

namespace App\Http\Requests\User;

use App\Enums\UserRoleEnum;
use App\Models\User;
use App\Traits\FormRequestBooster;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
{
    use FormRequestBooster;

    public function authorize(): bool
    {
        return auth()->user()->can('create', User::class);
    }

    public function rules(): array
    {
        return [
            'with' => ['nullable', 'array'],
            'with.*' => ['string', Rule::in([
                'user',
            ])],
            'last_name' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'role' => ['required', Rule::enum(UserRoleEnum::class)],
            'email' => ['required', 'string', Rule::unique('users', 'email')],
            'password' => ['required', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'password' => \Str::uuid()->toString(),
        ]);
    }
}
