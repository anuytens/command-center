<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_ApplicationsGroup
 */

 /**
 * Class for application group instance.
 *
 * @category   Application
 * @package    Application_Model_ApplicationsGroup
 */
class Application_Model_ApplicationsGroup extends Application_Model_Abstract implements Countable
{
    /**
     * Applications list
     *
     * @var array<Application_Model_Application>
     */
    private $applications = array();
    
    /**
     * Applications Group's name
     *
     * @var string
     */
    private $name;
    
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
     * @return Application_Model_ApplicationsGroup Provides fluent interface
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Get the applications
     *
     * @return array<Application_Model_Application>
     */      
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Set the array of applications
     *
     * @param  array<Application_Model_Application> $applications
     * @return Application_Model_ApplicationsGroup Provides fluent interface
     */
    public function setApplications(array $applications)
    {
        $this->applications = $applications;
        return $this;
    }
    
    /**
     * Add an application
     *
     * @param  Application_Model_Application $application
     * @return Application_Model_ApplicationsGroup Provides fluent interface
     */ 
    public function add(Application_Model_Application $application)
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
     * @param  Application_Model_Application $application
     * @return Application_Model_ApplicationsGroup Provides fluent interface
     */ 
    public function remove(Application_Model_Application $application)
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
    
}