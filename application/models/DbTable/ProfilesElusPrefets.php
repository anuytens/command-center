<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DbTable_ProfilesElusPrefets
 */
 
  /**
 * DbTable class for profileselusprefets table in database
 *
 * @category   Application
 * @package    Application_Model_DbTable_ProfilesElusPrefets
 */
class Application_Model_DbTable_ProfilesElusPrefets extends Zend_Db_Table_Abstract
{
    protected $_name = "profileselusprefets";
    
    protected $_referenceMap    = array(
        'profile' => array(
            'columns'           => "id_profileelu",
            'refTableClass'     => "Application_Model_DbTable_ProfilesElus",
            'refColumns'        => "id_profileelu"
        )
    );
}