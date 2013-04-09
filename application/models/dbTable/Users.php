<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DbTable_Users
 */
 
  /**
 * DbTable class for users table in database
 *
 * @category   Application
 * @package    Application_Model_DbTable_Users
 */
class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{
    protected $_name = "users";
    
    protected $_dependentTables = array(
        "Application_Model_DbTable_UsersDb",
        "Application_Model_DbTable_UsersLDAP"
    );
}