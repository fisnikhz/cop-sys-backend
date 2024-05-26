<?php

namespace App\Http\Requests\API\V1\Attendance;

use App\Http\Requests\API\APIRequest;

class UpdateAttendanceRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'personnel_id' => 'exists:personnels,personnel_id',
            'attendance_date' => 'string',
            'entry_time' => 'string',
            // 'exit_time' => 'string',
            'missed_entry' => 'string'
        ];
    }
}

