<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_Application_Interface
 */

 /**
 * Interface for application instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_Application_Interface
 */
interface Application_Model_Entity_Application_Interface
{
    /**
     * Get the application's name.
     *
     * @return string
     */      
    public function getName();

    /**
     * Set the application's name
     *
     * @param  string $name
     * @return Application_Model_Entity_Application_Interface Provides fluent interface
     */
    public function setName($name);
    
    /**
     * Get the consumer secret
     *
     * @return string
     */      
    public function getConsumerSecret();

    /**
     * Set the consumer secret
     *
     * @param  string $consumer_secret
     * @return Application_Model_Entity_Application_Interface Provides fluent interface
     */
    public function setConsumerSecret($consumer_secret);
    
    /**
     * Get the consumer key
     *
     * @return string
     */      
    public function getConsumerKey();

    /**
     * Set the consumer key
     *
     * @param  string $consumer_key
     * @return Application_Model_Entity_Application_Interface Provides fluent interface
     */
    public function setConsumerKey($consumer_key);
    
    /**
     * Get application status
     *
     * @return bool
     */      
    public function isActive();

    /**
     * Set the application's status
     *
     * @param  bool $status
     * @return Application_Model_Entity_Application_Interface Provides fluent interface
     */
    public function setActiveStatus($status);
    
    /**
     * Get the URL.
     *
     * @return string
     */      
    public function getURL();

    /**
     * Set the URL
     *
     * @param  string $url
     * @return Application_Model_Entity_Application_Interface Provides fluent interface
     */
    public function setURL($url);
    
    /**
     * Return true if the application is available
     *
     @return bool
    */
    public function isAvailable();
    
    /**
     * Check if the application is extern
     *
     @return bool
    */
    public function isExtern();
    
    /**
     * Check if the application is in SDIS but legacy
     *
     @return bool
    */
    public function isLegacy();
    
    /**
     * Check if the application is in ecosystem
     *
     @return bool
    */
    public function isEcosystem();
}
