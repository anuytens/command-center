<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Service_UsersGroup
 */

 /**
 * Service User
 *
 * @category   Application
 * @package    Application_Service_UsersGroup
 */
class Application_Service_UsersGroup
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
     * @return Application_Service_UsersGroup
     * 
     */    
    public function __construct()
    {
        $this->form = new Application_Form_UsersGroup;
    }
    
    /**
     * Get a group
     *
     * @return Application_Service_UsersGroup
     * 
     */   
    public function get($id_group)
    {
        $groups_mapper = new Application_Model_Mapper_UsersGroup;
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
     * @return array<Application_Service_UsersGroup>
     * 
     */   
    public function getAllGroups()
    {
        $groups_mapper = new Application_Model_Mapper_UsersGroup;
        return $groups_mapper->fetchAll();
    }
    
    /**
     * Create group
     *
     * @param array $data
     * @return Application_Service_UsersGroup
     * 
     */   
    public function create($data)
    {
        if($this->getGroupForm()->isValid($data))
        {
            $usersGroup = new Application_Model_UsersGroup;
            $usersGroup->setName($data["name"]);
            $usersGroup->setDesc($data["description"]);
            $usersGroup->setRole($data["role"]);
            
            foreach($data["users"] as $id_user)
            {
                $user = new Application_Model_User;
                $user->setId($id_user);
                $usersGroup->add($user);
            }
            
            $group_mapper = new Application_Model_Mapper_UsersGroup;
            $group_mapper->save($usersGroup);
            
            return $usersGroup;
        }

        return null;
    }
    
    /**
     * Save group
     *
     * @param array $data
     * @return Application_Service_UsersGroup
     * 
     */
    public function save($data)
    {
        if($this->getGroupForm()->isValid($data) && isset($data["id"]) && $data["id"] > 0)
        {
            $usersGroup = new Application_Model_UsersGroup;
            $usersGroup->setName($data["name"]);
            $usersGroup->setDesc($data["description"]);
            $usersGroup->setRole($data["role"]);
            $usersGroup->setId($data["id"]);
            
            foreach($data["users"] as $id_user)
            {
                $user = new Application_Model_User;
                $user->setId($id_user);
                $usersGroup->add($user);
            }
            
            $group_mapper = new Application_Model_Mapper_UsersGroup;
            $group_mapper->save($usersGroup);
            
            return $usersGroup;
        }

        return null;
    }
    
    /**
     * Get all users without a group
     *
     * @return array<Application_Model_User>
     * 
     */
    public function getUsersWithoutGroup()
    {
        $user_service = new Application_Service_User;
        
        $groups = $this->getAllGroups();
        
        // récupération des utilisateurs n'ayvant pas de groupe
        $users = $user_service->getAllUsers();
        
        if(count($groups) > 0)
        {
            foreach($groups as $group)
            {
                foreach($group->getUsers() as $user)
                {
                    $users = array_diff($users, array($user));
                }
            }
        }
        
        return $users;
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
            $data["description"] = $group->getDesc();
            $data["role"] = $group->getRole();
            $data["id"] = $group->getId();
            
            foreach($group->getUsers() as $user)
            {
                $data["users"][] = $user->getId();
            }
            
            $this->getGroupForm()->populate($data);
        }
        return $this->form;
    }
    
    /**
     * Delete
     *
     * @param $group Application_Model_UsersGroup
     * 
     */    
    public function delete(Application_Model_UsersGroup &$group)
    {
        $group_mapper = new Application_Model_Mapper_UsersGroup;
        $group_mapper->delete($group);
    }

}