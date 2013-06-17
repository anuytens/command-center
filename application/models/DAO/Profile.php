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
	/**
	* Information about how the entity is stored in the database
	*
	* @var Array
	*/
	public static $infosMap = array(
		'classe' => 'Application_Model_Entity_Profile',
		'table' => 'profiles',
		'identifier' => array('primary'),
		'colonnes' => array(
			array('fieldName' => 'primary', 'columnName' => 'id_profile', 'type' => 'integer'),
			array('fieldName' => 'first_name', 'columnName' => 'first_name', 'type' => 'string'),
			array('fieldName' => 'last_name', 'columnName' => 'last_name', 'type' => 'string'),
			array('fieldName' => 'is_man', 'columnName' => 'gender', 'type' => 'boolean'),
			array('fieldName' => 'phone', 'columnName' => 'phone', 'type' => 'string'),
			array('fieldName' => 'address', 'columnName' => 'address', 'type' => 'string'),
			array('fieldName' => 'email', 'columnName' => 'email', 'type' => 'string'),
			array('fieldName' => 'id_userdb', 'columnName' => 'id_userdb', 'type' => 'integer')
		)
	);
	
	/**
	* Extract an entity and ask the mapper to save informations in database
	*
	* @params SDIS62_Model_Proxy_Abstract $proxy
	*/
	public function save(SDIS62_Model_Proxy_Abstract $proxy)
	{
		$mapper = $this->getMapper();
		$extract = $proxy->getEntity()->extract();
		if($mapper::exist('Profile', $proxy->getPrimary(), self::$infosMap))
		{
			$mapper::update('Profile', $extract, self::$infosMap);
		}
		else
		{
			$id = $mapper::insert('Profile', $extract, self::$infosMap);
			if($proxy->getPrimary() === null)
			{
				$proxy->setPrimary($id);
			}
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
		$mapper::delete('Profile', $id, self::$infosMap);
	}
	
	/**
	* Ask the mapper to find a specified entity from database due to its primary key
	*
	* @params int $id
	* @return SDIS62_Model_Proxy_Abstract
	*/
	public function find($id)
	{
		$proxy = new Application_Model_Proxy_Profile;
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
		$proxy->getEntity()->hydrate($mapper::find('Profile', $proxy->getPrimary(), self::$infosMap));
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
		return new Application_Model_Proxy_Profile;
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
