<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @mixin IdeHelperIngredientRecipe
 */
class IngredientRecipe extends Pivot
{
    protected $fillable = [
        'ingredient_id',
        'recipe_id',
        'measurement_unit_id',
        'measurement_unit_name',
        'quantity',
        'notes',
    ];
}
