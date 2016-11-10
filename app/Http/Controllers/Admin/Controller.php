<?php

namespace App\Http\Controllers\Admin;

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
        // $this->middleware('auth');
    }

    public function __destruct()
    {
        $route = Route::current();
        $routeFragments = explode('\\', explode('@', $route->getAction()['controller'])[0]);

        $namespace = str_replace('/', '', $route->getPrefix());
        $controllerName = preg_replace('/controller$/', '', strtolower(end($routeFragments)));
        $actionName = explode('.', $route->getName());
        $actionName = end($actionName);

        view()->share("controller", $controllerName);
        view()->share("controller_{$controllerName}", "active");
        if (Auth::check() && !request()->wantsJson()) {
            view()->share("title", $controllerName);
            echo view("${namespace}.${controllerName}.${actionName}");
        }
    }
}
