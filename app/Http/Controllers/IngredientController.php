<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ingredient\AddImagesRequest;
use App\Http\Requests\Ingredient\IngredientDestroyRequest;
use App\Http\Requests\Ingredient\IngredientIndexRequest;
use App\Http\Requests\Ingredient\IngredientShowRequest;
use App\Http\Requests\Ingredient\IngredientStoreRequest;
use App\Http\Requests\Ingredient\IngredientUpdateRequest;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class IngredientController extends Controller
{
    public function index(IngredientIndexRequest $request): JsonResource
    {
        $validatedRequestInput = $request->validated();
        $ingredients = Ingredient::query()->with($validatedRequestInput['with'] ?? []);

        if ($validatedRequestInput['paginate'] ?? false) {
            $ingredients = $ingredients->paginate($validatedRequestInput['per_page'] ?? 10, page: $validatedRequestInput['page'] ?? 1);
        } else {
            $ingredients = $ingredients->get();
        }

        return IngredientResource::collection($ingredients);
    }

    public function store(IngredientStoreRequest $request): IngredientResource
    {
        $validatedRequestInput = $request->validated();
        $ingredient = (new Ingredient)->fill($validatedRequestInput);

        $ingredient->saveOrFail();

        return new IngredientResource($ingredient->loadMissing($validatedRequestInput['with'] ?? []));
    }

    public function show(IngredientShowRequest $request, Ingredient $ingredient): IngredientResource
    {
        $validatedRequestInput = $request->validated();

        return new IngredientResource($ingredient->loadMissing($validatedRequestInput['with'] ?? []));
    }

    public function update(IngredientUpdateRequest $request, Ingredient $ingredient): IngredientResource
    {
        $validatedRequestInput = $request->validated();
        $ingredient = $ingredient->fill($validatedRequestInput);

        $ingredient->saveOrFail();

        return new IngredientResource($ingredient->loadMissing($validatedRequestInput['with'] ?? []));
    }

    public function destroy(IngredientDestroyRequest $request, Ingredient $ingredient): JsonResponse
    {
        $ingredient->delete();

        return response()->json(status: 204);
    }

    public function addImages(AddImagesRequest $request, Ingredient $ingredient): JsonResponse
    {
        $validatedRequestInput = $request->validated();

        foreach ($validatedRequestInput['attachments'] as $attachment) {
            $ingredient->addMedia($attachment)->toMediaCollection(Ingredient::IMAGES_COLLECTION_NAME);
        }

        return response()->json(status: 204);
    }
}
