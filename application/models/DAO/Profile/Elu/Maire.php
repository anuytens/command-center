<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DAO_Profile_Elu_Maire
 */

 /**
 * Abstract class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_DAO_Profile_Elu_Maire
 */
class Application_Model_DAO_Profile_Elu_Maire extends SDIS62_Model_DAO_Abstract implements SDIS62_Model_DAO_Interface
{
	public static $infosMap = array(
		'classe' => 'Application_Model_Entity_Elu_Maire',
		'table' => 'profileselusmaires',
		'identifier' => array('primary'),
		'colonnes' => array(
			array('fieldName' => 'primary', 'columnName' => 'id_profileelumaire', 'type' => 'integer'),
			array('fieldName' => 'city', 'columnName' => 'city', 'type' => 'string')/*,
			array('fieldName' => 'id_profileelu', 'columnName' => 'id_profileelu', 'type' => 'integer')*/
		)
	);
}
