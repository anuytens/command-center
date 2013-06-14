<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Proxy_ApplicationsGroup
 */

 /**
 * Class for application group instance.
 *
 * @category   Application
 * @package    Application_Model_Proxy_ApplicationsGroup
 */
class Application_Model_Proxy_ApplicationsGroup extends SDIS62_Model_Proxy_Abstract implements Application_Model_Entity_ApplicationsGroup_Interface, Countable
{
	/**
	* Type of object
	*
	* @var string
	*/
	public static $type_objet = 'ApplicationsGroup';
		
    /**
     * Get Applications Group's name.
     *
     * @return string
     */      
    public function getName()
    {
        $res = $this->getEntity()->getName();
		if($res === null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this::$type_objet)->create($this);
			return $this->getEntity()->getName();
		}
		return $res;
    }

    /**
     * Set Applications Group's name
     *
     * @param  string $name
     * @return Application_Model_Proxy_ApplicationsGroup Provides fluent interface
     */
    public function setName($name)
    {
        $this->getEntity()->setName($name);
        return $this;
    }
    
    /**
     * Get Applications Group's color.
     *
     * @return string
     */      
    public function getColor()
    {
        $res = $this->getEntity()->getColor();
		if($res === null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this::$type_objet)->create($this);
			return $this->getEntity()->getColor();
		}
		return $res;
    }

    /**
     * Set Applications Group's color
     *
     * @param  string $name
     * @return Application_Model_Proxy_ApplicationsGroup Provides fluent interface
     */
    public function setColor($color)
    {
        $this->getEntity()->setColor($color);
        return $this;
    }
    
    /**
     * Get the applications
     *
     * @return array<Application_Model_Proxy_Application>
     */      
    public function getApplications()
    {
        $res = $this->getEntity()->getApplications();
		if($res === null)
		{
			$this->getEntity()->hydrate(SDIS62_Model_DAO_Abstract::getInstance($this::$type_objet)->findAllByCriteria('Application', $this->getPrimary()));
			return $this->getEntity()->getApplications();
		}
		return $res;
    }

    /**
     * Set the array of applications
     *
     * @param  array<Application_Model_Proxy_Application> $applications
     * @return Application_Model_Proxy_ApplicationsGroup Provides fluent interface
     */
    public function setApplications(array $applications)
    {
        $this->getEntity()->setApplications($applications);
        return $this;
    }
    
    /**
     * Add an application
     *
     * @param  Application_Model_Proxy_Application $application
     * @return Application_Model_Proxy_ApplicationsGroup Provides fluent interface
     */ 
    public function add(Application_Model_Proxy_Application $application)
    {
        $this->getEntity()->add($application);
        return $this;
    }
    
    /**
     * Remove an application
     *
     * @param  Application_Model_Proxy_Application $application
     * @return Application_Model_Proxy_ApplicationsGroup Provides fluent interface
     */ 
    public function remove(Application_Model_Proxy_Application $application)
    {
        $this->getEntity()->remove($application);
        return $this;
    }

    /**
     * Implements countable. Return the number of applications in the group
     *
     * @return int
     */      
    public function count()
    {
        return count($this->getApplications());
    }
    
}
