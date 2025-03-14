<?php

namespace App\Core;

use FastRoute\RouteCollector;

class Router
{
    private $dispatcher;

    public function __construct()
    {
        // Initialize the dispatcher directly inside the constructor
        $this->dispatcher = \FastRoute\simpleDispatcher(function(RouteCollector $r) {
            // Register routes here or you can pass them dynamically
            // For example, you can call your routes definition classes here
            \App\Modules\Students\Routes::defineRoutes($r);
            \App\Modules\Faculty\Routes::defineRoutes($r);
        });
    }

    /**
     * Dispatch the incoming request.
     *
     * @param string $httpMethod
     * @param string $uri
     * @return mixed
     */
    public function dispatch($httpMethod, $uri)
    {
        return $this->dispatcher->dispatch($httpMethod, $uri);
    }
}
