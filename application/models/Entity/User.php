<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_User
 */

 /**
 * class for user instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_User
 */
class Application_Model_Entity_User extends SDIS62_Model_Entity_Abstract implements Application_Model_Entity_User_Interface
{
    /**
     * User's profile
     *
     * @var Application_Model_Entity_Profile
     */
     public $profile;
     
    /**
     * If the user still active, the var equal true
     *
     * @var bool
     */
     public $is_active;
     
     /**
     * List of user's applications
     *
     * @var array<Application_Model_Entity_Application>
     */
     public $applications = array();
     
    /**
     * User's role
     *
     * @var Application_Model_Role
     */
     public $role;
     
     /**
     * Construct the user with a profile
     *
     * @param  Application_Model_Entity_Profile $profile
      * @return Application_Model_Entity_User
     */
     public function __construct(Application_Model_Proxy_Profile $profile = null)
     {
        if($profile !== null)
        {
            $this->setProfile($profile);
        }
     }
     
     /**
     * Get the user's role
     *
     * @return Application_Model_Entity_Role
     */      
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the user's role
     *
     * @param  int $role
     * @return Application_Model_Entity_User Provides fluent interface
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

     /**
     * Get the user's profile.
     *
     * @return Application_Model_Proxy_Profile
     */
     public function getProfile()
     {
        return $this->profile;
     }
     
      /**
     * Get the user's login.
     *
     * @return string
     */
     public function getLogin()
    {
        $profile = $this->getProfile();
    
         if(null === $profile)
        {
            throw new Exception("User's profile is null.");
        }
        
        return $profile->getEmail();
    }
     
     /**
     * Get the active status
     *
     * @return bool
     */
     public function isActive()
     {
        return $this->is_active;
     }    
     
    /**
     * Set the user's profile
     *
     * @param  Application_Model_Proxy_Profile $profile
     * @return Application_Model_Entity_User Provides fluent interface
     */
    public function setProfile(Application_Model_Proxy_Profile $profile)
    {
        $this->profile = $profile;
        return $this;
    }
    
    /**
     * Set the user's status (1= active, 0 = inactive)
     *
     * @param  bool $status
     * @return Application_Model_Entity_User Provides fluent interface
     */
    public function setActiveStatus($status)
    {
        $this->is_active = $status;
        return $this;
    }
    
    /**
     * Get an array with user's applications.
     *
     * @return array<Application_Model_Proxy_Application>
     */      
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Set the array of user's applications.
     *
     * @param  array<Application_Model_Proxy_Application> $applications
     * @return Application_Model_Entity_User Provides fluent interface
     */
    public function setApplications(array $applications)
    {
        $this->applications = $applications;
        return $this;
    }
 
    /**
     * Add an application in the array of user's applications.
     *
     * @param  Application_Model_Proxy_Application $application
     * @return Application_Model_Entity_User Provides fluent interface
     */ 
    public function addApplication(Application_Model_Proxy_Application $application)
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
     * Add a collection of applications in the array of user's applications.
     *
     * @param  array<Application_Model_Proxy_Application>|Application_Model_ApplicationsGroup $applications
     * @return Application_Model_Entity_User Provides fluent interface
     */ 
    public function addApplications($applications)
    {
        if(is_array($applications))
        {
            foreach($applications as $application)
            { 
                $this->addApplication($application);
            }
        }
        else if($applications instanceof Application_Model_Proxy_ApplicationsGroup)
        {
            $this->addApplications($applications->getApplications());
        }
        
        return $this;
    }
    
    /**
     * Remove an application in the array of user's applications.
     *
     * @param  Application_Model_Proxy_Application $application
     * @return Application_Model_Entity_User Provides fluent interface
     */ 
    public function removeApplication(Application_Model_Proxy_Application $application)
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
     * Test if the user has the application
     *
     * @param  Application_Model_Proxy_Application $application
     * @return bool True if the user has the application, else false
     */
    public function hasApplication($application)
    {
        return in_array($application, $this->getApplications());
    }
    
    /**
     * Retrieve the user's informations in an array
     *
     * @return array
     */     
    public function toArray()
    {
        return array(
            "id" => $this->getId(),
            "mail" => $this->getLogin(),
            "first_name" => $this->getProfile()->getFirstName(),
            "last_name" => $this->getProfile()->getLastName(),
            "display_name" => $this->getProfile()->getFullName()
        );
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
			'profile' => $this->profile,
			'is_active' => $this->is_active,
			'role' => $this->role
		);
	}
}
