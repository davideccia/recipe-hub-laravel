<?php

namespace App\Models;

use App\Models\Scopes\ReviewScope;
use App\Observers\ReviewObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[ScopedBy(ReviewScope::class)]
#[ObservedBy(ReviewObserver::class)]
/**
 * @mixin IdeHelperReview
 */
class Review extends Model
{
    use HasUuids;

    protected $fillable = [
        'reviewable_type',
        'reviewable_id',
        'user_id',
        'rating',
        'title',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'float',
        ];
    }

    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
