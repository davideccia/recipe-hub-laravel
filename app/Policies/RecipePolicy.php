<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RecipePolicy
{
    public function before(User $user): bool
    {
        return true;
    }

    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Recipe $recipe): bool
    {
        //
    }

    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, Recipe $recipe): bool
    {
        //
    }

    public function delete(User $user, Recipe $recipe): bool
    {
        //
    }
}
