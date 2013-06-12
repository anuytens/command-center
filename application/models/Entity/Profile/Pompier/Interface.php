<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile_Pompier_Interface
 */

 /**
 * Interface for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile_Pompier_Interface
 */
interface Application_Model_Entity_Profile_Pompier_Interface
{
    /**
     * Get grade
     *
     * @return string
     */    
    public function getGrade();

    /**
     * Set grade
     *
     * @param  string $grade
     * @return Application_Model_Entity_Profile_Pompier Provides fluent interface
     */    
    public function setGrade($grade);
}
