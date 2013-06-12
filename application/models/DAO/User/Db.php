<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DAO_User_Db
 */

 /**
 * Class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_DAO_User_Db
 */
class Application_Model_DAO_User_Db extends SDIS62_Model_DAO_Abstract implements SDIS62_Model_DAO_Interface
{
	public static $infosMap = array(
		'classe' => 'Application_Model_Entity_User_Db',
		'table' => 'usersdb',
		'identifier' => array('primary'),
		'colonnes' => array(
			array('fieldName' => 'primary', 'columnName' => 'id_userdb', 'type' => 'integer'),
			array('fieldName' => 'password', 'columnName' => 'password', 'type' => 'string')/*,
			array('fieldName' => 'id_user', 'columnName' => 'id_user', 'type' => 'integer')*/
		)
	);
}
