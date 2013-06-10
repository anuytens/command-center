<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DbTable_ProfilesElus
 */
 
  /**
 * DbTable class for profileselus table in database
 *
 * @category   Application
 * @package    Application_Model_DbTable_ProfilesElus
 */
class Application_Model_DbTable_ProfilesElus extends Zend_Db_Table_Abstract
{
    protected $_name = "profileselus";
    
    protected $_dependentTables = array(
        "Application_Model_DbTable_ProfilesElusMaires",
        "Application_Model_DbTable_ProfilesElusPrefets"
    );
    
    protected $_referenceMap    = array(
        'profile' => array(
            'columns'           => "id_profile",
            'refTableClass'     => "Application_Model_DbTable_Profiles",
            'refColumns'        => "id_profile"
        )
    );
}