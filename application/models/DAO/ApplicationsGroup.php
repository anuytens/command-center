<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DAO_ApplicationsGroup
 */

 /**
 * Class for application group instance.
 *
 * @category   Application
 * @package    Application_Model_DAO_ApplicationsGroup
 */
class Application_Model_DAO_ApplicationsGroup extends SDIS62_Model_DAO_Abstract implements SDIS62_Model_DAO_Interface
{
	public static $infosMap = array(
		'classe' => 'Application_Model_Entity_ApplicationsGroup',
		'table' => 'applicationsgroups',
		'identifier' => array('primary'),
		'colonnes' => array(
			array('fieldName' => 'primary', 'columnName' => 'id_applicationsgroup', 'type' => 'integer'),
			array('fieldName' => 'name', 'columnName' => 'name', 'type' => 'string'),
			array('fieldName' => 'color', 'columnName' => 'color', 'type' => 'string'),
		)
	);
}
