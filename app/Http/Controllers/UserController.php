<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserDestroyRequest;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Requests\User\UserShowRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    public function index(UserIndexRequest $request): JsonResource
    {
        $validatedRequestInput = $request->validated();
        $users = User::query()->with($validatedRequestInput['with'] ?? []);

        if ($validatedRequestInput['paginate'] ?? false) {
            $users = $users->paginate($validatedRequestInput['per_page'] ?? 10, page: $validatedRequestInput['page'] ?? 1);
        } else {
            $users = $users->get();
        }

        return UserResource::collection($users);
    }

    public function store(UserStoreRequest $request): UserResource
    {
        $validatedRequestInput = $request->validated();
        $user = (new User)->fill($validatedRequestInput);

        $user->saveOrFail();

        return new UserResource($user->loadMissing($validatedRequestInput['with'] ?? []));
    }

    public function show(UserShowRequest $request, User $user): UserResource
    {
        $validatedRequestInput = $request->validated();

        return new UserResource($user->loadMissing($validatedRequestInput['with'] ?? []));
    }

    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $validatedRequestInput = $request->validated();
        $user = $user->fill($validatedRequestInput);

        $user->saveOrFail();

        return new UserResource($user->loadMissing($validatedRequestInput['with'] ?? []));
    }

    public function destroy(UserDestroyRequest $request, User $user): JsonResponse
    {
        $user->delete();

        return response()->json(status: 204);
    }
}
