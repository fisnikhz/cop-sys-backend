<?php

namespace App\Http\Requests\API\V1\Campaign;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCampaignRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'string|max:255',
            'pdf' => 'file|mimes:pdf|max:2048',
        ];
    }
}
