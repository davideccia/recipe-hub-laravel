<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait FormRequestBooster
{
    public function injectWith(): void
    {
        $with = collect(explode(',', $this->input('with', '')))
            ->map(fn($key) => Str::of($key)->trim()->camel()->toString())
            ->filter()
            ->toArray();

        $this->merge([
            'with' => $with,
        ]);
    }
}
