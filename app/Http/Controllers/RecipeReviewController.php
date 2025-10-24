<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\ReviewIndexRequest;
use App\Http\Requests\Review\ReviewStoreRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Recipe;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeReviewController extends Controller
{
    public function index(ReviewIndexRequest $request, Recipe $recipe): JsonResource
    {
        $validatedRequestInput = $request->validated();
        $reviews = $recipe->reviews()->with($validatedRequestInput['with'] ?? []);

        if ($validatedRequestInput['paginate'] ?? false) {
            $reviews = $reviews->paginate($validatedRequestInput['per_page'] ?? 10, page: $validatedRequestInput['page'] ?? 1);
        } else {
            $reviews = $reviews->get();
        }

        return ReviewResource::collection($reviews);
    }

    public function store(ReviewStoreRequest $request, Recipe $recipe): ReviewResource
    {
        $validatedRequestInput = $request->validated();
        $review = $recipe->reviews()->create($validatedRequestInput);

        $review->saveOrFail();

        return new ReviewResource($review->loadMissing($validatedRequestInput['with'] ?? []));
    }
}
