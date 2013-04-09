<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DbTable_UsersDb
 */
 
  /**
 * DbTable class for usersdb table in database
 *
 * @category   Application
 * @package    Application_Model_DbTable_UsersDb
 */
class Application_Model_DbTable_UsersDb extends Zend_Db_Table_Abstract
{
    protected $_name = "usersdb";
    
    protected $_dependentTables = array(
        "Application_Model_DbTable_Profiles"
    );
    
    protected $_referenceMap    = array(
        'user' => array(
            'columns'           => "id_user",
            'refTableClass'     => "Application_Model_DbTable_Users",
            'refColumns'        => "id_user"
        )
    );
}