<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class PersonnelController extends Controller
{   
    public function addPersonnel(Request $request): JsonResponse 
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'rank' => 'required|string',
                'badge_number' => 'required|string',
                'hire_date' => 'required|date',
                'profile_image' => 'nullable|string',
                'role' => 'required|exists:roles,role_id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $personnel = Personnel::create($request->all());
            $personnel->save(); 

            return response()->json(['message' => 'Personnel added successfully', 'personnel' => $personnel], 201);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
