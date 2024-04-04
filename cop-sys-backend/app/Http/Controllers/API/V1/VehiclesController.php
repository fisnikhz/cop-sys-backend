<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Vehicle;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Schema(
 *     schema="Vehicle",
 *     title="Vehicle",
 *     description="Vehicle model",
 *     @OA\Property(property="vehicle_id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000"),
 *     @OA\Property(property="vehicle_registration", type="string", example="ABC123"),
 *     @OA\Property(property="manufacture_name", type="string", example="Toyota"),
 *     @OA\Property(property="serie", type="string", example="Corolla"),
 *     @OA\Property(property="type", type="string", example="Sedan"),
 *     @OA\Property(property="produced_date", type="string", format="date", example="2023-01-01"),
 *     @OA\Property(property="purchased_date", type="string", format="date", example="2023-02-01"),
 *     @OA\Property(property="registration_date", type="string", format="date", example="2023-03-01"),
 *     @OA\Property(property="designated_driver", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000"),
 *     @OA\Property(property="car_picture", type="string", example="https://example.com/car.jpg"),
 *     @OA\Property(property="car_location", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
 * )
 */
class VehiclesController extends Controller
{
    /**
     * Add a new vehicle.
     *
     * @OA\Post(
     *     path="/api/addVehicle",
     *     summary="Add a new vehicle",
     *     tags={"Vehicles"},
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="vehicle_registration", type="string"),
     *                 @OA\Property(property="manufacture_name", type="string"),
     *                 @OA\Property(property="serie", type="string"),
     *                 @OA\Property(property="type", type="string"),
     *                 @OA\Property(property="produced_date", type="string", format="date"),
     *                 @OA\Property(property="purchased_date", type="string", format="date"),
     *                 @OA\Property(property="registration_date", type="string", format="date"),
     *                 @OA\Property(property="designated_driver", type="integer", example="1"),
     *                 @OA\Property(property="car_picture", type="string"),
     *                 @OA\Property(property="car_location", type="integer", example="1"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Vehicle added successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Vehicle added successfully"),
     *             @OA\Property(property="vehicle", ref="#/components/schemas/Vehicle")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Database error or server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Database error: ...")
     *         )
     *     )
     * )
     */
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
    /**
 * @OA\Post(
 *     path="/api/update-vehicle",
 *     summary="Update a vehicle",
 *     tags={"Vehicle"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"vehicle_id", "vehicle_registration", "manufacture_name", "serie", "type", "produced_date", "purchased_date", "registration_date", "designated_driver"},
 *             @OA\Property(property="vehicle_id", type="string", example="12345"),
 *             @OA\Property(property="vehicle_registration", type="string", example="ABC123"),
 *             @OA\Property(property="manufacture_name", type="string", example="Toyota"),
 *             @OA\Property(property="serie", type="string", example="Corolla"),
 *             @OA\Property(property="type", type="string", example="Sedan"),
 *             @OA\Property(property="produced_date", type="string", format="date", example="2023-01-15"),
 *             @OA\Property(property="purchased_date", type="string", format="date", example="2023-02-20"),
 *             @OA\Property(property="registration_date", type="string", format="date", example="2023-02-25"),
 *             @OA\Property(property="designated_driver", type="string", example="123"),
 *             @OA\Property(property="car_picture", type="string", example="image_url"),
 *             @OA\Property(property="car_location", type="string", example="456"),
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Vehicle updated successfully"),
 *             @OA\Property(property="vehicle", type="object", ref="#/components/schemas/Vehicle")
 *         )
 *     ),
 *     @OA\Response(
 *         response="422",
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="errors", type="object", example={"vehicle_id": {"The selected vehicle_id is invalid."}})
 *         )
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="An error occurred: Internal Server Error")
 *         )
 *     )
 * )
 */

    public function updateVehicle(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'vehicle_id' => 'required|exists:vehicle,vehicle_id',
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

            $vehicle = Vehicle::find($request->vehicle_id);
            $vehicle->update($request->all());

            return response()->json(['message' => 'Vehicle updated successfully', 'vehicle' => $vehicle], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

/**
 * @OA\Post(
 *     path="/api/remove-vehicle",
 *     summary="Remove a vehicle",
 *     tags={"Vehicle"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"vehicle_id"},
 *             @OA\Property(property="vehicle_id", type="string", example="12345")
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Vehicle removed successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response="404",
 *         description="Vehicle not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Vehicle not found")
 *         )
 *     ),
 *     @OA\Response(
 *         response="422",
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="errors", type="object", example={"vehicle_id": {"The vehicle_id field is required."}})
 *         )
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="An error occurred: Internal Server Error")
 *         )
 *     )
 * )
 */

    public function removeVehicle(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'vehicle_id' => 'required|string', 
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $vehicle = Vehicle::where('vehicle_id', $request->vehicle_id)
                ->first();

            if (!$vehicle) {
                return response()->json(['message' => 'Vehicle not found'], 404);
            }

            $vehicle->delete();

            return response()->json(['message' => 'Vehicle removed successfully'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }


}
