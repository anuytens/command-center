<?php

class Application_Model_UsersEvents extends Zend_Db_Table_Abstract
{
	protected $_name = "users-events";
	protected $_referenceMap = array(
		'users' => array(
			'columns' => 'id_user',
			'refTableClass' => 'Application_Model_Users'
			),
		'tag' => array(
			'columns' => 'id_event',
			'refTableClass' => 'Application_Model_Events'
			)
	);


}

