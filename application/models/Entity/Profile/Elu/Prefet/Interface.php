<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile_Elu_Prefet_Interface
 */

 /**
 * Interface for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile_Elu_Prefet_Interface
 */
interface Application_Model_Entity_Profile_Elu_Prefet_Interface
{
    /**
     * Get the prefet's department
     *
     * @return string
     */    
    public function getDepartment();

    /**
     * Set the department
     *
     * @param  string $department
     * @return Application_Model_Entity_Profile_Elu_Prefet Provides fluent interface
     */    
    public function setDepartment($department);
}
