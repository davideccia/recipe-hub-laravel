<?php

namespace App\Models\Scopes;

use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class IngredientScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (app()->runningInConsole()) {
            return;
        }

        $user = \Auth::user();

        switch ($user?->role) {
            case UserRoleEnum::ADMIN:
                break;
            case UserRoleEnum::USER:
                $builder
                    ->where(fn (Builder $b) => $b
                        ->ownedByUser()
                        ->orWhere->public()
                    );
                break;
            default:
                $builder->whereNull('ingredients.user_id');
                break;
        }
    }
}
