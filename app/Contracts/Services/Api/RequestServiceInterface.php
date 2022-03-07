<?php

namespace App\Contracts\Services\Api;

use App\Models\Request;

interface RequestServiceInterface
{
    public function index($params);
    public function store($id);
    public function update(Request $request, $id);
    public function detail($id);
}
