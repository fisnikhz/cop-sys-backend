<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Auth\ChangePasswordRequest;
use App\Http\Requests\API\V1\Auth\LoginRequest;
use App\Http\Requests\API\V1\Auth\RegisterRequest;
use App\Models\Personnel;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends APIController
{
    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="User login",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="user", ref="#/components/schemas/UserResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::with('role')->where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password . $user->salt, $user->password)) {
            return $this->respondWithError(__('auth.failed'), __('app.login.failed'));
        }

        $response = [
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => $user->makeHidden('password','salt'),
        ];

        return $this->respondWithSuccess($response, __('app.login.success'));
    }

    /**
     * @OA\Post(
     *     path="/api/v1/register",
     *     summary="User registration",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user", ref="#/components/schemas/UserResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */

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
            'user' => $user->makeHidden('password','salt'),
        ];

        return $this->respondWithSuccess($response, __('app.success'), 201);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/user/profile",
     *     summary="Get user profile",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="User profile retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/UserResource")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function getUserProfile(User $user): JsonResponse
    {
        return $this->respondWithSuccess($user);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/user/change-password",
     *     summary="Change user password",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ChangePasswordRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password changed successfully"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = Auth::user();

        if (!Hash::check($data['current_password'] . $user->salt, $user->password)) {
            return $this->respondWithError(__('auth.failed'), __('app.register.failed'));
        }

        $newSalt = Str::random(12);

        // Hash the new password with the new salt
        $newHashedPassword = Hash::make($data['new_password'] . $newSalt);

        // Update user's password and salt
        $user->password = $newHashedPassword;
        $user->salt = $newSalt;
        $user->save();

        return $this->respondWithSuccess(__('app.success'), 200);

    }

}
