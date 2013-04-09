<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DbTable_ProfilesPompiers
 */
 
  /**
 * DbTable class for profilespompiers table in database
 *
 * @category   Application
 * @package    Application_Model_DbTable_ProfilesPompiers
 */
class Application_Model_DbTable_ProfilesPompiers extends Zend_Db_Table_Abstract
{
    protected $_name = "profilespompiers";
    
    protected $_referenceMap    = array(
        'profile' => array(
            'columns'           => "id_profile",
            'refTableClass'     => "Application_Model_DbTable_Profiles",
            'refColumns'        => "id_profile"
        )
    );
}