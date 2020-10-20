<?php

namespace App\Http\Middleware;

use App\Model\Permission;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('admins')->user();
        if($user->id != 1){
            $route = Route::currentRouteName();
            if($permission = Permission::where('route', $route)->first())
            {
                $result = Auth::guard('admins')->user()->hasPermission($permission->id,$user->role_id);
                if($result){
                    return $next($request);
                }else{
                    abort(403);
                }
            }
        }
        return $next($request);
    }
}
