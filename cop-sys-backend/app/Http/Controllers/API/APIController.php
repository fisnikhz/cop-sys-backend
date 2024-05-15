<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\V1\Controller;
use App\Traits\APIResponse;

class APIController extends Controller
{
    use APIResponse;

    protected int $perPage = 20;

    public function __construct()
    {
        if ($perPage = (int) \request('items_per_page')) {
            $this->perPage = min(100, $perPage);
        }
    }
}
