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
    public function addAttendance(CreateAttendanceRequest $request): JsonResponse
    {
        $data = $request->validated();

        $attendanceData = Attendance::query()->create($data);

        return $this->respondWithSuccess(AttendanceResource::make($attendanceData));
    }

    public function updateAttendance(UpdateAttendanceRequest $request, Attendance $attendance): JsonResponse
    {
        $data = $request->validated();

        $attendance = Attendance::find($attendance->attendance_id)->firstOrFail();

        $attendance->update($data);

        return $this->respondWithSuccess(AttendanceResource::make($attendance));
    }

    public function removeAttendance(Attendance $attendance): JsonResponse
    {
        $attendance->delete();

        return $this->respondWithSuccess(null, __('app.attendance.deleted'));
    }

    public function getAttendance(Int $attendance): JsonResponse{

        return $this->respondWithSuccess(Attendance::find($attendance)->firstOrFail);
    }
    public function getAllAttendances(): JsonResponse{

        return $this->respondWithSuccess(Attendance::all());
    }
}