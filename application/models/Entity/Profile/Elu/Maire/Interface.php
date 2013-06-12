<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile_Elu_Maire_Interface
 */

 /**
 * Interface for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile_Elu_Maire_Interface
 */
interface Application_Model_Entity_Profile_Elu_Maire_Interface
{
    /**
     * Get the mayor's city
     *
     * @return string
     */    
    public function getCity();

    /**
     * Set the city
     *
     * @param  string $city
     * @return Application_Model_Entity_Profile_Elu_Maire Provides fluent interface
     */    
    public function setCity($city);
}
