<?php

namespace App\Http\Requests\API\V1\Campaign;

use App\Http\Requests\API\APIRequest;

class CreateCampaignRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'pdf' => 'required|file|mimes:pdf|max:2048',
        ];
    }
}
