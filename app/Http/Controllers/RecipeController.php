<?php

namespace App\Http\Controllers;

use App\Http\Requests\Recipe\AddImagesRequest;
use App\Http\Requests\Recipe\RecipeDestroyRequest;
use App\Http\Requests\Recipe\RecipeIndexRequest;
use App\Http\Requests\Recipe\RecipeShowRequest;
use App\Http\Requests\Recipe\RecipeStoreRequest;
use App\Http\Requests\Recipe\RecipeUpdateRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeController extends Controller
{
    public function index(RecipeIndexRequest $request): JsonResource
    {
        $validatedRequestInput = $request->validated();
        $recipes = Recipe::query()->with($validatedRequestInput['with'] ?? []);

        if(isset($validatedRequestInput['search'])){
            $recipes->databaseSearch($validatedRequestInput['search']);
        }

        if ($validatedRequestInput['paginate'] ?? false) {
            $recipes = $recipes->paginate($validatedRequestInput['per_page'] ?? 10, page: $validatedRequestInput['page'] ?? 1);
        } else {
            $recipes = $recipes->get();
        }

        return RecipeResource::collection($recipes);
    }

    public function store(RecipeStoreRequest $request): RecipeResource
    {
        $validatedRequestInput = $request->validated();
        $recipe = (new Recipe)->fill($validatedRequestInput);

        \DB::beginTransaction();

        $recipe->saveOrFail();

        if (isset($validatedRequestInput['ingredients'])) {
            $recipe->ingredientsBatchSave($validatedRequestInput['ingredients']);
        }

        \DB::commit();

        return new RecipeResource($recipe->loadMissing($validatedRequestInput['with'] ?? []));
    }

    public function show(RecipeShowRequest $request, Recipe $recipe): RecipeResource
    {
        $validatedRequestInput = $request->validated();

        return new RecipeResource($recipe->loadMissing($validatedRequestInput['with'] ?? []));
    }

    public function update(RecipeUpdateRequest $request, Recipe $recipe): RecipeResource
    {
        $validatedRequestInput = $request->validated();
        $recipe = $recipe->fill($validatedRequestInput);

        \DB::beginTransaction();

        $recipe->saveOrFail();

        if (isset($validatedRequestInput['ingredients'])) {
            $recipe->ingredientsBatchSave($validatedRequestInput['ingredients']);
        }

        \DB::commit();

        return new RecipeResource($recipe->loadMissing($validatedRequestInput['with'] ?? []));
    }

    public function destroy(RecipeDestroyRequest $request, Recipe $recipe): JsonResponse
    {
        $recipe->delete();

        return response()->json(status: 204);
    }

    public function addImages(AddImagesRequest $request, Recipe $recipe): JsonResponse
    {
        $validatedRequestInput = $request->validated();

        foreach ($validatedRequestInput['attachments'] as $attachment) {
            $recipe->addMedia($attachment)->toMediaCollection(Recipe::IMAGES_COLLECTION_NAME);
        }

        return response()->json(status: 204);
    }
}
