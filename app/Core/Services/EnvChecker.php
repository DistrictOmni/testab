<?php
namespace App\Core\Services;

use Dotenv\Dotenv;
use Exception;

/**
 * Class EnvChecker
 * Handles loading and checking of environment variables from the .env file.
 */
class EnvChecker
{
    protected $envFilePath;
    protected $checks = [];

    /**
     * EnvChecker constructor.
     * @param string $envFilePath Path to the .env file.
     */
    public function __construct($envFilePath = __DIR__ . '/../../../.env')
    {
        $this->envFilePath = $envFilePath;
    }

    /**
     * Adds a custom check for an environment variable.
     * 
     * @param callable $check A callable that performs a check on the environment variable.
     *                         The callable should return true if the check passes, false otherwise.
     */
    public function addCheck(callable $check)
    {
        $this->checks[] = $check;
    }

    /**
     * Loads the .env file and validates environment variables.
     */
    public function loadAndValidate(): void
    {
        // Load the .env file
        if (!file_exists($this->envFilePath)) {
            throw new Exception('.env file does not exist in the project.');
        }

        // Load the .env variables using Dotenv
        $dotenv = Dotenv::createImmutable(dirname($this->envFilePath));
        $dotenv->load();

        // Accumulate missing environment variables
        $missingVars = [];

        // Check if APP_ENV is set
        if (empty($_ENV['APP_ENV'])) {
            $missingVars[] = 'APP_ENV';
        }

        // Check if APP_DEBUG is set
        if (empty($_ENV['APP_DEBUG'])) {
            $missingVars[] = 'APP_DEBUG';
        }

        // If there are missing variables, throw an exception with all missing keys
        if (!empty($missingVars)) {
            $missingVarsList = implode(', ', $missingVars);
            throw new Exception('Missing environment variables: ' . $missingVarsList);
        }

    }
}
