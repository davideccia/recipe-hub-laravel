<?php

namespace App\Models;

use App\Contracts\HasReviews;
use App\Enums\UserRoleEnum;
use App\Models\Scopes\UserScope;
use App\Observers\UserObserver;
use App\Traits\Reviewable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[ScopedBy(UserScope::class)]
#[ObservedBy(UserObserver::class)]
/**
 * @var UserRoleEnum $role
 * @mixin IdeHelperUser
 */
class User extends Authenticatable implements HasReviews
{
    use HasApiTokens, HasUUids, MustVerifyEmail, Notifiable, Reviewable;

    protected $fillable = [
        'last_name',
        'first_name',
        'role',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'role' => UserRoleEnum::class,
            'password' => 'hashed',
        ];
    }

    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }

    public function ingredients(): HasMany
    {
        return $this->hasMany(Ingredient::class);
    }

    public function manageApplication(): bool
    {
        return $this->role === UserRoleEnum::ADMIN;
    }

    public function notifiableReviewUser(): User
    {
        return $this;
    }
}
