<?php

class Application_Model_Events extends Zend_Db_Table_Abstract
{
	protected $_name = "events";
	protected $_dependentTables = array("Application_Model_UsersEvents");
}

