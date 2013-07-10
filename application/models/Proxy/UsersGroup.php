<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Proxy_UsersGroup
 */

 /**
 * Class for users group instance.
 *
 * @category   Application
 * @package    Application_Model_Proxy_UsersGroup
 */
class Application_Model_Proxy_UsersGroup extends SDIS62_Model_Proxy_Abstract implements Application_Model_Entity_UsersGroup_Interface, Countable
{
	/**
	* Type of object
	*
	* @var string
	*/
	public static $type_objet = 'UsersGroup';
		
    /**
     * Get Users Group's name.
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
     * Set Users Group's name
     *
     * @param  string $name
     * @return Application_Model_Proxy_UsersGroup Provides fluent interface
     */
    public function setName($name)
    {
        $this->getEntity()->setName($name);
        return $this;
    }
    
        /**
     * Get Users Group's description.
     *
     * @return string
     */      
    public function getDesc()
    {
        $res = $this->getEntity()->getDesc();
		if($res == null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this::$type_objet)->create($this);
			return $this->getEntity()->getDesc();
		}
		return $res;
    }

    /**
     * Set Users Group's description
     *
     * @param  string $description
     * @return Application_Model_Proxy_UsersGroup Provides fluent interface
     */
    public function setDesc($description)
    {
        $this->getEntity()->setDesc($description);
        return $this;
    }
    
     /**
     * Get the users group's role
     *
     * @return Application_Model_Proxy_Role
     */      
    public function getRole()
    {
        return $this->getEntity()->getRole();
    }

    /**
     * Set the users group's role
     *
     * @param  int $role
     * @return Application_Model_Proxy_UsersGroup Provides fluent interface
     */
    public function setRole($role)
    {
        $this->getEntity()->setRole($role);
        return $this;
    }
    
    /**
     * Get the users
     *
     * @return array<Application_Model_Proxy_User>
     */      
    public function getUsers()
    {
        $res = $this->getEntity()->getUsers();
		if($res == null)
		{
			$this->setUsers(SDIS62_Model_DAO_Abstract::getInstance($this::$type_objet)->findAllByCriteria('User', array('primary' => $this::getPrimary())));
			return $this->getEntity()->getUsers();
		}
		return $res;
    }

    /**
     * Set the array of users
     *
     * @param  array<Application_Model_Proxy_User> $users
     * @return Application_Model_Proxy_UsersGroup Provides fluent interface
     */
    public function setUsers(array $users)
    {
        $this->getEntity()->setUsers($users);
        return $this;
    }
    
    /**
     * Add user
     *
     * @param  Application_Model_Proxy_User $user
     * @return Application_Model_Proxy_UsersGroup Provides fluent interface
     */ 
    public function add(Application_Model_Proxy_User $user)
    {
        $this->getEntity()->add($user);
        return $this;
    }
    
    /**
     * Remove a user
     *
     * @param  Application_Model_Proxy_User $user
     * @return Application_Model_Proxy_UsersGroup Provides fluent interface
     */ 
    public function remove(Application_Model_Proxy_User $user)
    {
        $this->getEntity()->remove($user);
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
}
