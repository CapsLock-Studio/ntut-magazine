<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use Closure;

class ActiveUser
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $routeFragments = explode('@', Route::current()->getAction()['controller']);
        $contorller = $routeFragments[0];
        $action = $routeFragments[1];

        if ($contorller != 'App\Http\Controllers\Admin\UsersController' || ($action != 'setting' && $action != 'updateSetting')) {
        	$user = Auth::user();
			
			if (!$user->active) {
				$request->session()->flash('flashMessage', '帳戶尚未通過認證，請修改系統預設密碼啟用帳戶');
            	$request->session()->flash('flashStatus', 'warning');

				return redirect('/admin/users/setting');
			}
        }

        return $response;
    }

}
