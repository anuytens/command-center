<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DbTable_UsersLDAP
 */
 
  /**
 * DbTable class for usersdb table in database
 *
 * @category   Application
 * @package    Application_Model_DbTable_UsersLDAP
 */
class Application_Model_DbTable_UsersLDAP extends Zend_Db_Table_Abstract
{
    protected $_name = "usersLDAP";
    
    protected $_referenceMap    = array(
        'user' => array(
            'columns'           => "id_user",
            'refTableClass'     => "Application_Model_DbTable_Users",
            'refColumns'        => "id_user"
        )
    );
}