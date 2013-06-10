<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DbTable_ApplicationsGroupsApplications
 */
 
  /**
 * DbTable class for applications-applicationgroups table in database
 *
 * @category   Application
 * @package    Application_Model_DbTable_ApplicationsGroupsApplications
 */
class Application_Model_DbTable_ApplicationsGroupsApplications extends Zend_Db_Table_Abstract
{
    protected $_name = "applicationsgroups-applications";
    
    protected $_referenceMap    = array(
        'group' => array(
            'columns'           => "id_applicationsgroup",
            'refTableClass'     => "Application_Model_DbTable_ApplicationsGroups",
            'refColumns'        => "id_applicationsgroup"
        ),
        'application' => array(
            'columns'           => "id_application",
            'refTableClass'     => "Application_Model_DbTable_Applications",
            'refColumns'        => "id_application"
        )
    );
}