<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        $user = Auth::guard('admins')->check();
        if ($user) {
            return $next($request);
        }else{
            return redirect('admin/login');
        }
    }
//    public function handleBak($request, Closure $next)
//    {
//        $user = User::all()->count();
//        if (!($user == 1)) {
//            if (!Auth::user()->hasPermissionTo('Administer roles & permissions')) // 用户是否具备此权限
//            {
//                abort('401');
//            }
//        }
//
//        return $next($request);
//    }
}
