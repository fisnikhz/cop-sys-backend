<?php

namespace App\Http\Requests\API\V1\Message;

use App\Http\Requests\API\APIRequest;

class CreateMessageRequest extends APIRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'content' => 'required|string|max:5000'
        ];
    }
}
