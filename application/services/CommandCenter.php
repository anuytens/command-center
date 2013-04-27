<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Service_CommandCenter
 */

 /**
 * Service layer for Command Center
 *
 * @category   Application
 * @package    Application_Service_CommandCenter
 */
class Application_Service_CommandCenter
{
    /**
     * CommandCenter instance
     *
     * @var Application_Service_CommandCenter
     *
     */
    private static $_instance = null;
    
    /**
     * CommandCenter's cache instance
     *
     * @var Zend_Cache_Core
     *
     */
    private $_cache = null;

     /**
     * No constructor
     * 
     */      
    protected function __construct() {}
    
     /**
     * No clones
     * 
     */      
    protected function __clone() {}

    /**
     * Get cache
     *
     * @return Zend_Cache
     * 
     */        
    public function getCache()
    {
        return $this->_cache;
    }

    /**
     * Set cache
     *
     * @param Zend_Cache $cache
     * @return Application_Model_Mapper_DbTableAbstract Provides fluent interface
     * 
     */        
    public function setCache(Zend_Cache_Core $cache)
    {
        $this->_cache = $cache;
    }

    /**
     * Singleton
     *
     * @return Application_Service_CommandCenter
     * 
     */    
    public static function getInstance()
    {
        if (!isset(static::$_instance)) 
        {
            // Build the service
            static::$_instance = new static;
            
            // Set the cache
            static::$_instance->setCache(Zend_Cache::factory('Core','APC'));
        }
        
        return static::$_instance;
    }
    
    /**
     * CRUD Method for user
     *
     * @param string $operation Operation muste be "create", "read", "update", or "delete".
     * @param Application_Model_User $user Must be passed by reference. The method update the $user variable.
     * @param array $params optionals variables
     * @return bool
     * 
     */        
    public function crudUser($operation, Application_Model_User $user, $params = array())
    {
    }
    
    public function getUserForm(Application_Model_User $user = null)
    {
    }
}