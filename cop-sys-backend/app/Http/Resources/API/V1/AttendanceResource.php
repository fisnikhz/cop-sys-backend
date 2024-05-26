<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'attendance_id' => $this->attendance_id,
            'personnel_id' => $this->personnel_id,
            'attendance_date' => $this->attendance_date,
            'entry_time' => $this->entry_time,
            // 'exit_time' => $this->exit_time,
            'missed_entry' => $this->missed_entry
        ];
    }
}
