<?php

namespace App\Http\Controllers;

use App\Http\Requests\Recipe\RecipeIndexRequest;
use App\Http\Requests\Recipe\RecipeStoreRequest;
use App\Http\Resources\RecipeResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRecipeController extends Controller
{
    public function index(RecipeIndexRequest $request, User $user): JsonResource
    {
        $validatedRequestInput = $request->validated();
        $recipes = $user->recipes();

        if ($validatedRequestInput['paginate'] ?? false) {
            $recipes = $recipes->paginate($validatedRequestInput['per_page'] ?? 10, page: $validatedRequestInput['page'] ?? 1);
        } else {
            $recipes = $recipes->get();
        }

        return RecipeResource::collection($recipes);
    }

    public function store(RecipeStoreRequest $request, User $user): RecipeResource
    {
        $validatedRequestInput = $request->validated();
        $recipe = $user->recipes()->create($validatedRequestInput);

        return new RecipeResource($recipe->loadMissing($validatedRequestInput['with'] ?? []));
    }
}
