<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DAO_Profile_Elu_Prefet
 */

 /**
 * Abstract class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_DAO_Profile_Elu_Prefet
 */
class Application_Model_DAO_Profile_Elu_Prefet extends SDIS62_Model_DAO_Abstract implements SDIS62_Model_DAO_Interface
{
	public static $infosMap = array(
		'classe' => 'Application_Model_Entity_Elu_Prefet',
		'table' => 'profileselusprefets',
		'identifier' => array('primary'),
		'colonnes' => array(
			array('fieldName' => 'primary', 'columnName' => 'id_profileeluprefet', 'type' => 'integer'),
			array('fieldName' => 'department', 'columnName' => 'department', 'type' => 'string')/*,
			array('fieldName' => 'id_profileelu', 'columnName' => 'id_profileelu', 'type' => 'integer')*/
		)
	);
}
