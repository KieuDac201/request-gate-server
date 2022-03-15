<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Middleware\TrustHosts as Middleware;
use Illuminate\Http\Request;

class TrustHosts extends Middleware
{
    public function hosts()
    {
        return [
            $this->allSubdomainsOfApplicationUrl(),
            'https://dev-talents01.hblab.dev'
        ];
    }
}
