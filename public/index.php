<?php
/**
 * Front controller
 * ! /public/index.php
 * * PHP Version: 8.2.12 or greater
 *  ? MySQL Version: 10.4.32-MariaDB or greater*
 *  TODO: FSDAF
 * PHP Version: 8.2.12 or greater
 * MySQL Version: 10.4.32-MariaDB or greater* 
 * 
 * @package DistrictOmni SIS
 */

 require_once __DIR__ . '/../vendor/autoload.php';
 
 use App\Core\Application;
 
 // Instantiate the Application (which will bootstrap everything)
 $app = new Application();
 $app->run();
 