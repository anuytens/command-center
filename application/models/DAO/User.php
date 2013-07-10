<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DAO_User
 */

 /**
 * class for user instance.
 *
 * @category   Application
 * @package    Application_Model_DAO_User
 */
class Application_Model_DAO_User extends SDIS62_Model_DAO_Abstract implements SDIS62_Model_DAO_Interface
{
	/**
	* Information about how the entity is stored in the database
	*
	* @var Array
	*/
	public static $infosMap = array(
		'classe' => 'Application_Model_Entity_User',
		'table' => 'users',
		'identifier' => array('primary'),
		'id_auto' => true,
		'colonnes' => array(
			array('fieldName' => 'primary', 'columnName' => 'id_user', 'type' => 'integer'),
			array('fieldName' => 'is_active', 'columnName' => 'is_active', 'type' => 'boolean'),
			array('fieldName' => 'role', 'columnName' => 'role', 'type' => 'integer'),
		),
		'join' => array(
			'fieldName' => 'usersgroups-users',
			'joinColumns' => array('name' => 'id_user', 'referencedColumnName' => 'id_user'),
			'inverseJoinColumns' => array('name' => 'id_usersgroup', 'referencedColumnName' => 'id_usersgroup'),
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
		if($mapper::exist('User', $proxy->getPrimary(), self::$infosMap))
		{
			return $mapper::update('User', $extract, self::$infosMap);
		}
		else
		{
			return $mapper::insert('User', $extract, self::$infosMap);
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
		$mapper::delete('User', $id, self::$infosMap);
	}
	
	/**
	* Ask the mapper to find a specified entity from database due to its primary key
	*
	* @params int $id
	* @return SDIS62_Model_Proxy_Abstract
	*/
	public function find($id)
	{
		$proxy = new Application_Model_Proxy_User;
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
		$proxy->getEntity()->hydrate($mapper::find('User', $proxy->getPrimary(), self::$infosMap));
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
		$proxy = new Application_Model_Proxy_Profile;
		$mapper = $this->getMapper();
		if($type === 'Profile')
		{
			$p->getEntity()->hydrate(
				$mapper::findByCriteria(
					'Profile',
					array(
						'JOIN' => array(
							array(
								'tables' => array('Profile', 'User_Db'),
								'colonnes' => array('id_profile', 'id_profile')
							),
							array(
								'tables' => array('User_Db', 'User'),
								'colonnes' => array('id_userdb', 'id_userdb')
							)
						),
						'WHERE' => array(
							array(
								'table' => 'User',
								'colonne' => 'id_user',
								'valeur' => $id
							)
						)
					),
					array(
						'User' => 'u',
						'User_Db' => 'udb',
						'Profile' => 'p'
					),
					self::$infosMap
				)
			);
		}
		return $proxy;
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
		$proxy = array();
		$mapper = $this->getMapper();
		if($type === 'Application')
		{
			$res = $mapper::findAllByCriteria(
				'Application',
				array(
					'JOIN' => array(
						array(
							'tables' => array('Application', 'UserApplications'),
							'colonnes' => array('id_application', 'id_application')
						),
						array(
							'tables' => array('UserApplications', 'User'),
							'colonnes' => array('id_user', 'id_user')
						)
					),
					'WHERE' => array(
						array(
							'table' => 'User',
							'colonne' => 'id_user',
							'valeur' => $id
						)
					)
				),
				array(
					'User' => 'u',
					'UserApplications' => 'ua',
					'Application' => 'a'
				),
				self::$infosMap
			);
		}
		foreach($res as $a)
		{
			$p = new Application_Model_Proxy_Application;
			$p->getEntity()->hydrate($a);
			array_push($proxy, $p);
		}
		return $proxy;
	}
}
