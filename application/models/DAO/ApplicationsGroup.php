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
	
	/**
	* Extract an entity and ask the mapper to save informations in database
	*
	* @params SDIS62_Model_Proxy_Abstract $proxy
	*/
	public function save(SDIS62_Model_Proxy_Abstract $proxy)
	{
		$mapper = $this->getMapper();
		if($mapper::exist('ApplicationsGroup', $proxy->getPrimary()))
			$mapper::update('ApplicationsGroup', $proxy->getEntity()->extract());
		else
			$mapper::insert('ApplicationsGroup', $proxy->getEntity()->extract());
	}
	
	/**
	* Ask the mapper to delete a specified entity from database due to its primary key
	*
	* @params int $id
	*/
	public function delete($id)
	{
		$mapper = $this->getMapper();
		$mapper::delete('ApplicationsGroup', $id);
	}
	
	/**
	* Ask the mapper to find a specified entity from database due to its primary key
	*
	* @params int $id
	* @return SDIS62_Model_Proxy_Abstract
	*/
	public function find($id)
	{
		$proxy = new Application_Model_Proxy_ApplicationsGroup;
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
		$proxy->getEntity()->hydrate($mapper::find('ApplicationsGroup', $proxy->getPrimary()));
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
		$proxy = array();
		$mapper = $this->getMapper();
		if($type === 'Application')
		{
			$res = $mapper::findAllByCriteria(
				'Application',
				array(
					'JOIN' => array(
						array(
							'tables' => array('Application', 'ApplicationsgroupsApplications'),
							'colonnes' => array('id_application', 'id_application')
						),
						array(
							'tables' => array('ApplicationsgroupsApplications', 'ApplicationGroup'),
							'colonnes' => array('id_applicationsgroup', 'id_applicationsgroup')
						)
					),
					'WHERE' => array(
						array(
							'table' => 'ApplicationGroup',
							'colonne' => 'id_applicationsgroup',
							'valeur' => $id
						)
					)
				),
				array(
					'ApplicationGroup' => 'ag',
					'ApplicationsgroupsApplications' => 'aga',
					'Application' => 'a'
				)
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
