<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use App\Exceptions\CheckAuthorizationException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        $role = explode("|", $roles);
        $user = Auth::user();
        if (in_array('admin', $role) && $user->role_id == RoleEnum::ROLE_ADMIN) {
            return $next($request);
        }
        if (in_array('manager', $role) && $user->role_id == RoleEnum::ROLE_QUAN_LY_BO_PHAN) {
            return $next($request);
        }
        if (in_array('employee', $role) && $user->role_id == RoleEnum::ROLE_CAN_BO_NHAN_VIEN) {
            return $next($request);
        }
        throw new CheckAuthorizationException('You do not have permission to perform this action');
    }
}
