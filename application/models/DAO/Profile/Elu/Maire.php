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
	/**
	* Information about how the entity is stored in the database
	*
	* @var Array
	*/
	public static $infosMap = array(
		'classe' => 'Application_Model_Entity_Profile_Elu_Maire',
		'table' => 'profileselusmaires',
		'identifier' => array('primary'),
		'id_auto' => true,
		'colonnes' => array(
			array('fieldName' => 'primary', 'columnName' => 'id_profileelumaire', 'type' => 'integer'),
			array('fieldName' => 'city', 'columnName' => 'city', 'type' => 'string')
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
		if($mapper::exist('Elu_Maire', $proxy->getPrimary(), self::$infosMap))
		{
			return $mapper::update('Elu_Maire', $extract, self::$infosMap);
		}
		else
		{
			return $mapper::insert('Elu_Maire', $extract, self::$infosMap);
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
		$mapper::delete('Elu_Maire', $id, self::$infosMap);
	}
	
	/**
	* Ask the mapper to find a specified entity from database due to its primary key
	*
	* @params int $id
	* @return SDIS62_Model_Proxy_Abstract
	*/
	public function find($id)
	{
		$proxy = new Application_Model_Proxy_Elu_Maire;
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
		$proxy->getEntity()->hydrate($mapper::find('Elu_Maire', $proxy->getPrimary(), self::$infosMap));
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
		return new Application_Model_Proxy_Elu_Maire;
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
