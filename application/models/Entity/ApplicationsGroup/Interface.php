<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_ApplicationsGroup_Interface
 */

 /**
 * Interface for application group instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_ApplicationsGroup_Interface
 */
interface Application_Model_Entity_ApplicationsGroup_Interface implements Countable
{
    /**
     * Get Applications Group's name.
     *
     * @return string
     */      
    public function getName();

    /**
     * Set Applications Group's name
     *
     * @param  string $name
     * @return Application_Model_ApplicationsGroup Provides fluent interface
     */
    public function setName($name);
    
    /**
     * Get Applications Group's color.
     *
     * @return string
     */      
    public function getColor();

    /**
     * Set Applications Group's color
     *
     * @param  string $name
     * @return Application_Model_ApplicationsGroup Provides fluent interface
     */
    public function setColor($color);
    
    /**
     * Get the applications
     *
     * @return array<Application_Model_Application>
     */      
    public function getApplications();

    /**
     * Set the array of applications
     *
     * @param  array<Application_Model_Application> $applications
     * @return Application_Model_ApplicationsGroup Provides fluent interface
     */
    public function setApplications(array $applications);
    
    /**
     * Add an application
     *
     * @param  Application_Model_Application $application
     * @return Application_Model_ApplicationsGroup Provides fluent interface
     */ 
    public function add(Application_Model_Application $application);
    
    /**
     * Remove an application
     *
     * @param  Application_Model_Application $application
     * @return Application_Model_ApplicationsGroup Provides fluent interface
     */ 
    public function remove(Application_Model_Application $application);

    /**
     * Implements countable. Return the number of applications in the group
     *
     * @return int
     */      
    public function count();
}
