<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DAO_Application
 */

 /**
 * Class for application instance.
 *
 * @category   Application
 * @package    Application_Model_DAO_Application
 */
class Application_Model_DAO_Application extends SDIS62_Model_DAO_Abstract implements SDIS62_Model_DAO_Interface
{
	public static $infosMap = array(
		'classe' => 'Application_Model_Entity_Application',
		'table' => 'applications',
		'identifier' => array('primary'),
		'colonnes' => array(
			array('fieldName' => 'primary', 'columnName' => 'id_application', 'type' => 'integer'),
			array('fieldName' => 'name', 'columnName' => 'name', 'type' => 'string'),
			array('fieldName' => 'url', 'columnName' => 'url', 'type' => 'string'),
			array('fieldName' => 'consumer_secret', 'columnName' => 'consumer_secret', 'type' => 'string'),
			array('fieldName' => 'consumer_key', 'columnName' => 'consumer_key', 'type' => 'string'),
			array('fieldName' => 'is_active', 'columnName' => 'is_active', 'type' => 'string')
		)
	);
}
