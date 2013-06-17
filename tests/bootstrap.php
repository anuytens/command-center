<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', 'testing');

// Get include path
set_include_path(implode(PATH_SEPARATOR, array(
    get_include_path(),
)));

// Load libraries
try
{
    $path_to_autoload = APPLICATION_PATH . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

    if (!file_exists($path_to_autoload))
    {
        throw new Exception ('autoload.php does not exist. run \'php composer.phar install\'.');
    }

    $loader = require $path_to_autoload;
    $loader->add('Zend_', __DIR__);
}
catch(Exception $e)
{
    echo "Message : " . $e->getMessage();
    echo "Code : " . $e->getCode();
    die();
}

/**
 * 1. list namespaces
 */
use
	Doctrine\ORM\Configuration;
 
require_once 'Doctrine/Common/ClassLoader.php';

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine');
$classLoader->register();
 
/**
 * 2. implement cache 
 */
$cache = new \Doctrine\Common\Cache\ArrayCache;
 
/**
 * 3. prepare conf 
 */
// Implement Configuration
$configDoctrine = new Configuration;
// Add cache to config
$configDoctrine->setMetadataCacheImpl($cache);
$configDoctrine->setQueryCacheImpl($cache);
// Where to find Doctrine objects for my project
$driverImpl = $configDoctrine->newDefaultAnnotationDriver(APPLICATION_PATH . DIRECTORY_SEPARATOR .'models'. DIRECTORY_SEPARATOR .'Entity');
$configDoctrine->setMetadataDriverImpl($driverImpl);
// Where to generate proxy classes
$configDoctrine->setProxyDir(APPLICATION_PATH . DIRECTORY_SEPARATOR .'models' . DIRECTORY_SEPARATOR .'Proxy');
$configDoctrine->setProxyNamespace('Proxy');
$configDoctrine->setAutoGenerateProxyClasses(false);

require_once 'Zend/Config/Ini.php';
$config = new Zend_Config_Ini(APPLICATION_PATH . DIRECTORY_SEPARATOR .'configs'.DIRECTORY_SEPARATOR .'application.ini', APPLICATION_ENV);

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

// database access
$connectionOptions = array(
	'driver' => $config->resources->db->adapter,
	'host' => $config->resources->db->params->host,
	'dbname' => $config->resources->db->params->dbname,
	'user' => $config->resources->db->params->username,
	'password' => $config->resources->db->params->password,
	'type_db' => $config->resources->type_db,
	'type_orm' => $config->resources->type_orm
);

/**
 * 4. implement EntityManager 
 */

echo "\n  > La Database s'initialise";
SDIS62_Model_Mapper_Doctrine_Abstract::createEntityManager($connectionOptions, $configDoctrine);
