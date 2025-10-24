<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserDestroyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('delete', $this->user);
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
