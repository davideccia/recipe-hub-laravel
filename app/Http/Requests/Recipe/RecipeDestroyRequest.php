<?php

namespace App\Http\Requests\Recipe;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RecipeDestroyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::hasUser();
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
