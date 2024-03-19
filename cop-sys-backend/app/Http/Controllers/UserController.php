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
