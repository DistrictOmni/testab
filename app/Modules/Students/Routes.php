<?php
namespace App\Modules\Students;

use FastRoute\RouteCollector;

class Routes
{
    public static function defineRoutes(RouteCollector $r)
    {
        // Existing routes
        $r->addRoute('GET', '/students', ['App\Modules\Students\Controllers\StudentController', 'index']);
        $r->addRoute('GET', '/students/{id:\d+}', ['App\Modules\Students\Controllers\StudentController', 'show']);

        // New test route
        $r->addRoute('GET', '/test', ['App\Controllers\DashboardController', 'index']);
    }
}
