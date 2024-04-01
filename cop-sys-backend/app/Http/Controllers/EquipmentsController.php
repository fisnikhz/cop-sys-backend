<?php

namespace App\Http\Controllers;

use App\Http\Util\LocationHandler;
use App\Models\Equipment;
use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EquipmentsController extends Controller
{

    public function addEquipment(Request $request): JsonResponse
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
}
