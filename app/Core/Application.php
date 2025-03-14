<?php
namespace App\Core;

use Exception;
use FastRoute\RouteCollector;
use App\Core\Services\EnvChecker;
use App\Modules\Students\Routes as StudentsRoutes;
use App\Modules\Faculty\Routes as FacultyRoutes;
use FastRoute\Dispatcher;

class Application
{
    protected $logger;
    protected $router;
    protected $env;

    public function __construct()
    {
        // Initialize the environment checker and load environment variables
        $this->initializeEnv();

        // Initialize the router instance and register routes from modules
// In Application.php
$this->router = new Router(); // No need to pass anything
    }

    /**
     * Initialize the dispatcher with routes.
     *
     * @return \FastRoute\Dispatcher
     */
    protected function initializeDispatcher()
    {
        return \FastRoute\simpleDispatcher(function(RouteCollector $r) {
            // Register routes from multiple modules dynamically
            StudentsRoutes::defineRoutes($r);
            FacultyRoutes::defineRoutes($r);
            // Add other modules here as needed
        });
    }

    /**
     * Initialize environment and logging.
     */
    protected function initializeEnv(): void
    {
        try {
            // Initialize the environment checker
            $envChecker = new EnvChecker();
            $envChecker->loadAndValidate();

            // Initialize the logger only if environment check passes
            $this->logger = new Logger();
            $this->logger->debug("Application bootstrapping started...");
            $this->logger->debug("Environment variable check passed.");
            $this->logger->debug("Global Logger Initialized");

            // Log current server time
            $currentTimestamp = date('m/d/Y h:i A');
            $this->logger->debug("Current server time: " . $currentTimestamp);

            // Get the app environment (APP_ENV)
            $this->env = $_ENV['APP_ENV'] ?? getenv('APP_ENV') ?? 'fallback: error: unknown';
            $this->logger->debug("Current application environment: " . $this->env);

            // Log the app debug level (APP_DEBUG)
            $appDebug = $_ENV['APP_DEBUG'] ?? getenv('APP_DEBUG') ?? 'fallback: error: unknown';
            $this->logger->debug("Current application debug level: " . $appDebug);

        } catch (Exception $e) {
            // Catch the exception from EnvChecker and skip logger initialization
            $this->throwUiError($e->getMessage());
        }
    }

    /**
     * Dispatch the incoming request.
     */
    public function run(): void
    {
        // Log the application start
        if (isset($this->logger)) {
            $this->logger->info("Application started.");
        }
    
        // Log the incoming request
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        if (isset($this->logger)) {
            $this->logger->info("Incoming request: {$httpMethod} {$uri}");
        }
    
        // Dispatch the route
        $routeInfo = $this->router->dispatch($httpMethod, $uri);
    
        // Log the route dispatch outcome
        if (isset($this->logger)) {
            $this->logger->info("Route dispatch result: " . $routeInfo[0]);
        }
    
        // Handle route (dispatch to controller method)
        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $params = $routeInfo[2];
                
                // Log handler and parameters
                if (isset($this->logger)) {
                    $this->logger->info("Route found. Handler: " . json_encode($handler) . ", Params: " . json_encode($params));
                }
    
                // Call the controller and method
                list($controller, $method) = $handler;
                $controller = new $controller();
                
                // Log before calling the controller method
                if (isset($this->logger)) {
                    $this->logger->info("Calling method {$method} of controller {$controller}");
                }
    
                call_user_func_array([$controller, $method], $params);
                break;
    
            case \FastRoute\Dispatcher::NOT_FOUND:
                // Log 404 error
                if (isset($this->logger)) {
                    $this->logger->debug("404 Not Found: {$uri}");
                }
                echo '404 Not Found';
                break;
    
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                // Log 405 error
                if (isset($this->logger)) {
                    $this->logger->warning("405 Method Not Allowed: {$uri}");
                }
                echo '405 Method Not Allowed';
                break;
        }
    }
    
    /**
     * Throws an error for the UI if required environment variable is not set.
     *
     * @param string $message Error message to display
     * @throws Exception
     */
    protected function throwUiError(string $message): void
    {
        // Skip logging if the logger is not initialized
        if (isset($this->logger)) {
            $this->logger->critical("Critical error: " . $message);
        }

        // Display error to the UI or handle as needed
        echo '<h1>Application Error</h1>';
        echo '<p>' . $message . '</p>';

        // Optionally, terminate the application
        exit(1);
    }
}
