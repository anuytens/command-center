<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_DbTable_ProfilesElusMaires
 */
 
  /**
 * DbTable class for profileselusmaires table in database
 *
 * @category   Application
 * @package    Application_Model_DbTable_ProfilesElusMaires
 */
class Application_Model_DbTable_ProfilesElusMaires extends Zend_Db_Table_Abstract
{
    protected $_name = "profileselusmaires";
    
    protected $_referenceMap    = array(
        'profile' => array(
            'columns'           => "id_profileelu",
            'refTableClass'     => "Application_Model_DbTable_ProfilesElus",
            'refColumns'        => "id_profileelu"
        )
    );
}