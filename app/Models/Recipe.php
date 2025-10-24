<?php

namespace App\Models;

use App\Contracts\HasReviews;
use App\Models\Scopes\RecipeScope;
use App\Observers\RecipeObserver;
use App\Traits\EnhancedMedia;
use App\Traits\Reviewable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;

#[ScopedBy(RecipeScope::class)]
#[ObservedBy(RecipeObserver::class)]
/**
 * @mixin IdeHelperRecipe
 */
class Recipe extends Model implements HasMedia, HasReviews
{
    use EnhancedMedia, HasUuids, Reviewable;

    public const string IMAGES_COLLECTION_NAME = 'recipe_images';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'public',
        'difficulty',
        'rating',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::IMAGES_COLLECTION_NAME);
    }

    public function images(): MorphMany
    {
        return $this->media()->where('media.collection_name', self::IMAGES_COLLECTION_NAME);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)
            ->using(IngredientRecipe::class)
            ->withPivot(['measurement_unit_id', 'measurement_unit_name', 'quantity', 'notes'])
            ->orderBy('ingredients.name');
    }

    public function scopeOwnedByUser(Builder $builder, null|string|User $user = null): Builder
    {
        if ($user === null) {
            $userID = \Auth::user()->id;
        } else {
            $userID = $user instanceof User ? $user->id : $user;
        }

        return $builder->where('recipes.user_id', $userID);
    }

    public function scopePublic(Builder $builder): Builder
    {
        return $builder->where('recipes.public', true);
    }

    public function scopePrivate(Builder $builder): Builder
    {
        return $builder->where('recipes.public', false);
    }

    public function ingredientsBatchSave(array $ingredients, bool $detach = true): void
    {
        if ($detach) {
            $this->ingredients()->detach();
        }

        $ingredientsIDs = \Arr::pluck($ingredients, 'measurement_unit_id');
        $measurementUnits = MeasurementUnit::query()->whereIn('measurement_units.id', $ingredientsIDs)->get();

        foreach ($ingredients as $ingredientData) {
            if (
                ! filled(($ingredientData['ingredient_id'] ?? null))
                ||
                ! filled(($ingredientData['measurement_unit_id'] ?? null))
                ||
                ! filled(($ingredientData['quantity'] ?? null))
            ) {
                continue;
            }

            /** @var ?MeasurementUnit $measurementUnit */
            $measurementUnit = $measurementUnits->firstWhere('id', $ingredientData['measurement_unit_id']);

            if ($measurementUnit === null) {
                continue;
            }

            $this->ingredients()->attach($ingredientData['ingredient_id'], [
                'measurement_unit_id' => $measurementUnit->id,
                'measurement_unit_name' => "{$measurementUnit->name} ({$measurementUnit->label})",
                'quantity' => $ingredientData['quantity'],
                'notes' => $ingredientData['notes'] ?? null,
            ]);
        }
    }

    public function notifiableReviewUser(): User
    {
        return $this->user;
    }
}
