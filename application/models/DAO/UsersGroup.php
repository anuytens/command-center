<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DAO_UsersGroup
 */

 /**
 * Class for users group instance.
 *
 * @category   Application
 * @package    Application_Model_DAO_UsersGroup
 */
class Application_Model_DAO_UsersGroup extends SDIS62_Model_DAO_Abstract implements SDIS62_Model_DAO_Interface
{
	public static $infosMap = array(
		'classe' => 'Application_Model_Entity_UsersGroup',
		'table' => 'usersgroups',
		'identifier' => array('primary'),
		'colonnes' => array(
			array('fieldName' => 'primary', 'columnName' => 'id_usersgroup', 'type' => 'integer'),
			array('fieldName' => 'name', 'columnName' => 'name', 'type' => 'string'),
			array('fieldName' => 'description', 'columnName' => 'description', 'type' => 'string'),
			array('fieldName' => 'role', 'columnName' => 'role', 'type' => 'integer')
		)
	);
}
