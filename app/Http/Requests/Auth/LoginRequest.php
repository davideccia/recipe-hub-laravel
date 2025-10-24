<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User $user */
        $user = User::query()->firstWhere('users.email', $this->input('email'));

        if($user === null){
            return false;
        }

        $this->request->set('user', $user);

        return Hash::check($this->input('password'), $user->password);
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string'],
        ];
    }
}
