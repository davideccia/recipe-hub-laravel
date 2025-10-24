<?php

namespace App\Policies;

use App\Models\Ingredient;
use App\Models\User;

class IngredientPolicy
{
    public function before(User $user): bool
    {
        return true;
    }

    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Ingredient $ingredient): bool
    {
        //
    }

    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, Ingredient $ingredient): bool
    {
        //
    }

    public function delete(User $user, Ingredient $ingredient): bool
    {
        //
    }
}
