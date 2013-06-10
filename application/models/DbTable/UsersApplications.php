<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DbTable_UsersApplications
 */
 
  /**
 * DbTable class for users-applications table in database
 *
 * @category   Application
 * @package    Application_Model_DbTable_UsersApplications
 */
class Application_Model_DbTable_UsersApplications extends Zend_Db_Table_Abstract
{
    protected $_name = "users-applications";
    
    protected $_referenceMap    = array(
        'user' => array(
            'columns'           => "id_user",
            'refTableClass'     => "Application_Model_DbTable_Users",
            'refColumns'        => "id_user"
        ),
        'application' => array(
            'columns'           => "id_application",
            'refTableClass'     => "Application_Model_DbTable_Applications",
            'refColumns'        => "id_application"
        )
    );
}