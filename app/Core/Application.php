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
        var_dump(class_exists('App\Controllers\DashboardController')); // Should return true if the class is found

        // Initialize the router instance and register routes from modules
// In Application.php
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
