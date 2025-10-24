<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\MeasurementUnit;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $ingredients = Ingredient::all();
        $measurementUnits = MeasurementUnit::all();

        for ($i = 1; $i <= 10; $i++) {

            /** @var User $randomUser */
            $randomUser = $users->random();

            $recipe = Recipe::create([
                'user_id' => $randomUser->id,
                'public' => fake()->boolean(),
                'title' => "Recipe {$i}",
                'description' => fake()->text(),
                'difficulty' => fake()->numberBetween(1, 5),
            ]);

            for ($j = 0; $j <= 10; $j++) {
                $randomIngredient = $ingredients->random();
                $randomMeasurementUnit = $measurementUnits->random();

                $recipe
                    ->ingredients()
                    ->syncWithPivotValues([$randomIngredient->id], [
                        'measurement_unit_id' => $randomMeasurementUnit->id,
                        'measurement_unit_name' => $randomMeasurementUnit->name,
                        'quantity' => fake()->randomFloat(min: 1, max: 9999),
                        'notes' => fake()->boolean() ? fake()->text() : null,
                    ], false);
            }
        }
    }
}
