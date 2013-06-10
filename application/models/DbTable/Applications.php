<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DbTable_Applications
 */
 
  /**
 * DbTable class for applications table in database
 *
 * @category   Application
 * @package    Application_Model_DbTable_Applications
 */
class Application_Model_DbTable_Applications extends Zend_Db_Table_Abstract
{
    protected $_name = "applications";
    
    protected $_dependentTables = array(
        "Application_Model_DbTable_UsersApplications",
        "Application_Model_DbTable_ApplicationsGroupsApplications"
    );
}