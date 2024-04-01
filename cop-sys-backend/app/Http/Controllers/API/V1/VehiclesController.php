<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Vehicle;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehiclesController extends Controller
{
    public function addVehicle(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'vehicle_registration' => 'required|string',
                'manufacture_name' => 'required|string',
                'serie' => 'required|string',
                'type' => 'required|string',
                'produced_date' => 'required|date',
                'purchased_date' => 'required|date',
                'registration_date' => 'required|date',
                'designated_driver' => 'required|exists:personnels,personnel_id',
                'car_picture' => 'string',
                'car_location' => 'exists:locations,location_id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $vehicle = Vehicle::create($request->all());
            $vehicle->save();

            return response()->json(['message' => 'Vehicle added successfully', 'vehicle' => $vehicle], 201);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    
}
