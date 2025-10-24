<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->get('user');
        $abilities = [];

        $abilities[] = match ($request->route()->getName()){
            'app-login' => 'app',
            default => 'desktop',
        };

        return response()->json([
            'data' => [
                'token' => $user->createToken('api', $abilities)->plainTextToken,
            ],
        ]);
    }

    public function user(UserRequest $request): UserResource
    {
        return new UserResource($request->user());
    }

    public function logout(LogoutRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $user->tokens()->delete();

        return response()->json(status: 204);
    }
}
