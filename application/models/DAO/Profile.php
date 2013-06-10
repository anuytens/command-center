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
		'classe' => 'Application_Model_Entity_Objet',
		'table' => 'objet',
		'identifier' => array('primary'),
		'colonnes' => array(
			array('fieldName' => 'primary', 'columnName' => 'id', 'type' => 'integer'),
			array('fieldName' => 'label', 'columnName' => 'label', 'type' => 'string'),
			array('fieldName' => 'idPersonne', 'columnName' => 'idPersonne', 'type' => 'integer', 'targetEntity' => 'Application_Model_Entity_Personne', 'mappingType' => 'ManyToOne')
		)
	);
}
