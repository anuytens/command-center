<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DAO_Profile
 */

 /**
 * Class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_DAO_Profile
 */
class Application_Model_DAO_Profile extends SDIS62_Model_DAO_Abstract implements SDIS62_Model_DAO_Interface
{
	public static $infosMap = array(
		'classe' => 'Application_Model_Entity_Profile',
		'table' => 'profiles',
		'identifier' => array('primary'),
		'colonnes' => array(
			array('fieldName' => 'primary', 'columnName' => 'id_profile', 'type' => 'integer'),
			array('fieldName' => 'first_name', 'columnName' => 'first_name', 'type' => 'string'),
			array('fieldName' => 'last_name', 'columnName' => 'last_name', 'type' => 'string'),
			array('fieldName' => 'is_man', 'columnName' => 'gender', 'type' => 'boolean'),
			array('fieldName' => 'phone', 'columnName' => 'phone', 'type' => 'string'),
			array('fieldName' => 'address', 'columnName' => 'address', 'type' => 'string'),
			array('fieldName' => 'email', 'columnName' => 'email', 'type' => 'string')/*,
			array('fieldName' => 'id_userdb', 'columnName' => 'id_userdb', 'type' => 'integer')*/
		)
	);
}
