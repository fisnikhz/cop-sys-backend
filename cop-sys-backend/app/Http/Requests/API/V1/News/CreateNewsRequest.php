<?php

namespace App\Http\Requests\API\V1\News;

use App\Http\Requests\API\APIRequest;

class CreateNewsRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'content' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
            'created_by' => 'required|uuid|exists:users,user_id',
            'created_at' => 'date',
            'updated_at' => 'date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
