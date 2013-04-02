<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Business_Application
 */

 /**
 * Class for application instance.
 *
 * @category   Application
 * @package    Application_Model_Business_Application
 */
class Application_Model_Business_Application
{
    /**
     * Name of the application
     *
     * @var string
     */
    private $name;

    /**
     * URL of the application
     *
     * @var string
     */
    private $url;
    
    /**
     * Get the application's name.
     *
     * @return string
     */      
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the application's name
     *
     * @param  string $name
     * @return Application_Model_Business_Application Provides fluent interface
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Get the URL.
     *
     * @return string
     */      
    public function getURL()
    {
        return $this->url;
    }

    /**
     * Set the URL
     *
     * @param  string $url
     * @return Application_Model_Business_Application Provides fluent interface
     */
    public function setURL($url)
    {
        $this->url = $url;
        return $this;
    }
}