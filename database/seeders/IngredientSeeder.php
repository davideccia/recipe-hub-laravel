<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\User;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        for ($i = 1; $i <= 1000; $i++) {

            /** @var ?User $randomUser */
            $randomUser = fake()->boolean() ? $users->random() : null;

            $allergens = fake()->boolean() ? ['gluten'] : null;

            Ingredient::create([
                'user_id' => $randomUser?->id,
                'name' => "Ingredient {$i}",
                'allergens' => $allergens,
            ]);
        }
    }
}
