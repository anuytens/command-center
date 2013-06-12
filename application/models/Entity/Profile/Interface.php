<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile_Interface
 */

 /**
 * Interface for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile_Interface
 */
interface Application_Model_Entity_Profile_Interface
{
    /**
     * Get the first name
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Get the last name
     *
     * @return string
     */
    public function getLastName();

    /**
     * Get the full name
     *
     * @return string
     */
    public function getFullName(); 
    
    /**
     * Return true if the profil concern a man, else false.
     *
     * @return bool
     */  
    public function isMan();
    
    /**
     * Return true if the profil concern a woman, else false.
     *
     * @return bool
     */  
    public function isWoman();
    
    /**
     * Get the phone number
     *
     * @return string
     */      
    public function getPhone();
    
    /**
     * Get the postal address
     *
     * @return string
     */          
    public function getAddress();
    
    /**
     * Get email.
     *
     * @return string
     */      
    public function getEmail();

    /**
     * Set the first name
     *
     * @param  string $first_name
     * @return Application_Model_Entity_Profile Provides fluent interface
     */
    public function setFirstName($first_name);
    
    /**
     * Set the last name
     *
     * @param  string $last_name
     * @return Application_Model_Entity_Profile Provides fluent interface
     */
    public function setLastName($last_name);
    
    /**
     * Set the profile to man
     *
     * @return Application_Model_Entity_Profile Provides fluent interface
     */
    public function setAsMan();
 
    /**
     * Set the profile to woman
     *
     * @return Application_Model_Entity_Profile Provides fluent interface
     */
    public function setAsWoman();
    
    /**
     * Set the phone number
     *
     * @param  string $phone
     * @return Application_Model_Entity_Profile Provides fluent interface
     */
    public function setPhone($phone);
    
    /**
     * Set the postal address
     *
     * @param  string $address
     * @return Application_Model_Entity_Profile Provides fluent interface
     */
    public function setAddress($address);
    
     /**
     * Set email
     *
     * @param  string $email
     * @return Application_Model_Entity_Profile Provides fluent interface
     */   
    public function setEmail($email);
}
