<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DAO_Profile_Elu
 */

 /**
 * Abstract class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_DAO_Profile_Elu
 */
abstract class Application_Model_DAO_Profile_Elu extends SDIS62_Model_DAO_Abstract implements SDIS62_Model_DAO_Interface
{
	public static $infosMap = array(
		'classe' => 'Application_Model_Entity_Profile_Elu',
		'table' => 'profileselus',
		'identifier' => array('primary'),
		'colonnes' => array(
			array('fieldName' => 'primary', 'columnName' => 'id_profileelu', 'type' => 'integer')/*,
			array('fieldName' => 'id_profile', 'columnName' => 'id_profile', 'type' => 'integer')*/
		)
	);
}
