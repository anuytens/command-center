<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_UsersGroup
 */

 /**
 * Class for users group instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_UsersGroup
 */
class Application_Model_Entity_UsersGroup extends SDIS62_Model_Entity_Abstract implements Application_Model_Entity_UsersGroup_Interface, Countable
{
    /**
     * Users list
     *
     * @var array<Application_Model_Proxy_User>
     */
    public $users = array();
    
    /**
     * Users Group's name
     *
     * @var string
     */
    public $name;
    
    /**
     * User's role
     *
     * @var Application_Model_Proxy_Role
     */
     public $role;
     
     /**
     * Users Group's description
     *
     * @var string
     */
     public $description;
    
    /**
     * Get Users Group's name.
     *
     * @return string
     */      
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Users Group's name
     *
     * @param  string $name
     * @return Application_Model_Entity_UsersGroup Provides fluent interface
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
        /**
     * Get Users Group's description.
     *
     * @return string
     */      
    public function getDesc()
    {
        return $this->description;
    }

    /**
     * Set Users Group's description
     *
     * @param  string $description
     * @return Application_Model_Entity_UsersGroup Provides fluent interface
     */
    public function setDesc($description)
    {
        $this->description = $description;
        return $this;
    }
    
     /**
     * Get the users group's role
     *
     * @return Application_Model_Entity_Role
     */      
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the users group's role
     *
     * @param  int $role
     * @return Application_Model_Entity_UsersGroup Provides fluent interface
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }
    
    /**
     * Get the users
     *
     * @return array<Application_Entity_Model_User>
     */      
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set the array of users
     *
     * @param  array<Application_Proxy_Model_User> $users
     * @return Application_Model_Entity_UsersGroup Provides fluent interface
     */
    public function setUsers(array $users)
    {
        $this->users = $users;
        return $this;
    }
    
    /**
     * Add user
     *
     * @param  Application_Model_Proxy_User $user
     * @return Application_Model_Entity_UsersGroup Provides fluent interface
     */ 
    public function add(Application_Model_Proxy_User $user)
    {
        // avoid duplication
        if(false !== array_search($user, $this->users))
        {
            return $this;
        }
        
        array_push($this->users, $user);
        
        return $this;
    }
    
    /**
     * Remove a user
     *
     * @param  Application_Model_Proxy_User $user
     * @return Application_Model_Entity_UsersGroup Provides fluent interface
     */ 
    public function remove(Application_Model_Proxy_User $user)
    {
        // Search user in array
        $key_of_user_to_remove = array_search($user, $this->users);

        if($key_of_user_to_remove === false)
        {
            return $this;
        }
        
        unset($this->users[$key_of_user_to_remove]);
    
        return $this;
    }

    /**
     * Implements countable. Return the number of users in the group
     *
     * @return int
     */      
    public function count()
    {
        return count($this->getUsers());
    }
    
    /**
	* Hydrate an array who contain informations to add at entity
	*
	* @params Array $array
	* @return SDIS62_Model_Entity_Entity_Abstract
	*/
    public function hydrate($array)
	{
		foreach($array as $n => $v)
		{
			$this->$n = $v;
		}
	}
	
	/**
	* Extract an array from entity who contain informations about the entity
	*
	* @return Array
	*/
	public function extract()
	{
		return array(
			'primary' => $this->primary,
			'label' => $this->label,
			'idPersonne' => $this->idPersonne
		);
	}
}
