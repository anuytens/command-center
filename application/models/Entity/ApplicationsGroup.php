<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_ApplicationsGroup
 */

 /**
 * Class for application group instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_ApplicationsGroup
 */
class Application_Model_Entity_ApplicationsGroup extends SDIS62_Model_Entity_Abstract implements Application_Model_Entity_ApplicationsGroup_Interface, Countable
{
    /**
     * Applications list
     *
     * @var array<Application_Model_Proxy_Application>
     */
    public $applications = array();
    
    /**
     * Applications Group's name
     *
     * @var string
     */
    public $name;
    
    /**
     * Applications Group's color
     *
     * @var string
     */
    public $color;
    
    /**
     * Get Applications Group's name.
     *
     * @return string
     */      
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Applications Group's name
     *
     * @param  string $name
     * @return Application_Model_Entity_ApplicationsGroup Provides fluent interface
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Get Applications Group's color.
     *
     * @return string
     */      
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set Applications Group's color
     *
     * @param  string $name
     * @return Application_Model_Entity_ApplicationsGroup Provides fluent interface
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }
    
    /**
     * Get the applications
     *
     * @return array<Application_Model_Proxy_Application>
     */      
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Set the array of applications
     *
     * @param  array<Application_Model_Proxy_Application> $applications
     * @return Application_Model_Entity_ApplicationsGroup Provides fluent interface
     */
    public function setApplications(array $applications)
    {
        $this->applications = $applications;
        return $this;
    }
    
    /**
     * Add an application
     *
     * @param  Application_Model_Proxy_Application $application
     * @return Application_Model_Entity_ApplicationsGroup Provides fluent interface
     */ 
    public function add(Application_Model_Proxy_Application $application)
    {
        // avoid duplication
        if(false !== array_search($application, $this->applications))
        {
            return $this;
        }
        
        array_push($this->applications, $application);
        
        return $this;
    }
    
    /**
     * Remove an application
     *
     * @param  Application_Model_Proxy_Application $application
     * @return Application_Model_Entity_ApplicationsGroup Provides fluent interface
     */ 
    public function remove(Application_Model_Proxy_Application $application)
    {
        // Serach application in user's applications array
        $key_of_application_to_remove = array_search($application, $this->applications);

        if($key_of_application_to_remove === false)
        {
            return $this;
        }
        
        unset($this->applications[$key_of_application_to_remove]);
    
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
		return array(
			'applications' => $this->applications,
			'name' => $this->name,
			'color' => $this->color
		);
	}
}
