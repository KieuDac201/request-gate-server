<?php

namespace App\Contracts\Services\Api;

use App\Models\Request;

interface RequestServiceInterface
{
    public function index($params);
}
