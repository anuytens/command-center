<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Mapper_DbTableAbstract
 */

 /**
 * Abstract class for mappers wich related to a db table object.
 *
 * @category   Application
 * @package    Application_Model_Mapper_DbTableAbstract
 * @abstract
 */
abstract class Application_Model_Mapper_DbTableAbstract
{
    /**
     * DbTable class name
     *
     * @var Zend_Db_Table_Abstract
     */
     protected $db_table;
    
     /**
     * Get the Db Table
     *
     * @return Zend_Db_Table_Abstract
     */      
    public function getDbTable()
    {
        return $this->db_table;
    }

    /**
     * Set the Db Table object
     *
     * @param  string $db_table_class_name
     * @return Application_Model_Mapper_DbTableAbstract Provides fluent interface
     */
    public function setDbTable($db_table_class_name)
    {
        if (is_string($db_table_class_name))
        {
            $db_table = new $db_table_class_name;
            
             if (!$db_table instanceof Zend_Db_Table_Abstract)
            {
                throw new Exception('Invalid table data gateway provided');
            }
            
            $this->db_table = $db_table;
        }
        
        return $this;
    }
}