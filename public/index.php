<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Get ibnclude path
set_include_path(implode(PATH_SEPARATOR, array(
    get_include_path(),
)));

// load zend
$loader = require APPLICATION_PATH . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
$loader->add('Zend_', __DIR__);

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();