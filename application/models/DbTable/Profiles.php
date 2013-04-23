<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DbTable_Profiles
 */
 
  /**
 * DbTable class for profiles table in database
 *
 * @category   Application
 * @package    Application_Model_DbTable_Profiles
 */
class Application_Model_DbTable_Profiles extends Zend_Db_Table_Abstract
{
    protected $_name = "profiles";
    
    protected $_dependentTables = array(
        "Application_Model_DbTable_ProfilesElus",
        "Application_Model_DbTable_ProfilesPompiers"
    );
    
    protected $_referenceMap    = array(
        'userdb' => array(
            'columns'           => "id_userdb",
            'refTableClass'     => "Application_Model_DbTable_UsersDb",
            'refColumns'        => "id_userdb"
        )
    );
}