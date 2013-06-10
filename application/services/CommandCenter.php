<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Service_CommandCenter
 */

 /**
 * Service layer for Command Center
 *
 * @category   Application
 * @package    Application_Service_CommandCenter
 */
class Application_Service_CommandCenter implements Application_Service_ICommandCenter
{
    /**
     * CommandCenter instance
     *
     * @var Application_Service_CommandCenter
     *
     */
    public static $_instance = null;
    
    /**
     * CommandCenter's cache instance
     *
     * @var Zend_Cache_Core
     *
     */
    private $_cache = null;
    

    private $user_form = null;
    private $users_group_form = null;
    private $application_form = null;
    private $applications_group_form = null;
    private $acl_form = null;

     /**
     * No constructor
     * 
     */      
    protected function __construct() {}
    
     /**
     * No clones
     * 
     */      
    protected function __clone() {}

    /**
     * Get cache
     *
     * @return Zend_Cache
     * 
     */        
    public function getCache()
    {
        return $this->_cache;
    }

    /**
     * Set cache
     *
     * @param Zend_Cache $cache
     * @return Application_Model_Mapper_DbTableAbstract Provides fluent interface
     * 
     */        
    public function setCache(Zend_Cache_Core $cache)
    {
        $this->_cache = $cache;
    }

    /**
     * Singleton
     *
     * @return Application_Service_CommandCenter
     * 
     */    
    public static function getInstance()
    {
        if (!isset(static::$_instance)) 
        {
            // Build the service
            static::$_instance = new static;
            
            // Set the cache
            static::$_instance->setCache(Zend_Cache::factory('Core','APC'));
            static::$_instance->setCache(Zend_Cache::factory('Core','APC'));
        }
        
        return static::$_instance;
    }
    
    public function getAllUsers()
    {
        $users_mapper = new Application_Model_Mapper_User;
        return $users_mapper->fetchAll();
    }
    
    public function saveUser(array $data)
    {
        $is_ldap = false;
        $type = null;
        
        // type = 0 = db
        if($data["type"] == 0)
        {
            $this->getUserForm()->removeSubForm("ldap");
            
            if(isset($data["typeprofile"]) && $data["typeprofile"] != 1)
            {
                if($data["typeprofile"] == 2) // pompier
                {
                    $this->getUserForm()->getSubForm("db")->removeSubForm("db_elu");
                    $type = "pompier";
                }
                else if($data["typeprofile"] == 3) // élu
                {
                    $this->getUserForm()->removeSubForm("db_pompier");
                    
                    if($data["db_elu"]["typeprofileelu"] == 0) // maire
                    {
                        $this->getUserForm()->getSubForm("db")->getSubForm("db_elu")->removeSubForm("db_elu_prefet");
                        $type = "maire";
                    }
                    else // prefet
                    {
                        $this->getUserForm()->getSubForm("db")->getSubForm("db_elu")->removeSubForm("db_elu_maire");
                        $type = "prefet";
                    }
                }
            }
            else // rien
            {
                $this->getUserForm()->getSubForm("db")->removeSubForm("db_elu");
                $this->getUserForm()->getSubForm("db")->removeSubForm("db_pompier");
            }
        }
        else
        {
            $this->getUserForm()->removeSubForm("db");
            $is_ldap = true;
        }
        
        if($data["id"] != 0 && $this->getUserById($data["id"])!== null)
        {
            $this->getUserForm()->getSubForm("db")->getElement("password")->setRequired(false);
        }
        
        if($this->getUserForm()->isValid($data))
        {
            $profile = null;
            
            switch($type)
            {
                case "maire":
                    $profile = new Application_Model_Profile_Elu_Maire;
                    $profile->setCity($data["db_elu"]["db_elu_maire"]["city"]);
                    break;
                    
                case "prefet":
                    $profile = new Application_Model_Profile_Elu_Prefet;
                    $profile->setDepartment($data["db_elu"]["db_elu_prefet"]["department"]);
                    break;
                    
                case "pompier":
                    $profile = new Application_Model_Profile_Pompier;
                    $profile->setGrade($data["db_pompier"]["grade"]);
                    break;
                    
                default:
                    $profile = new Application_Model_Profile;
            }

            (bool) $data["gender"] ? $profile->setAsMan() : $profile->setAsWoman();
            $profile->setLastName($data["last_name"]);
            $profile->setFirstName($data["first_name"]);
            $profile->setEmail($data["email"]);
            $profile->setPhone($data["phone"]);
            $profile->setAddress($data["address"]);
            
            $user = null;
        
            if(!$is_ldap)
            {
                $user = new Application_Model_User_Db($profile);
                $users_mapper = new Application_Model_Mapper_User_Db;
                $user->setPassword($data["password"]);
            }
            else
            {
                $user = new Application_Model_User_LDAP($profile);
                $users_mapper = new Application_Model_Mapper_User_LDAP;
                $user->setDN($data["dn"]);
            }
            
            $user->setRole($data["role"]);
            $user->setActiveStatus($data["status"]);
            
            if($data["id"] != 0)
            {
                $user->setId($data["id"]);
                $user->getProfile()->setId($data["id_profile"]);
            }
            
            $users_mapper->save($user);

            return $user;
        }

        return null;
    }
    
    public function deleteUser(Application_Model_User &$user)
    {
        $users_mapper = new Application_Model_Mapper_User;
        $users_mapper->delete($user);
    }
    
    public function isUserAuthenticated()
    {
        $auth = Zend_Auth::getInstance();
        return $auth->hasIdentity();
    }
    
    public function getUserById($id_user)
    {
        $users_mapper = new Application_Model_Mapper_User;
        $users = $users_mapper->getById($id_user);
        return count($users) === 1 ? $users[0] : null;
    }
    
    public function getUserByLastName($last_name)
    {
        $users_mapper = new Application_Model_Mapper_User;
        $users = $users_mapper->getByEmail($last_name);
        return count($users) === 1 ? $users[0] : null;
    }
    
    public function getUserByEmail($email)
    {
        $users_mapper = new Application_Model_Mapper_User;
        $users = $users_mapper->getByEmail($email);
        return count($users) === 1 ? $users[0] : null;
    }
    
    public function getUsersByGroupId($id_group = null)
    {
        if($id_group !== null)
        {
            $group = $this->getUsersGroupById($id_group);
            return $group->getUsers();
        }
        else
        {
            // récupération de tout les groupes
            $groups = $this->getAllUsersGroups();
            
            // récupération des utilisateurs n'ayvant pas de groupe
            $users = $this->getAllUsers();
            
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
    }
    
    public function getUsersApplications($id_user)
    {
        $user = $this->getUserById($id_user);
        return $user->getApplications();
    }
    
    public function isUserAuthorized($id_user, $id_application)
    {
        $user = $this->getUserById($id_user);
        $application = $this->getApplicationById($id_application);
        
        if(!$application->isActive())
        {
            return false;
        }
        
        return $user->hasApplication($application);
    }
    
    public function getUserForm($id_user = null)
    {
        if($this->user_form === null)
        {
            $this->user_form = new Application_Form_User;
        }
        
        // if a id_user is provided, populate the form with his informations
        if($id_user !== null)
        {
            // get the user
            $user = $this->getUserById($id_user);

            // $data is the array results
            $data = array();
            
            // determine if the user is in the db or not
            $data["type"] = get_class($user) === "Application_Model_User_Db" ? 0 : 1;
            
            // populate the $data
            if($data["type"] == 1)
            {
                $data["dn"] = $user->getDN();
            }
            else
            {
                $data["gender"] = (bool) $user->getProfile()->isMan();
                $data["first_name"] = $user->getProfile()->getFirstName();
                $data["last_name"] = $user->getProfile()->getLastName();
                $data["email"] = $user->getProfile()->getEmail();
                $data["phone"] = $user->getProfile()->getPhone();
                $data["address"] = $user->getProfile()->getAddress();

                switch(get_class($user->getProfile()))
                {
                    case "Application_Model_Profile" :
                        $data["typeprofile"] = 1;
                        break;
                        
                    case "Application_Model_Profile_Pompier" :
                        $data["typeprofile"] = 2;
                        $data["db_pompier"]["grade"] = $user->getProfile()->getGrade();
                        break;
                        
                    case "Application_Model_Profile_Elu_Maire" :
                        $data["typeprofile"] = 3;
                        $data["db_elu"]["db_elu_prefet"]["department"] = $uset->getProfile()->getCity();
                        break;
                        
                    case "Application_Model_Profile_Elu_Prefet" :
                        $data["typeprofile"] = 3;
                        $data["db_elu"]["db_elu_prefet"]["department"] = $uset->getProfile()->getDepartment();
                        break;
                }
                
                $this->getUserForm()->getSubForm("db")->getElement("password")->setDescription("Laissez ce champ vide si vous ne voulez pas changer le mot de passe.");
            }
            
            $data["role"] = $user->getRole();
            $data["status"] = $user->isActive();
            $data["id"] = $user->getId();
            $data["id_profile"] = $user->getProfile()->getId();
            
            $this->getUserForm()->populate($data);
        }
    
        return $this->user_form;
    }
    
    public function saveUsersGroup(array $data)
    {
        if($this->getGroupForm()->isValid($data))
        {
            $usersGroup = new Application_Model_UsersGroup;
            $usersGroup->setName($data["name"]);
            $usersGroup->setDesc($data["description"]);
            $usersGroup->setRole($data["role"]);
            
            if(isset($data["id"]) && $data["id"] > 0)
            {
                $usersGroup->setId($data["id"]);
            }
            
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
    
    public function deleteUsersGroup(Application_Model_UsersGroup &$group)
    {
        $group_mapper = new Application_Model_Mapper_UsersGroup;
        $group_mapper->delete($group);
    }
    
    public function getAllUsersGroups()
    {
        $groups_mapper = new Application_Model_Mapper_UsersGroup;
        return $groups_mapper->fetchAll();
    }
    
    public function getUsersGroupById($id_group = null)
    {
        $groups_mapper = new Application_Model_Mapper_UsersGroup;
        $groups = $groups_mapper->getById($id_group);
        return count($groups) === 1 ? $groups[0] : null;
    }
    
    public function getUsersGroupForm($id_group = null)
    {
        if($this->users_group_form === null)
        {
            $this->users_group_form = new Application_Form_UsersGroup;
        }
        
        // if a id_group is provided, populate the form with his informations
        if($id_group !== null)
        {
            // get the group
            $group = $this->getUsersGroupById($id_group);
            
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
            
            $this->getUsersGroupForm()->populate($data);
        }
        return $this->users_group_form;
    }
    
    public function saveACL(array $data)
    {
        if($this->getACLForm()->isValid($data))
        {
            $user_mapper = new Application_Model_Mapper_User;
            
            $users = array();
            
            foreach($this->getAllUsers() as $user)
            {
                $users[$user->getId()] = $user;
                $users[$user->getId()]->setApplications(array());
            }

            if(isset($data["application"]))
            {
                foreach($data["application"] as $id_application => $application)
                {
                    $application_model = new Application_Model_Application;
                    $application_model->setId($id_application);
                
                    foreach($application as $foo)
                    {
                        $value = explode("_", $foo);
                        
                        if(count($value) == 2 && in_array($value[0], array("group", "user")) && is_numeric($value[1]))
                        {
                            $type = $value[0];
                            $id = $value[1];
                            
                            if($type === "group")
                            {   
                                $group = $group_service->getUsersGroupById($id);
                                
                                foreach($group->getUsers() as $user)
                                {
                                    $users[$user->getId()]->addApplication($application_model);
                                }
                            }
                            else
                            {
                                $users[$id]->addApplication($application_model);
                            }
                        }
                    }
                }
            }
            
            foreach($users as $user)
            {
                $user_mapper->save($user);
            }
            
            return true;
        }

        return false;
    }
          
    public function getACLForm($populate = false)
    {
        if($this->acl_form === null)
        {
            $this->acl_form = new Application_Form_ACL;
        }
        
        if($populate)
        {
            $data = array();
        
            foreach($this->getAllUsers() as $user)
            {
                foreach($user->getApplications() as $application)
                {
                    $data["application"][$application->getId()][] = "user_" . $user->getId();
                }
            }
            
            $this->acl_form->populate($data);
        }
        
        return $this->acl_form;
    }
    
    public function verifyUserCredentials($email, $password)
    {
        $user = $this->getUserByEmail($email);
        
        if($user === null)
        {
            return false;
        }
        
        if(!$user->isActive())
        {
            return false;
        }
        
        // user tmp
        $profile_tmp = new Application_Model_Profile;
        $profile_tmp->setEmail($email);
        $user_tmp = new Application_Model_User_Db($profile_tmp);
        $user_tmp->setPassword($password);
        
        if ($user_tmp->getPassword() !== $user->getPassword())
        {
            return false;
        }
        
        return $user;
    }
    
    public function getAllApplications()
    {
        $applications_mapper = new Application_Model_Mapper_Application;
        return $applications_mapper->fetchAll();
    }
    
    public function saveApplication(array $data)
    {
        if($this->getApplicationForm()->isValid($data))
        {
            $application = new Application_Model_Application;
            $application->setName($data["name"]);
            $application->setURL($data["url"]);
            $application->setActiveStatus($data["status"]);
            
            if(isset($data["id"]) && $data["id"] > 0)
            {
                $application->setId($data["id"]);
            }
            
            $application_mapper = new Application_Model_Mapper_Application;
            $application_mapper->save($application);
            
            return $application;
        }

        return null;
    }
    
    public function deleteApplication(Application_Model_Application &$application)
    {
        $applications_mapper = new Application_Model_Mapper_Application;
        $applications_mapper->delete($application);
    }
    
    public function getApplicationById($id_application)
    {
        $applications_mapper = new Application_Model_Mapper_Application;
        $applications = $applications_mapper->getById($id_application);
        return count($applications) === 1 ? $applications[0] : null;
    }
    
    public function getApplicationByConsumerKey($consumer_key)
    {
        $applications_mapper = new Application_Model_Mapper_Application;
        $applications = $applications_mapper->getByConsumerKey($consumer_key);
        return count($applications) === 1 ? $applications[0] : null;
    }
    
    public function getApplicationsByGroupId($id_group = null)
    {
        if($id_group !== null)
        {
            return null;
        }
        else
        {
            $groups = $this->getAllApplicationsGroups();
            
            // récupération des utilisateurs n'ayvant pas de groupe
            $applications = $this->getAllApplications();
            
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
    }
    
    public function getApplicationForm($id_application = null)
    {
        if($this->application_form === null)
        {
            $this->application_form = new Application_Form_Application;
        }
        
       // if a id_application is provided, populate the form with his informations
        if($id_application !== null)
        {
            // get the group
            $application = $this->getApplicationById($id_application);
            
            // $data is the array results
            $data = array();
            $data["name"] = $application->getName();
            $data["url"] = $application->getURL();
            $data["status"] = $application->isActive();
            $data["id"] = $application->getId();
            
            $this->getApplicationForm()->removeElement("access");
            $this->getApplicationForm()->populate($data);
        }
        return $this->application_form;
    }
    
    public function getAllApplicationsGroups()
    {
        $groups_mapper = new Application_Model_Mapper_ApplicationsGroup;
        return $groups_mapper->fetchAll();
    }
    
    public function getApplicationsGroupById($id_group)
    {
        $groups_mapper = new Application_Model_Mapper_ApplicationsGroup;
        $groups = $groups_mapper->getById($id_group);
        return count($groups) === 1 ? $groups[0] : null;
    }
    
    public function saveApplicationsGroup(array $data)
    {
        if($this->getGroupForm()->isValid($data))
        {
            $applicationsGroup = new Application_Model_ApplicationsGroup;
            $applicationsGroup->setName($data["name"]);
            $applicationsGroup->setColor($data["color"]);
            
            if(isset($data["id"]) && $data["id"] > 0)
            {
                $applicationsGroup->setId($data["id"]);
            }
            
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
    
    public function deleteApplicationsGroup(Application_Model_ApplicationsGroup &$group)
    {
        $group_mapper = new Application_Model_Mapper_ApplicationsGroup;
        $group_mapper->delete($group);
    }

    public function getApplicationsGroupForm($id_group = null)
    {
        if($this->applications_group_form === null)
        {
            $this->applications_group_form = new Application_Form_ApplicationsGroup;
        }
        
        // if a id_group is provided, populate the form with his informations
        if($id_group !== null)
        {
            // get the group
            $group = $this->getApplicationsGroupById($id_group);
            
            // $data is the array results
            $data = array();
            $data["name"] = $group->getName();
            $data["color"] = $group->getColor();
            $data["id"] = $group->getId();
            
            foreach($group->getApplications() as $application)
            {
                $data["applications"][] = $application->getId();
            }
            
            $this->getApplicationsGroupForm()->populate($data);
        }
        return $this->applications_group_form;
    }
}