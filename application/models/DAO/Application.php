<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DAO_Application
 */

 /**
 * Class for application instance.
 *
 * @category   Application
 * @package    Application_Model_DAO_Application
 */
class Application_Model_DAO_Application extends SDIS62_Model_DAO_Abstract implements SDIS62_Model_DAO_Interface
{
	/**
	* Information about how the entity is stored in the database
	*
	* @var Array
	*/
	public static $infosMap = array(
		'classe' => 'Application_Model_Entity_Application',
		'table' => 'applications',
		'identifier' => array('primary'),
		'id_auto' => true,
		'colonnes' => array(
			array('fieldName' => 'primary', 'columnName' => 'id_application', 'type' => 'integer'),
			array('fieldName' => 'name', 'columnName' => 'name', 'type' => 'string'),
			array('fieldName' => 'url', 'columnName' => 'url', 'type' => 'string'),
			array('fieldName' => 'consumer_secret', 'columnName' => 'consumer_secret', 'type' => 'string'),
			array('fieldName' => 'consumer_key', 'columnName' => 'consumer_key', 'type' => 'string'),
			array('fieldName' => 'is_active', 'columnName' => 'is_active', 'type' => 'string')
		),
		'join' => array(
			'fieldName' => 'applicationsgroups-applications',
			'joinColumns' => array('name' => 'id_application', 'referencedColumnName' => 'id_application'),
			'inverseJoinColumns' => array('name' => 'id_applicationsgroup', 'referencedColumnName' => 'id_applicationsgroup'),
			'isCascadePersist' => true
		)
	);
	
	/**
	* Extract an entity and ask the mapper to save informations in database and get the primary key
	*
	* @params SDIS62_Model_Proxy_Abstract $proxy
	* @return int
	*/
	public function save(SDIS62_Model_Proxy_Abstract $proxy)
	{
		$mapper = $this->getMapper();
		$extract = $proxy->getEntity()->extract();
		if($mapper::exist('Application', $proxy->getPrimary(), self::$infosMap))
		{
			return $mapper::update('Application', $extract, self::$infosMap);
		}
		else
		{
			return $mapper::insert('Application', $extract, self::$infosMap);
		}
	}
	
	/**
	* Ask the mapper to delete a specified entity from database due to its primary key
	*
	* @params int $id
	*/
	public function delete($id)
	{
		$mapper = $this->getMapper();
		$mapper::delete('Application', $id, self::$infosMap);
	}
	
	/**
	* Ask the mapper to find a specified entity from database due to its primary key
	*
	* @params int $id
	* @return SDIS62_Model_Proxy_Abstract
	*/
	public function find($id)
	{
		$proxy = new Application_Model_Proxy_Application;
		$proxy->setPrimary($id);
		$this->create($proxy, self::$infosMap);
		return $proxy;
	}
	
	/**
	* Ask the mapper to find a specified entity from database due to a proxy and add it into that proxy
	*
	* @params SDIS62_Model_Proxy_Abstract $proxy
	*/
	public function create(SDIS62_Model_Proxy_Abstract $proxy)
	{
		$mapper = $this->getMapper();
		$proxy->getEntity()->hydrate($mapper::find('Application', $proxy->getPrimary(), self::$infosMap));
	}
	
	/**
	* Ask the mapper to find a specified entity from database due to a foreign key
	*
	* @params string $type
	* @params int $id
	* @return SDIS62_Model_Proxy_Abstract
	*/
	public function findByCriteria($type, $id)
	{
		return new Application_Model_Proxy_Application;
	}
	
	/**
	* Ask the mapper to find several entities from database due to a foreign key
	*
	* @params string $type
	* @params int $id
	* @return SDIS62_Model_Proxy_Abstract[]
	*/
	public function findAllByCriteria($type, $id)
	{
		return array();
	}
}
