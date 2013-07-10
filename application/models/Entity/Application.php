<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_Application
 */

 /**
 * Class for application instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_Application
 */
class Application_Model_Entity_Application extends SDIS62_Model_Entity_Abstract implements Application_Model_Entity_Application_Interface
{
    /**
     * Name of the application
     *
     * @var string
     */
    public $name;

    /**
     * URL of the application
     *
     * @var string
     */
    public $url;
    
    /**
     * Consumer secret (for oauth)
     *
     * @var string
     */
    public $consumer_secret;

    /**
     * Consumer key (for oauth)
     *
     * @var string
     */
    public $consumer_key;
    
    /**
     * Application status
     *
     * @var bool
     */
    public $is_active;
    
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
     * @return Application_Model_Entity_Application Provides fluent interface
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
     * @return Application_Model_Entity_Application Provides fluent interface
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
     * @return Application_Model_Entity_Application Provides fluent interface
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
     * @return Application_Model_Entity_Application Provides fluent interface
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
     * @return Application_Model_Entity_Application Provides fluent interface
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
        $socket = @fsockopen(parse_url($this->getURL(), PHP_URL_HOST), 80, $errno, $errstr, 1);
        
        if ($socket === false)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    /**
     * Check if the application is extern
     *
     @return bool
    */
    public function isExtern()
    {
      return !$this->isLegacy() && !$this->isEcosystem();
    }
    
    /**
     * Check if the application is in SDIS but legacy
     *
     @return bool
    */
    public function isLegacy()
    {
        if(!$this->isEcosystem())
        {
            $url = explode(".", parse_url($this->getURL(), PHP_URL_HOST));
            return $url[1] === "sdis62";
        }
        
        return false;
    }
    
    /**
     * Check if the application is in ecosystem
     *
     @return bool
    */
    public function isEcosystem()
    {
      return parse_url($this->getURL(), PHP_URL_HOST) == "apps.sdis62.fr";
    }
    
    /**
	* Hydrate an array who contain informations to add at entity
	*
	* @params Array $array
	* @return SDIS62_Model_Entity_Abstract Provides fluent interface
	*/
    public function hydrate($array)
	{
		foreach($array as $n => $v)
		{
			$this->$n = $v;
		}
		return $this;
	}
	
	/**
	* Extract an array from entity who contain informations about the entity
	*
	* @return Array
	*/
	public function extract()
	{
		$domain = "extern";
        
        if($this->isEcosystem())
        {
            $domain = "ecosystem";
        }
        elseif($this->isLegacy())
        {
            $domain = "legacy";
        }
        
        return array(
            "primary" => $this->getPrimary(),
            "name" => $this->getName(),
            "is_active" => $this->isActive(),
            "url" => $this->getURL(),
            "consumer_key" => $this->getConsumerKey(),
            "consumer_secret" => $this->getConsumerSecret(),
            "domain" => $domain
        );
	}
}
