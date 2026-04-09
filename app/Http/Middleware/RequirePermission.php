<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Enums\AdminPermission;

class RequirePermission
{
    public function handle(Request $request, Closure $next, string $permission): mixed
    {
        $user = $request->user();
        $permissionValue = AdminPermission::from($permission)->value;

        if ($user->is_super_admin || $user->$permissionValue) {
            return $next($request);
        }

        abort(403);
    }
}