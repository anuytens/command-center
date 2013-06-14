<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Proxy_Application
 */

 /**
 * Class for application instance.
 *
 * @category   Application
 * @package    Application_Model_Proxy_Application
 */
class Application_Model_Proxy_Application extends SDIS62_Model_Proxy_Abstract implements Application_Model_Entity_Application_Interface
{
	/**
	* Type of object
	*
	* @var string
	*/
	public static $type_objet = 'Application';
		
    /**
     * Get the application's name.
     *
     * @return string
     */      
    public function getName()
    {
		$res = $this->getEntity()->getName();
		if($res == null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this::$type_objet)->create($this);
			return $this->getEntity()->getName();
		}
		return $res;
    }

    /**
     * Set the application's name
     *
     * @param  string $name
     * @return Application_Model_Proxy_Application Provides fluent interface
     */
    public function setName($name)
    {
        $this->getEntity()->setName($name);
        return $this;
    }
    
    /**
     * Get the consumer secret
     *
     * @return string
     */      
    public function getConsumerSecret()
    {
		$res = $this->getEntity()->getConsumerSecret();
		if($res == null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this::$type_objet)->create($this);
			return $this->getEntity()->getConsumerSecret();
		}
		return $res;
    }

    /**
     * Set the consumer secret
     *
     * @param  string $consumer_secret
     * @return Application_Model_Proxy_Application Provides fluent interface
     */
    public function setConsumerSecret($consumer_secret)
    {
        $this->getEntity()->setConsumerSecret($consumer_secret);
        return $this;
    }
    
    /**
     * Get the consumer key
     *
     * @return string
     */      
    public function getConsumerKey()
    {
		$res = $this->getEntity()->getConsumerKey();
		if($res == null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this::$type_objet)->create($this);
			return $this->getEntity()->getConsumerKey();
		}
		return $res;
    }

    /**
     * Set the consumer key
     *
     * @param  string $consumer_key
     * @return Application_Model_Proxy_Application Provides fluent interface
     */
    public function setConsumerKey($consumer_key)
    {
        $this->getEntity()->setConsumerKey($consumer_key);
        return $this;
    }
    
    /**
     * Get application status
     *
     * @return bool
     */      
    public function isActive()
    {
		$res = $this->getEntity()->isActive();
		if($res == null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this::$type_objet)->create($this);
			return $this->getEntity()->isActive();
		}
		return $res;
    }

    /**
     * Set the application's status
     *
     * @param  bool $status
     * @return Application_Model_Proxy_Application Provides fluent interface
     */
    public function setActiveStatus($status)
    {
        $this->getEntity()->setActiveStatus($status);
        return $this;
    }
    
    /**
     * Get the URL.
     *
     * @return string
     */      
    public function getURL()
    {
		$res = $this->getEntity()->getURL();
		if($res == null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this::$type_objet)->create($this);
			return $this->getEntity()->getURL();
		}
		return $res;
    }

    /**
     * Set the URL
     *
     * @param  string $url
     * @return Application_Model_Proxy_Application Provides fluent interface
     */
    public function setURL($url)
    {
        $this->getEntity()->setURL($url);
        return $this;
    }
    
    /**
     * Return true if the application is available
     *
     @return bool
    */
    public function isAvailable()
    {
		return $this->getEntity()->isAvailable();
    }
    
    /**
     * Check if the application is extern
     *
     @return bool
    */
    public function isExtern()
    {
		return $this->getEntity()->isExtern();
    }
    
    /**
     * Check if the application is in SDIS but legacy
     *
     @return bool
    */
    public function isLegacy()
    {
		return $this->getEntity()->isLegacy();
    }
    
    /**
     * Check if the application is in ecosystem
     *
     @return bool
    */
    public function isEcosystem()
    {
		return $this->getEntity()->isEcosystem();
    }
    
    /**
     * Retrieve the application's informations in an array
     *
     * @return array
     */     
    public function toArray()
    {
		return $this->getEntity()->toArray();
    }
}
