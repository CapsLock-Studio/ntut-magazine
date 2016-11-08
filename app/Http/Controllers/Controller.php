<?php

namespace App\Http\Controllers;

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
        
    }

    public function __destruct()
    {
        $route = Route::current();
        $routeFragments = explode('\\', explode('@', $route->getAction()['controller'])[0]);

        $controllerName = preg_replace('/controller$/', '', strtolower(end($routeFragments)));
        $actionName = explode('.', $route->getName());
        $actionName = end($actionName);

        view()->share("controller_{$controllerName}", "active");

        echo view("${controllerName}.${actionName}");
    }
}
