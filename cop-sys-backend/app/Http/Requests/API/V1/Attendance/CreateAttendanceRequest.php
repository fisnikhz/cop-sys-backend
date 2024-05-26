<?php

namespace App\Http\Requests\API\V1\Attendance;

use App\Http\Requests\API\APIRequest;

class CreateAttendanceRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'personnel_id' => 'required|exists:personnels,personnel_id',
            'attendance_date' => 'required|string',
            'entry_time' => 'required|string',
            // 'exit_time' => 'required|string',
            'missed_entry' => 'required|string'
        ];
    }
}
