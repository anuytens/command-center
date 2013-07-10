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
	/**
	* Information about how the entity is stored in the database
	*
	* @var Array
	*/
	public static $infosMap = array(
		'classe' => 'Application_Model_Entity_User_Db',
		'table' => 'usersdb',
		'identifier' => array('primary'),
		'id_auto' => true,
		'colonnes' => array(
			array('fieldName' => 'primary', 'columnName' => 'id_userdb', 'type' => 'integer'),
			array('fieldName' => 'password', 'columnName' => 'password', 'type' => 'string')
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
		if($mapper::exist('User_Db', $proxy->getPrimary(), self::$infosMap))
		{
			return $mapper::update('User_Db', $extract, self::$infosMap);
		}
		else
		{
			return $mapper::insert('User_Db', $extract, self::$infosMap);
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
		$mapper::delete('User_Db', $id, self::$infosMap);
	}
	
	/**
	* Ask the mapper to find a specified entity from database due to its primary key
	*
	* @params int $id
	* @return SDIS62_Model_Proxy_Abstract
	*/
	public function find($id)
	{
		$proxy = new Application_Model_Proxy_User_Db;
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
		$proxy->getEntity()->hydrate($mapper::find('User_Db', $proxy->getPrimary(), self::$infosMap));
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
		return new Application_Model_Proxy_User_Db;
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
