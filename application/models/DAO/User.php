<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DAO_User
 */

 /**
 * class for user instance.
 *
 * @category   Application
 * @package    Application_Model_DAO_User
 */
class Application_Model_DAO_User extends SDIS62_Model_DAO_Abstract implements SDIS62_Model_DAO_Interface
{
	public static $infosMap = array(
		'classe' => 'Application_Model_Entity_User',
		'table' => 'users',
		'identifier' => array('primary'),
		'colonnes' => array(
			array('fieldName' => 'primary', 'columnName' => 'id_user', 'type' => 'integer'),
			array('fieldName' => 'is_active', 'columnName' => 'is_active', 'type' => 'boolean'),
			array('fieldName' => 'role', 'columnName' => 'role', 'type' => 'integer'),
		)
	);
}
