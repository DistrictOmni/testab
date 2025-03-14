<?php
namespace App\Modules\Faculty;

use FastRoute\RouteCollector;

class Routes
{
    public static function defineRoutes(RouteCollector $r)
    {
        // Define student-specific routes
        $r->addRoute('GET', '/faculty', ['App\Modules\Students\Controllers\StudentController', 'index']);
    }
}
