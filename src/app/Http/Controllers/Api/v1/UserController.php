<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\LoginRequest;
use App\Http\Requests\Api\V1\User\LogoutRequest;
use App\Http\Requests\Api\V1\User\RegisterRequest;
use App\Http\Requests\Api\V1\User\ReplaceUserReferencesRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): JsonResource
    {
        $user = $request->user();
        $token = $user->createToken($request->email);
        $user->load('authors', 'categories', 'sources');

        return new UserResource($user)->additional([
            'token' => $token->plainTextToken,
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request): JsonResource
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'email_verified_at' => now(), // for demo purpose only
        ]);
        $token = $user->createToken($request->email);

        return new UserResource($user)->additional([
            'token' => $token->plainTextToken,
            'message' => 'Registered successfully',
        ]);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(LogoutRequest $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout successful']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserPreferences(ReplaceUserReferencesRequest $request)
    {
        $user = $request->user();
        $user->categories()->sync($request->input('categories'));
        $user->sources()->sync($request->input('sources'));
        $user->authors()->sync($request->input('authors'));

        return response()->json(['message' => 'preferences updated successfully']);
    }
}
