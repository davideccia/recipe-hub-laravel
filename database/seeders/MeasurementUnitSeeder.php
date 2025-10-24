<?php

namespace Database\Seeders;

use App\Models\MeasurementUnit;
use Illuminate\Database\Seeder;

class MeasurementUnitSeeder extends Seeder
{
    public function run(): void
    {
        $data = self::fetchData();

        if (!filled($data)) {
            return;
        }

        foreach ($data as $measurementUnitLabel => $measurementUnitData) {

            $validator = \Validator::make([
                'name' => $measurementUnitData['name'] ?? null,
                'label' => $measurementUnitLabel,
            ], [
                'name' => ['required', 'string'],
                'label' => ['required', 'string'],
            ]);

            if ($validator->fails()) {
                continue;
            }

            $validated = $validator->validated();

            MeasurementUnit::firstOrCreate([
                'label' => $validated['label'],
            ], [
                'name' => $validated['name'],
            ]);
        }
    }

    public static function fetchData(): ?array
    {
        $response = \Http::get('https://raw.githubusercontent.com/GhostWrench/unitdb/refs/heads/trunk/db.json');

        if (!$response->ok()) {
            return null;
        }

        $data = $response->json(default: []);

        if (empty($data)) {
            return null;
        }

        return [
            ...($data['prefixes'] ?? []),
            ...($data['units'] ?? []),
        ];
    }
}
