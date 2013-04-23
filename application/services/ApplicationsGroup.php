<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Service_ApplicationsGroup
 */

 /**
 * Service User
 *
 * @category   Application
 * @package    Application_Service_ApplicationsGroup
 */
class Application_Service_ApplicationsGroup
{
    /**
     * Group's form
     *
     * @var Zend_Form
     */
    private $form;
    
    /**
     * Construct the group's service
     *
     * @return Application_Service_ApplicationsGroup
     * 
     */    
    public function __construct()
    {
        $this->form = new Application_Form_ApplicationsGroup;
    }
    
    /**
     * Get a group
     *
     * @return Application_Model_ApplicationsGroup
     * 
     */   
    public function get($id_group)
    {
        $groups_mapper = new Application_Model_Mapper_ApplicationsGroup;
        $groups = $groups_mapper->getById($id_group);
        
        if(count($groups) === 1)
        {
            return $groups[0];
        }
        else
        {
            return null;
        }
    }

    /**
     * Get all groups
     *
     * @return array<Application_Model_ApplicationsGroup>
     * 
     */   
    public function getAllGroups()
    {
        $groups_mapper = new Application_Model_Mapper_ApplicationsGroup;
        return $groups_mapper->fetchAll();
    }
    
    /**
     * Create group
     *
     * @param array $data
     * @return Application_Model_ApplicationsGroup
     * 
     */   
    public function create($data)
    {
        if($this->getGroupForm()->isValid($data))
        {
            $applicationsGroup = new Application_Model_ApplicationsGroup;
            $applicationsGroup->setName($data["name"]);
            $applicationsGroup->setColor($data["color"]);
            
            foreach($data["applications"] as $id_application)
            {
                $application = new Application_Model_Application;
                $application->setId($id_application);
                $applicationsGroup->add($application);
            }
            
            $group_mapper = new Application_Model_Mapper_ApplicationsGroup;
            $group_mapper->save($applicationsGroup);
            
            return $applicationsGroup;
        }

        return null;
    }
    
    /**
     * Save group
     *
     * @param array $data
     * @return Application_Model_ApplicationsGroup
     * 
     */
    public function save($data)
    {
        if($this->getGroupForm()->isValid($data) && isset($data["id"]) && $data["id"] > 0)
        {
            $applicationsGroup = new Application_Model_ApplicationsGroup;
            $applicationsGroup->setName($data["name"]);
            $applicationsGroup->setColor($data["color"]);
            $applicationsGroup->setId($data["id"]);
            
            foreach($data["applications"] as $id_application)
            {
                $application = new Application_Model_Application;
                $application->setId($id_application);
                $applicationsGroup->add($application);
            }
            
            $group_mapper = new Application_Model_Mapper_ApplicationsGroup;
            $group_mapper->save($applicationsGroup);
            
            return $applicationsGroup;
        }

        return null;
    }
    
    /**
     * Get all applications without a group
     *
     * @return array<Application_Model_Application>
     * 
     */
    public function getApplicationsWithoutGroup()
    {
        $application_service = new Application_Service_Application;
        
        $groups = $this->getAllGroups();
        
        // récupération des utilisateurs n'ayvant pas de groupe
        $applications = $application_service->getAllApplications();
        
        if(count($groups) > 0)
        {
            foreach($groups as $group)
            {
                foreach($group->getApplications() as $application)
                {
                    $applications = array_diff($applications, array($application));
                }
            }
        }
        
        return $applications;
    }
    
    /**
     * Get the group's form
     *
     * @param $id_group optional
     * @return Zend_Form
     * 
     */   
    public function getGroupForm($id_group = null)
    {
       // if a id_group is provided, populate the form with his informations
        if($id_group !== null)
        {
            // get the group
            $group = $this->get($id_group);
            
            // $data is the array results
            $data = array();
            $data["name"] = $group->getName();
            $data["color"] = $group->getColor();
            $data["id"] = $group->getId();
            
            foreach($group->getApplications() as $application)
            {
                $data["applications"][] = $application->getId();
            }
            
            $this->getGroupForm()->populate($data);
        }
        return $this->form;
    }
    
    /**
     * Delete
     *
     * @param $group Application_Model_ApplicationsGroup
     * 
     */    
    public function delete(&$group)
    {
        $group_mapper = new Application_Model_Mapper_ApplicationsGroup;
        $group_mapper->delete($group);
    }

}