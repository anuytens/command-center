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
class Application_Model_Business_Application extends Application_Model_Business_Abstract
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
     * Consumer secret (for oauth)
     *
     * @var string
     */
    private $consumer_secret;

    /**
     * Consumer key (for oauth)
     *
     * @var string
     */
    private $consumer_key;
    
    /**
     * Application status
     *
     * @var bool
     */
    private $is_active;
    
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
     * Get the consumer secret
     *
     * @return string
     */      
    public function getConsumerSecret()
    {
        return $this->consumer_secret;
    }

    /**
     * Set the consumer secret
     *
     * @param  string $consumer_secret
     * @return Application_Model_Business_Application Provides fluent interface
     */
    public function setConsumerSecret($consumer_secret)
    {
        $this->consumer_secret = $consumer_secret;
        return $this;
    }
    
    /**
     * Get the consumer key
     *
     * @return string
     */      
    public function getConsumerKey()
    {
        return $this->consumer_key;
    }

    /**
     * Set the consumer key
     *
     * @param  string $consumer_key
     * @return Application_Model_Business_Application Provides fluent interface
     */
    public function setConsumerKey($consumer_key)
    {
        $this->consumer_key = $consumer_key;
        return $this;
    }
    
    /**
     * Get application status
     *
     * @return bool
     */      
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * Set the application's status
     *
     * @param  bool $status
     * @return Application_Model_Business_Application Provides fluent interface
     */
    public function setActiveStatus($status)
    {
        $this->is_active = $status;
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
    
    /**
     * Return true if the application is available
     *
     @return bool
    */
    public function isAvailable()
    {
        //make the connection with curl
       $cl = curl_init($this->getURL());
       
       curl_setopt($cl,CURLOPT_CONNECTTIMEOUT,10);
       curl_setopt($cl,CURLOPT_HEADER,true);
       curl_setopt($cl,CURLOPT_NOBODY,true);
       curl_setopt($cl,CURLOPT_RETURNTRANSFER,true);

       //get response
       $response = curl_exec($cl);

       curl_close($cl);
       
       return (bool) $response;
    }
}