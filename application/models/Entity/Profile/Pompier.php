<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile_Pompier
 */

 /**
 * Abstract class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile_Pompier
 */
class Application_Model_Entity_Profile_Pompier extends Application_Model_Entity_Profile implements Application_Model_Entity_Profile_Pompier_Interface
{
    /**
     * Grade.
     *
     * @var string
     */
    public $grade;
    
    /**
     * ID of profile
     *
     * @var string
     */
    public $id_profile;

    /**
     * Get grade
     *
     * @return string
     */    
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set grade
     *
     * @param  string $grade
     * @return Application_Model_Entity_Profile_Pompier Provides fluent interface
     */    
    public function setGrade($grade)
    {
        $this->grade = $grade;
        return $this;
    }
}
