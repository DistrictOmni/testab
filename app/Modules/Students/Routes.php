<?php
namespace App\Modules\Students;

use FastRoute\RouteCollector;

class Routes
{
// In Routes.php (example)
public static function defineRoutes(RouteCollector $r)
{
    $r->addRoute('GET', '/test', ['App\Controllers\DashboardController', 'index']);
}

}
