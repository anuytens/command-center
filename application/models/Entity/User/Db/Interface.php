<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_User_Db_Interface
 */

 /**
 * Interface for user db instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_User_Db_Interface
 */
interface Application_Model_Entity_User_Db_Interface
{
    /**
     * Get user's password
     *
     * @return string
     */
    public function getPassword();
    
    /**
     * Set the user's password
     *
     * @param  string $password
     * @param  bool $hashed
     * @return Application_Model_Entity_User_Db Provides fluent interface
     */
    public function setPassword($password, $hashed = true);
    
    /**
     * Retrieve the user's informations in an array
     *
     * @return array
     */     
    public function toArray();
}
