<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Proxy_User
 */

 /**
 * class for user instance.
 *
 * @category   Application
 * @package    Application_Model_Proxy_User
 */
class Application_Model_Proxy_User extends SDIS62_Model_Proxy_Abstract implements Application_Model_Entity_User_Interface
{
	/**
	* Type of object
	*
	* @var string
	*/
	public $type_objet = 'User';
		
     /**
     * Construct the user with a profile
     *
     * @param  Application_Model_Proxy_Profile $profile
      * @return Application_Model_Proxy_User
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
     * @return Application_Model_Proxy_Role
     */      
    public function getRole()
    {
        $res = $this->getEntity()->getRole();
		if($res === null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this->type_objet)->create($this);
			return $this->getEntity()->getRole();
		}
        return $res;
    }

    /**
     * Set the user's role
     *
     * @param  int $role
     * @return Application_Model_Proxy_User Provides fluent interface
     */
    public function setRole($role)
    {
        $this->getEntity()->setRole($role);
        return $this;
    }

     /**
     * Get the user's profile.
     *
     * @return Application_Model_Proxy_Profile
     */
     public function getProfile()
     {
        $res = $this->getEntity()->getProfile();
		if($res === null)
		{
			SDIS62_Model_DAO_Abstract::getInstance('Profile')->fetch($this);
			return $this->getEntity()->getProfile();
		}
        return $res;
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
        $res = $this->getEntity()->isActive();
		if($res === null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this->type_objet)->create($this);
			return $this->getEntity()->isActive();
		}
        return $res;
     }    
     
    /**
     * Set the user's profile
     *
     * @param  Application_Model_Proxy_Profile $profile
     * @return Application_Model_Proxy_User Provides fluent interface
     */
    public function setProfile(Application_Model_Proxy_Profile $profile)
    {
        $this->getEntity()->setProfile($role);
        return $this;
    }
    
    /**
     * Set the user's status (1= active, 0 = inactive)
     *
     * @param  bool $status
     * @return Application_Model_Proxy_User Provides fluent interface
     */
    public function setActiveStatus($status)
    {
        $this->getEntity()->setActiveStatus($status);
        return $this;
    }
    
    /**
     * Get an array with user's applications.
     *
     * @return array<Application_Model_Proxy_Application>
     */      
    public function getApplications()
    {
        $res = $this->getEntity()->getProfile();
		if($res === null)
		{
			SDIS62_Model_DAO_Abstract::getInstance('Application')->fetchAll($this->getId());
			return $this->getEntity()->getApplications();
		}
        return $res;
    }

    /**
     * Set the array of user's applications.
     *
     * @param  array<Application_Model_Proxy_Application> $applications
     * @return Application_Model_Proxy_User Provides fluent interface
     */
    public function setApplications(array $applications)
    {
        $this->getEntity()->setApplications($applications);
        return $this;
    }
 
    /**
     * Add an application in the array of user's applications.
     *
     * @param  Application_Model_Proxy_Application $application
     * @return Application_Model_Proxy_User Provides fluent interface
     */ 
    public function addApplication(Application_Model_Proxy_Application $application)
    {
        $this->getEntity()->addApplication($application);
        return $this;
    }
    
    /**
     * Add a collection of applications in the array of user's applications.
     *
     * @param  array<Application_Model_Proxy_Application>|Application_Model_Proxy_ApplicationsGroup $applications
     * @return Application_Model_Proxy_User Provides fluent interface
     */ 
    public function addApplications($applications)
    {
        $this->getEntity()->addApplications($applications);
        return $this;
    }
    
    /**
     * Remove an application in the array of user's applications.
     *
     * @param  Application_Model_Proxy_Application $application
     * @return Application_Model_Proxy_User Provides fluent interface
     */ 
    public function removeApplication(Application_Model_Proxy_Application $application)
    {
        $this->getEntity()->removeApplication($application);
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
        return $this->getEntity()->toArray();
	}
}
