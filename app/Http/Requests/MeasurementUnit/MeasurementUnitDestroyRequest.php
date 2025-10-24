<?php

namespace App\Http\Requests\MeasurementUnit;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MeasurementUnitDestroyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()?->manageApplication() ?? false;
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
