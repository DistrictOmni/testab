<?php
namespace App\Core;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FilterHandler;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

class Logger
{
    /**
     * @var MonologLogger
     */
    private $logger;

    /**
     * Logger constructor.
     * Initializes logger based on APP_ENV and APP_DEBUG.
     */
    public function __construct()
    {
        // Initialize the logger instance first
        $this->logger = new MonologLogger('app');
        
        // Load environment variables before deciding log level
        $this->loadEnvVariables();

        // Determine the log level based on environment variables
        $logLevel = $this->determineLogLevel();

        // Define the log directory
        $logDir = __DIR__ . '/../../logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        
        // Create handlers - We'll set up the basic structure first
        
        // Create the consolidated app.log handler that captures all levels based on environment setting
        $appLogHandler = new StreamHandler($logDir . '/app.log', $logLevel);
        
        // Create specific handlers for each log level
        $debugHandler = new FilterHandler(
            new StreamHandler($logDir . '/debug.log', $logLevel), // Only process if passes env filter
            MonologLogger::DEBUG,  // Min level (exact match)
            MonologLogger::DEBUG   // Max level (exact match)
        );
        
        $infoHandler = new FilterHandler(
            new StreamHandler($logDir . '/info.log', $logLevel), // Only process if passes env filter
            MonologLogger::INFO,   // Min level (exact match)
            MonologLogger::INFO    // Max level (exact match)
        );
        
        $warnHandler = new FilterHandler(
            new StreamHandler($logDir . '/warn.log', $logLevel), // Only process if passes env filter
            MonologLogger::WARNING, // Min level (exact match)
            MonologLogger::WARNING  // Max level (exact match)
        );
        
        $errorHandler = new FilterHandler(
            new StreamHandler($logDir . '/error.log', $logLevel), // Only process if passes env filter
            MonologLogger::ERROR,  // Min level (exact match)
            MonologLogger::ERROR   // Max level (exact match)
        );
        
        $criticalHandler = new FilterHandler(
            new StreamHandler($logDir . '/critical.log', $logLevel), // Only process if passes env filter
            MonologLogger::CRITICAL, // Min level (exact match)
            MonologLogger::CRITICAL  // Max level (exact match)
        );
        
        // Add all handlers to the logger
        $this->logger->pushHandler($appLogHandler);
        $this->logger->pushHandler($debugHandler);
        $this->logger->pushHandler($infoHandler);
        $this->logger->pushHandler($warnHandler);
        $this->logger->pushHandler($errorHandler);
        $this->logger->pushHandler($criticalHandler);
        
        // Log that the logger is initialized and the environment used
        $this->logger->info('Logger initialized with environment: ' . ($_ENV['APP_ENV'] ?? getenv('APP_ENV') ?? 'unknown'));
    }

    /**
     * Loads environment variables from .env file.
     */
    private function loadEnvVariables()
    {
        // Check if environment variables are already loaded, if not, attempt to load from .env
        if (empty($_ENV['APP_ENV']) && empty(getenv('APP_ENV'))) {
            try {
                $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
                $dotenv->load();
            } catch (InvalidPathException $e) {
                // Can't use logger here as it's not fully initialized yet
                error_log("Unable to load .env file. Error: " . $e->getMessage());
            }
        }
    }

   /**
     * Determines the appropriate log level based on APP_DEBUG and APP_ENV.
     *
     * This method establishes the minimum log level threshold for the entire application.
     * Messages below this threshold won't be logged anywhere.
     *
     * Log Level Determination Logic:
     * - If APP_DEBUG=true: Uses DEBUG level (logs everything regardless of APP_ENV)
     * - If APP_ENV=development: Uses DEBUG level (logs everything)
     * - If APP_ENV=training: Uses WARNING level (logs warnings, errors, and critical)
     * - If APP_ENV=production or no environment set: Uses ERROR level (logs only errors and critical)
     */
    private function determineLogLevel(): int
    {
        $appDebug = $_ENV['APP_DEBUG'] ?? getenv('APP_DEBUG') ?? 'false';
        $appEnv = $_ENV['APP_ENV'] ?? getenv('APP_ENV') ?? 'production';

        // Default log level to ERROR if no environment variables exist
        $logLevel = MonologLogger::ERROR;

        // Logic based on APP_ENV and APP_DEBUG
        if ($appDebug === 'true') {
            $logLevel = MonologLogger::DEBUG;  // If APP_DEBUG is true, log all levels
        } elseif ($appEnv === 'development') {
            $logLevel = MonologLogger::DEBUG;  // Log debug level in development
        } elseif ($appEnv === 'training') {
            $logLevel = MonologLogger::WARNING;  // Log warning and error in training
        }

        return $logLevel;
    }

    /**
     * Log info level messages
     */
    public function info(string $message): void
    {
        $this->logger->info($message);
    }

    /**
     * Log debug level messages
     */
    public function debug(string $message): void
    {
        $this->logger->debug($message);
    }

    /**
     * Log warning level messages
     */
    public function warn(string $message): void
    {
        $this->logger->warning($message);
    }

    /**
     * Log error level messages
     */
    public function error(string $message): void
    {
        $this->logger->error($message);
    }

    /**
     * Log critical level messages
     */
    public function critical(string $message): void
    {
        $this->logger->critical($message);
    }
}