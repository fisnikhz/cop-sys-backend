<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;






class UserController extends Controller
{

    /**
     * @OA\Post(
     *      path="/login",
     *      operationId="login",
     *      tags={"Authentication"},
     *      summary="Login a user",
     *      description="Logs in a user with username and password.",
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
     *          description="Login successful",
     *          @OA\JsonContent(
     *              @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Invalid credentials")
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
     *      path="/addUser",
     *      operationId="addUser",
     *      tags={"Authentication"},
     *      summary="Register a new user",
     *      description="Registers a new user with the provided information.",
     *      @OA\RequestBody(
     *          required=true,
     *          description="User data",
     *          @OA\JsonContent(
     *              required={"name", "email", "password", "username", "device_id"},
     *              @OA\Property(property="name", type="string", example="John Doe"),
     *              @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *              @OA\Property(property="password", type="string", example="password123"),
     *              @OA\Property(property="username", type="string", example="john_doe"),
     *              @OA\Property(property="device_id", type="integer", example="123456")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="User registered successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="User registered successfully"),
     *              @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="errors", type="object", example={"name": {"The name field is required."}, "email": {"The email field is required."}})
     *          )
     *      ),
     *      @OA\Response(
     *          response=409,
     *          description="Conflict",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="User with the provided email or username already exists")
     *          )
     *      )
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
