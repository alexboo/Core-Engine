<?php
if ( !empty($_SERVER['APP_ENV']) && $_SERVER['APP_ENV'] == 'development' ) {
    error_reporting(E_ALL);
}
else {
    error_reporting(0);
}

// Define path to application directory
defined('ROOT_PATH')
    || define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    ROOT_PATH . '/library',
    get_include_path(),
)));

/** Core_Application */
require_once 'Core/Application.php';

// Create application and run
$application = new Core_Application(ROOT_PATH . '/config/application.php');
$application->run();