<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     required={"name", "email", "password", "username", "device_id"},
 *     @OA\Property(property="user_id", type="string", format="uuid", example="8ec26c4e-af87-4e1c-a36d-8a02a4c56f59"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="email", type="string"),
 *     @OA\Property(property="password", type="string"),
 *     @OA\Property(property="salt", type="string"),
 *     @OA\Property(property="username", type="string"),
 *     @OA\Property(property="device_id", type="string"),
 *     @OA\Property(property="profile_image", type="string", nullable=true),
 *     @OA\Property(property="role", type="integer", nullable=true, description="Foreign key referencing the role of the user"),
 *     @OA\Property(property="personnel_id", type="string", format="uuid", nullable=true, description="Foreign key referencing the personnel associated with the user"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class UserController extends Controller
{

    /**
     * @OA\Post(
     *      path="/api/v1/login",
     *      operationId="loginUser",
     *      tags={"Authentication"},
     *      summary="User login",
     *      description="Authenticate a user using username and password.",
     *
     *      @OA\RequestBody(
     *          required=true,
     *          description="User credentials",
     *          @OA\JsonContent(
     *              required={"username", "password"},
     *              @OA\Property(property="username", type="string", example="john_doe"),
     *              @OA\Property(property="password", type="string", example="password123")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful login",
     *          @OA\JsonContent(
     *              @OA\Property(property="token", type="string", description="Access token"),
     *              @OA\Property(property="user", ref="#/components/schemas/User")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Invalid credentials")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="An error occurred: User not found!")
     *          )
     *      )
     * )
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            // Find the user by email
            $user = User::where('username', $request->username)->first();

            if (!$user || !$this->validatePassword($request->password, $user->password, $user->salt)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'User not found!'], 401);
        }

        // Generate a token for the authenticated user
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 200);
    }

    private function validatePassword($password, $hashedPassword, $salt): bool
    {
        // Hash the provided password with the salt
        $saltedPassword = $password . $salt;

        // Compare the hashed password with the hashed concatenated string
        return hash('sha256', $saltedPassword) === $hashedPassword;
    }



    /**
     * @OA\Post(
     *     path="/api/v1/addUser",
     *     operationId="addUser",
     *     tags={"Authentication"},
     *     summary="Signup",
     *     description="Registers a new user with the provided details.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="User details",
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "username", "device_id"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string", format="password"),
     *             @OA\Property(property="username", type="string"),
     *             @OA\Property(property="device_id", type="integer", format="int32"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User registered successfully"),
     *             @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."),
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="User with the provided email or username already exists",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User with the provided email or username already exists"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object"),
     *         ),
     *     ),
     * )
     */
    public function addUser(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => [
                'required',
                'string',
                'min:8',
                // Custom validation rule for password complexity
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/', $value)) {
                        $fail('The :attribute must contain at least one uppercase letter, one lowercase letter, one number, one special character, and be at least 8 characters long.');
                    }
                },
            ],
            'username' => 'required|string',
            'device_id' => 'required|int',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if a user already exists with the provided email or username
        $existingUser = User::where('email', $request->email)
            ->orWhere('username', $request->username)
            ->first();

        if ($existingUser) {
            return response()->json(['message' => 'User with the provided email or username already exists'], 409);
        }
        $password = $request->password;

        // Generate a unique salt for the user
        $salt = Str::random(16);

        // Concatenate the password with the salt
        $saltedPassword = $request->password . $salt;

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        // Hash the concatenated string (password + salt)
        $user->password = hash('sha256', $saltedPassword);
        $user->salt = $salt; // Save the salt for future verification
        $user->username = $request->username;
        $user->device_id = $request->device_id;

        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'User registered successfully', 'token' => $token, 'user' => $user], 201);
    }



}
