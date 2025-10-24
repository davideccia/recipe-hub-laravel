<?php

namespace App\Http\Requests\MeasurementUnit;

class MeasurementUnitUpdateRequest extends MeasurementUnitStoreRequest
{
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
            //
        ]);
    }
}
