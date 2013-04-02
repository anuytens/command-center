<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Business_Profile_Pompier
 */

 /**
 * Abstract class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Business_Profile_Pompier
 */
abstract class Application_Model_Business_Profile_Pompier extends Application_Model_Business_Profile
{
    /**
     * Grade.
     *
     * @var string
     */
    protected $grade;

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
     * @return Application_Model_Business_Profile_Pompier Provides fluent interface
     */    
    public function setGrade($grade)
    {
        $this->grade = $grade;
        return $this;
    }
}