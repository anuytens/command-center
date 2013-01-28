<?php

class Application_Model_Users extends Zend_Db_Table_Abstract
{
	protected $_name = "users";
	protected $_dependentTables = array("Application_Model_UsersEvents", "Api_Model_Tokens");
}