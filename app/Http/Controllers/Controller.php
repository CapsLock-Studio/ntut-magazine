<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __destruct()
    {
        $route = Route::currentRouteName();
        $name  = explode(".", $route);
        $name  = array_shift($name);
        view()->share("controller", $name);
        view()->share($name, "active");
        if ($title && Auth::check() && !request()->wantsJson()) {
            view()->share("title", $name);
            echo view()->make($route);
        }
    }
}
