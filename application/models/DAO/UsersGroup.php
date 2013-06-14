<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DAO_UsersGroup
 */

 /**
 * Class for users group instance.
 *
 * @category   Application
 * @package    Application_Model_DAO_UsersGroup
 */
class Application_Model_DAO_UsersGroup extends SDIS62_Model_DAO_Abstract implements SDIS62_Model_DAO_Interface
{
	public static $infosMap = array(
		'classe' => 'Application_Model_Entity_UsersGroup',
		'table' => 'usersgroups',
		'identifier' => array('primary'),
		'colonnes' => array(
			array('fieldName' => 'primary', 'columnName' => 'id_usersgroup', 'type' => 'integer'),
			array('fieldName' => 'name', 'columnName' => 'name', 'type' => 'string'),
			array('fieldName' => 'description', 'columnName' => 'description', 'type' => 'string'),
			array('fieldName' => 'role', 'columnName' => 'role', 'type' => 'integer')
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
		if($mapper::exist('UsersGroup', $proxy->getPrimary()))
			$mapper::update('UsersGroup', $proxy->getEntity()->extract());
		else
			$mapper::insert('UsersGroup', $proxy->getEntity()->extract());
	}
	
	/**
	* Ask the mapper to delete a specified entity from database due to its primary key
	*
	* @params int $id
	*/
	public function delete($id)
	{
		$mapper = $this->getMapper();
		$mapper::delete('UsersGroup', $id);
	}
	
	/**
	* Ask the mapper to find a specified entity from database due to its primary key
	*
	* @params int $id
	* @return SDIS62_Model_Proxy_Abstract
	*/
	public function find($id)
	{
		$proxy = new Application_Model_Proxy_UsersGroup;
		$proxy->setPrimary($id);
		$this->create($proxy);
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
		$proxy->getEntity()->hydrate($mapper::find('UsersGroup', $proxy->getPrimary()));
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
		return new Application_Model_Proxy_User;
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
		if($type === 'User')
		{
			$res = $mapper::findAllByCriteria(
				'User',
				array(
					'JOIN' => array(
						array(
							'tables' => array('User', 'UsersgroupsUsers'),
							'colonnes' => array('id_user', 'id_user')
						),
						array(
							'tables' => array('UsersgroupsUsers', 'UsersGroup'),
							'colonnes' => array('id_usersgroup', 'id_usersgroup')
						)
					),
					'WHERE' => array(
						array(
							'table' => 'UsersGroup',
							'colonne' => 'id_usersgroup',
							'valeur' => $id
						)
					)
				),
				array(
					'UsersGroup' => 'ug',
					'UsersgroupsUsers' => 'ugu',
					'User' => 'u'
				)
			);
		}
		foreach($res as $a)
		{
			$p = new Application_Model_Proxy_User;
			$p->getEntity()->hydrate($a);
			array_push($proxy, $p);
		}
		return $proxy;
	}
}
