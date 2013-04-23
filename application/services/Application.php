<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Service_Application
 */

 /**
 * Service Application
 *
 * @category   Application
 * @package    Application_Service_Application
 */
class Application_Service_Application
{
    /**
     * Application's form
     *
     * @var Zend_Form
     */
    private $form;
    
    /**
     * Construct the user's service
     *
     * @return Application_Service_Application
     * 
     */    
    public function __construct()
    {
        $this->form = new Application_Form_Application;
    }
    
    /**
     * Get an application
     *
     * @return Application_Model_Application
     * 
     */       
    public function get($id_application)
    {
        $applications_mapper = new Application_Model_Mapper_Application;
        $applications = $applications_mapper->getById($id_application);
        
        if(count($applications) === 1)
        {
            return $applications[0];
        }
        else
        {
            return null;
        }
    }
    
    /**
     * Create an app
     *
     * @param array $data
     * @return Application_Model_Application
     * 
     */   
    public function create($data)
    {
        if($this->getApplicationForm()->isValid($data))
        {
            $application = new Application_Model_Application;
            $application->setName($data["name"]);
            $application->setURL($data["url"]);
            $application->setActiveStatus($data["status"]);
            
            if($data["access"] == 1)
            {
                $application->setConsumerSecret(sha1($application->getName() . mktime()));
                $application->setConsumerKey(sha1($application->getURL() . mktime()));
            }
            
            $application_mapper = new Application_Model_Mapper_Application;
            $application_mapper->save($application);
            
            return $application;
        }

        return null;
    }
    
    /**
     * Save an app
     *
     * @param array $data
     * @return Application_Model_Application
     * 
     */
    public function save($data)
    {
        if($this->getApplicationForm()->isValid($data) && isset($data["id"]) && $data["id"] > 0)
        {
            $application = new Application_Model_Application;
            $application->setName($data["name"]);
            $application->setURL($data["url"]);
            $application->setActiveStatus($data["status"]);
            $application->setId($data["id"]);
            
            $application_mapper = new Application_Model_Mapper_Application;
            $application_mapper->save($application);
            
            return $application;
        }

        return null;
    }
    
    /**
     * Get all applications
     *
     * @return array<Application_Model_Application>
     * 
     */   
    public function getAllApplications()
    {
        $applications_mapper = new Application_Model_Mapper_Application;
        return $applications_mapper->fetchAll();
    }
    
    /**
     * Get the application's form
     *
     * @param $id_application optional
     * @return Zend_Form
     * 
     */   
    public function getApplicationForm($id_application = null)
    {
       // if a id_application is provided, populate the form with his informations
        if($id_application !== null)
        {
            // get the group
            $application = $this->get($id_application);
            
            // $data is the array results
            $data = array();
            $data["name"] = $application->getName();
            $data["url"] = $application->getURL();
            $data["status"] = $application->isActive();
            $data["id"] = $application->getId();
            
            $this->getApplicationForm()->removeElement("access");
            $this->getApplicationForm()->populate($data);
        }
        return $this->form;
    }
    
    /**
     * Delete
     *
     * @param $application Application_Model_Application
     * 
     */    
    public function delete(&$application)
    {
        $applications_mapper = new Application_Model_Mapper_Application;
        $applications_mapper->delete($application);
    }
}