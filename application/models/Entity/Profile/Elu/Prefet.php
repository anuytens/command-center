<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile_Elu_Prefet
 */

 /**
 * Abstract class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile_Elu_Prefet
 */
class Application_Model_Entity_Profile_Elu_Prefet extends Application_Model_Entity_Profile_Elu implements Application_Model_Entity_Profile_Elu_Prefet_Interface
{
    /**
     * Department.
     *
     * @var string
     */
    private $department;

    /**
     * Get the prefet's department
     *
     * @return string
     */    
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set the department
     *
     * @param  string $department
     * @return Application_Model_Entity_Profile_Elu_Prefet Provides fluent interface
     */    
    public function setDepartment($department)
    {
        $this->department = $department;
        return $this;
    }
}
