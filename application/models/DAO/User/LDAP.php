<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DAO_User_LDAP
 */

 /**
 * Class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_DAO_User_LDAP
 */
class Application_Model_DAO_User_LDAP extends SDIS62_Model_DAO_Abstract implements SDIS62_Model_DAO_Interface
{
	public static $infosMap = array(
		'classe' => 'Application_Model_Entity_User_LDAP',
		'table' => 'usersldap',
		'identifier' => array('primary'),
		'colonnes' => array(
			array('fieldName' => 'primary', 'columnName' => 'id_usersLDAP', 'type' => 'integer'),
			array('fieldName' => 'objectid', 'columnName' => 'objectid', 'type' => 'boolean'),
			array('fieldName' => 'dn', 'columnName' => 'dn', 'type' => 'string')/*,
			array('fieldName' => 'id_user', 'columnName' => 'id_user', 'type' => 'integer')*/
		)
	);
}
