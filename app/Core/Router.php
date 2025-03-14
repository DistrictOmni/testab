<?php

namespace App\Core;

use FastRoute\RouteCollector;

class Router
{
    private $dispatcher;

    public function __construct($routes = null)
    {
        // If no routes are passed, create an empty dispatcher
        if ($routes) {
            $this->dispatcher = \FastRoute\simpleDispatcher(function(RouteCollector $r) use ($routes) {
                // Register the provided routes
                foreach ($routes as $route) {
                    $r->addRoute($route['method'], $route['route'], $route['handler']);
                }
            });
        }
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
