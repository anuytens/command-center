<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DAO_Profile_Pompier
 */

 /**
 * Abstract class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_DAO_Profile_Pompier
 */
class Application_Model_DAO_Profile_Pompier extends SDIS62_Model_DAO_Abstract implements SDIS62_Model_DAO_Interface
{
	public static $infosMap = array(
		'classe' => 'Application_Model_Entity_Pompier',
		'table' => 'profilespompiers',
		'identifier' => array('primary'),
		'colonnes' => array(
			array('fieldName' => 'primary', 'columnName' => 'id_profilepompier', 'type' => 'integer'),
			array('fieldName' => 'grade', 'columnName' => 'grade', 'type' => 'string')/*,
			array('fieldName' => 'id_profile', 'columnName' => 'id_profile', 'type' => 'integer')*/
		)
	);
}
