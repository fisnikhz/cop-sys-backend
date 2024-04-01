<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Util\LocationHandler;
use App\Models\Equipment;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquipmentsController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/v1/addEquipment",
     *     operationId="addEquipment",
     *     tags={"Equipment"},
     *     summary="Add or update equipment",
     *     description="Adds new equipment or updates existing equipment.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         description="Equipment details",
     *         @OA\JsonContent(
     *             required={"name", "quantity"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="quantity", type="integer", format="int32"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="location_id", type="string"),
     *             @OA\Property(property="location_name", type="string"),
     *             @OA\Property(property="longitude", type="string"),
     *             @OA\Property(property="latitude", type="string"),
     *             @OA\Property(property="radius", type="integer", format="int32"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Equipment added or updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="quantity", type="integer", format="int32"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="location_id", type="string"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Database error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Database error: Something went wrong"),
     *         ),
     *     ),
     * )
     */
    public function addEquipment(Request $request) : JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'quantity' => 'required|int',
                'description' => 'string',
                'location_id' => 'string',
                'location_name' => 'string',
                'longitude' => 'string',
                'latitude' => 'string',
                'radius' => 'int'
            ]);

            $locationHandler = new LocationHandler();


            $location_id = $request->location_id;
            $location_name = $request->location_name;
            $longitude = $request->longitude;
            $latitude = $request->latitude;
            $radius = $request->radius;


            $location_id = $locationHandler->handle($location_id,$location_name,$longitude,$latitude,$radius);



            $existingEquipment = Equipment::where('name', $request->name)->first();

            if ($existingEquipment) {
                // Update existing equipment
                $existingEquipment->quantity += $request->quantity;
                $existingEquipment->location_id = $location_id;
                $existingEquipment->save();
                $equipment = $existingEquipment;
            } else {
                // Create new equipment
                $equipment = new Equipment([
                    'name' => $request->name,
                    'quantity' => $request->quantity,
                    'description' => $request->description,
                    'location_id' => $location_id
                ]);
                $equipment->save();
            }

            // Return the inserted/updated equipment object
            return response()->json($equipment);
        } catch (QueryException $exception) {
            // Handle database query exceptions
            return response()->json(['error' => 'Database error: ' . $exception->getMessage()], 500);
        } catch (\Exception $exception) {
            // Handle other exceptions
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/updateEquipment",
     *     operationId="updateEquipment",
     *     tags={"Equipment"},
     *     summary="Update equipment",
     *     description="Updates existing equipment with the provided data.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         description="Equipment details to be updated",
     *         @OA\JsonContent(
     *             required={"equipment_id"},
     *             @OA\Property(property="equipment_id", type="string", description="ID of the equipment to update"),
     *             @OA\Property(property="name", type="string", description="New name of the equipment"),
     *             @OA\Property(property="quantity", type="integer", description="New quantity of the equipment"),
     *             @OA\Property(property="description", type="string", description="New description of the equipment"),
     *             @OA\Property(property="location_id", type="string", description="New location ID of the equipment"),
     *             @OA\Property(property="location_name", type="string", description="New location name of the equipment"),
     *             @OA\Property(property="longitude", type="string", description="New longitude of the equipment"),
     *             @OA\Property(property="latitude", type="string", description="New latitude of the equipment"),
     *             @OA\Property(property="radius", type="integer", description="New radius of the equipment"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Equipment updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Equipment updated successfully"),
     *             @OA\Property(property="equipment", type="object",
     *                 @OA\Property(property="name", type="string", description="Updated name of the equipment"),
     *                 @OA\Property(property="quantity", type="integer", description="Updated quantity of the equipment"),
     *                 @OA\Property(property="description", type="string", description="Updated description of the equipment"),
     *                 @OA\Property(property="location_id", type="string", description="Updated location ID of the equipment"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the equipment was created"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the equipment was last updated"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object", description="Validation errors"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Database error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Database error: Something went wrong"),
     *         ),
     *     ),
     * )
     */
    public function updateEquipment(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'equipment_id' => 'required|exists:equipments,equipment_id',
                'name' => 'string',
                'quantity' => 'int',
                'description' => 'string',
                'location_id' => 'string',
                'location_name' => 'string',
                'longitude' => 'string',
                'latitude' => 'string',
                'radius' => 'int'
            ]);



            $location_id = $request->location_id;
            $location_name = $request->location_name;
            $longitude = $request->longitude;
            $latitude = $request->latitude;
            $radius = $request->radius;



            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $equipment = Equipment::find($request->equipment_id);

            if ($request->filled('name')) {
                $equipment->name = $request->name;
            }
            if ($request->filled('quantity')) {
                $equipment->quantity = $request->quantity;
            }
            if ($request->filled('description')) {
                $equipment->description = $request->description;
            }
            if ($request->filled('location_id')) {
                $equipment->location_id = $request->location_id;
            }
            if ($request->filled('location_name')) {
                $locationHandler = new LocationHandler();
                $equipment->location_name = $locationHandler->handle($location_id,$location_name,$longitude,$latitude,$radius);
            }

            $equipment->save();

            return response()->json(['message' => 'Equipment updated successfully', 'equipment' => $equipment], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
    /**
     * @OA\Delete(
     *     path="/api/v1/removeEquipment",
     *     operationId="removeEquipment",
     *     tags={"Equipment"},
     *     summary="Remove equipment",
     *     description="Removes the equipment with the provided ID.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         description="ID of the equipment to remove",
     *         @OA\JsonContent(
     *             required={"equipment_id"},
     *             @OA\Property(property="equipment_id", type="string", description="ID of the equipment to remove"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Equipment removed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Equipment removed successfully"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Equipment not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Equipment not found"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object", description="Validation errors"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Database error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Database error: Something went wrong"),
     *         ),
     *     ),
     * )
     */
    public function removeEquipment(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'equipment_id' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $vehicle = Equipment::where('equipment_id', $request->equipment_id)
                ->first();

            if (!$vehicle) {
                return response()->json(['message' => 'Equipment not found'], 404);
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
