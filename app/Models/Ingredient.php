<?php

namespace App\Models;

use App\Models\Scopes\IngredientScope;
use App\Observers\IngredientObserver;
use App\Traits\EnhancedMedia;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;

#[ScopedBy(IngredientScope::class)]
#[ObservedBy(IngredientObserver::class)]
/**
 * @mixin IdeHelperIngredient
 */
class Ingredient extends Model implements HasMedia
{
    use EnhancedMedia, HasUuids;

    public const string IMAGES_COLLECTION_NAME = 'ingredient_images';

    protected $fillable = [
        'user_id',
        'name',
        'allergens',
    ];

    protected function casts(): array
    {
        return [
            'allergens' => 'json',
        ];
    }

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

    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class)->using(IngredientRecipe::class);
    }

    public function scopeOwnedByUser(Builder $builder, null|string|User $user = null): Builder
    {
        if ($user === null) {
            $userID = \Auth::user()->id;
        } else {
            $userID = $user instanceof User ? $user->id : $user;
        }

        return $builder->where('ingredients.user_id', $userID);
    }

    public function scopePublic(Builder $builder): Builder
    {
        return $builder->whereNull('ingredients.user_id');
    }
}
