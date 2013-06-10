<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DbTable_UsersGroupsUsers
 */
 
  /**
 * DbTable class for usersgroups-users table in database
 *
 * @category   Application
 * @package    Application_Model_DbTable_UsersGroupsUsers
 */
class Application_Model_DbTable_UsersGroupsUsers extends Zend_Db_Table_Abstract
{
    protected $_name = "usersgroups-users";
    
    protected $_referenceMap    = array(
        'group' => array(
            'columns'           => "id_usersgroup",
            'refTableClass'     => "Application_Model_DbTable_UsersGroups",
            'refColumns'        => "id_usersgroup"
        ),
        'user' => array(
            'columns'           => "id_user",
            'refTableClass'     => "Application_Model_DbTable_Users",
            'refColumns'        => "id_user"
        )
    );
}