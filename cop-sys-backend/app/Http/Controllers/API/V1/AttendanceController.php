<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Attendance\CreateAttendanceRequest;
use App\Http\Requests\API\V1\Attendance\UpdateAttendanceRequest;
use App\Http\Resources\API\V1\AttendanceResource;
use App\Models\Attendance;
use Faker\Provider\Person;
use Illuminate\Http\JsonResponse;

class AttendanceController extends APIController
{
     /**
     * @OA\Post(
     *     path="/api/v1/attendance",
     *     summary="Add a new attendance record",
     *     tags={"Attendance"},
     *     @OA\RequestBody(
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Attendance record added successfully",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function addAttendance(CreateAttendanceRequest $request): JsonResponse
    {
        $data = $request->validated();

        $attendanceData = Attendance::query()->create($data);

        return $this->respondWithSuccess(AttendanceResource::make($attendanceData));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/attendance/{attendance}",
     *     summary="Update an existing attendance record",
     *     tags={"Attendance"},
     *     @OA\Parameter(
     *         name="attendance",
     *         in="path",
     *         required=true,
     *        
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *        
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Attendance record updated successfully",
     *        
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Attendance record not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function updateAttendance(UpdateAttendanceRequest $request, Attendance $attendance): JsonResponse
    {
        $data = $request->validated();

        $attendance = Attendance::find($attendance->attendance_id)->firstOrFail();

        $attendance->update($data);

        return $this->respondWithSuccess(AttendanceResource::make($attendance));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/attendance/{attendance}",
     *     summary="Remove an attendance record",
     *     tags={"Attendance"},
     *     @OA\Parameter(
     *         name="attendance",
     *         in="path",
     *         required=true,
     *        
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Attendance record deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Attendance record not found"
     *     )
     * )
     */
    public function removeAttendance(Attendance $attendance): JsonResponse
    {
        $attendance->delete();

        return $this->respondWithSuccess(null, __('app.attendance.deleted'));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/attendance/{attendance}",
     *     summary="Get an attendance record by ID",
     *     tags={"Attendance"},
     *     @OA\Parameter(
     *         name="attendance",
     *         in="path",
     *         required=true,
     *       
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Attendance record retrieved successfully",
     *         
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Attendance record not found"
     *     )
     * )
     */
    public function getAttendance(Int $attendance): JsonResponse{

        return $this->respondWithSuccess(Attendance::find($attendance)->firstOrFail);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/attendance",
     *     summary="Get all attendance records",
     *     tags={"Attendance"},
     *     @OA\Response(
     *         response=200,
     *         description="Attendance records list retrieved successfully",
     *         
     *     )
     * )
     */
    public function getAllAttendances(): JsonResponse{

        return $this->respondWithSuccess(Attendance::all());
    }
}