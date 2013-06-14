<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_UsersGroup_Interface
 */

 /**
 * Interface for users group instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_UsersGroup_Interface
 */
interface Application_Model_Entity_UsersGroup_Interface
{
    /**
     * Get Users Group's name.
     *
     * @return string
     */      
    public function getName();

    /**
     * Set Users Group's name
     *
     * @param  string $name
     * @return Application_Model_Entity_UsersGroup Provides fluent interface
     */
    public function setName($name);
    
        /**
     * Get Users Group's description.
     *
     * @return string
     */      
    public function getDesc();

    /**
     * Set Users Group's description
     *
     * @param  string $description
     * @return Application_Model_Entity_UsersGroup Provides fluent interface
     */
    public function setDesc($description);
    
     /**
     * Get the users group's role
     *
     * @return Application_Model_Role
     */      
    public function getRole();

    /**
     * Set the users group's role
     *
     * @param  int $role
     * @return Application_Model_Entity_UsersGroup Provides fluent interface
     */
    public function setRole($role);
    
    /**
     * Get the users
     *
     * @return array<Application_Model_User>
     */      
    public function getUsers();

    /**
     * Set the array of users
     *
     * @param  array<Application_Model_Proxy_User> $users
     * @return Application_Model_Entity_UsersGroup Provides fluent interface
     */
    public function setUsers(array $users);
    
    /**
     * Add user
     *
     * @param  Application_Model_Proxy_User $user
     * @return Application_Model_Entity_UsersGroup Provides fluent interface
     */ 
    public function add(Application_Model_Proxy_User $user);
    
    /**
     * Remove a user
     *
     * @param  Application_Model_Proxy_User $user
     * @return Application_Model_Entity_UsersGroup Provides fluent interface
     */ 
    public function remove(Application_Model_Proxy_User $user);
}
