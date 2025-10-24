<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\ReviewDestroyRequest;
use App\Http\Requests\Review\ReviewIndexRequest;
use App\Http\Requests\Review\ReviewShowRequest;
use App\Http\Requests\Review\ReviewStoreRequest;
use App\Http\Requests\Review\ReviewUpdateRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewController extends Controller
{
    public function index(ReviewIndexRequest $request): JsonResource
    {
        $validatedRequestInput = $request->validated();
        $reviews = Review::query()->with($validatedRequestInput['with'] ?? []);

        if ($validatedRequestInput['paginate'] ?? false) {
            $reviews = $reviews->paginate($validatedRequestInput['per_page'] ?? 10, page: $validatedRequestInput['page'] ?? 1);
        } else {
            $reviews = $reviews->get();
        }

        return ReviewResource::collection($reviews);
    }

    public function store(ReviewStoreRequest $request): ReviewResource
    {
        $validatedRequestInput = $request->validated();
        $review = (new Review)->fill($validatedRequestInput);

        $review->saveOrFail();

        return new ReviewResource($review->loadMissing($validatedRequestInput['with'] ?? []));
    }

    public function show(ReviewShowRequest $request, Review $review): ReviewResource
    {
        $validatedRequestInput = $request->validated();

        return new ReviewResource($review->loadMissing($validatedRequestInput['with'] ?? []));
    }

    public function update(ReviewUpdateRequest $request, Review $review): ReviewResource
    {
        $validatedRequestInput = $request->validated();
        $review = $review->fill($validatedRequestInput);

        $review->saveOrFail();

        return new ReviewResource($review->loadMissing($validatedRequestInput['with'] ?? []));
    }

    public function destroy(ReviewDestroyRequest $request, Review $review): JsonResponse
    {
        $review->delete();

        return response()->json(status: 204);
    }
}
