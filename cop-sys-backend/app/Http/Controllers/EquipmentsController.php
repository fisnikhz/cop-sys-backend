<?php

namespace App\Http\Controllers;

use App\Http\Util\LocationHandler;
use App\Models\Equipment;
use App\Models\Location;
use App\Models\User;
use App\Traits\APIResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EquipmentsController extends Controller
{

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
