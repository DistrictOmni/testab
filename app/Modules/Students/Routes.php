<?php
namespace App\Modules\Students;

use FastRoute\RouteCollector;

class Routes
{
    public static function defineRoutes(RouteCollector $r)
    {
        // Define student-specific routes
        $r->addRoute('GET', '/students', ['App\Modules\Students\Controllers\StudentController', 'index']);
        $r->addRoute('GET', '/students/{id:\d+}', ['App\Modules\Students\Controllers\StudentController', 'show']);
    }
}
