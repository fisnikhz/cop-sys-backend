<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Auth\LoginRequest;
use App\Http\Requests\API\V1\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends APIController
{
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::query()->where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->respondWithError(__('auth.failed'), __('app.login.failed'));
        }

        $response = [
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => $user->makeHidden('password'),
        ];

        return $this->respondWithSuccess($response, __('app.login.success'));
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $salt = Str::random(12);
        $data['salt'] = $salt;

        $hashedPassword = Hash::make($data['password'] . $salt);
        $data['password'] = $hashedPassword;

        $existingUser = User::where('email', $data['email'])
            ->orWhere('username', $data['username'])
            ->first();

        if ($existingUser) {
            return $this->respondWithError(__('auth.failed'), __('app.register.failed'));
        }

        $user = User::create($data);

        $response = [
            'user' => $user->makeHidden('password'),
        ];

        return $this->respondWithSuccess($response, __('app.success'), 201);
    }
}
