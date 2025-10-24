<?php

namespace App\Http\Requests\MeasurementUnit;

use App\Models\MeasurementUnit;
use App\Traits\FormRequestBooster;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MeasurementUnitStoreRequest extends FormRequest
{
    use FormRequestBooster;

    public function authorize(): bool
    {
        return auth()->user()->can('create', MeasurementUnit::class);
    }

    public function rules(): array
    {
        return [
            'with' => ['nullable', 'array'],
            'with.*' => ['string', Rule::in([
                //
            ])],
            'name' => ['required', 'string'],
            'label' => ['required', 'string'],
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
