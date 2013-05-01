<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Service_User
 */

 /**
 * Service User
 *
 * @category   Application
 * @package    Application_Service_User
 */
class Application_Service_User
{
    /**
     * User's form
     *
     * @var Zend_Form
     */
    private $form;
    
    /**
     * Construct the user's service
     *
     * @return Application_Service_User
     * 
     */    
    public function __construct()
    {
        $this->form = new Application_Form_User;
    }

    /**
     * Save user
     *
     * @param  array $data
     * @return Application_Model_User
     * 
     */  
    public function save(array $data)
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
        
        if($data["id"] != 0 && $this->getAccount($data["id"])!== null)
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
    
    /**
     * Delete
     *
     * @param $user Application_Model_User
     * 
     */    
    public function delete(&$user)
    {
        $users_mapper = new Application_Model_Mapper_User;
        $users_mapper->delete($user);
    }

    /**
     * Get all users
     *
     * @return array<Application_Model_User>
     * 
     */   
    public function getAllUsers()
    {
        $users_mapper = new Application_Model_Mapper_User;
        return $users_mapper->fetchAll();
    }
    
    /**
     * Get a user account
     *
     * @return Application_Model_User
     * 
     */       
    public function getAccount($id)
    {
        $users_mapper = new Application_Model_Mapper_User;
        $users = $users_mapper->getById($id);
        
        if(count($users) === 1)
        {
            return $users[0];
        }
        else
        {
            return null;
        }
    }
    
    /**
     * Get a user account by email
     *
     * @return Application_Model_User
     * 
     */       
    public function getAccountByEmail($email)
    {
        $users_mapper = new Application_Model_Mapper_User;
        $users = $users_mapper->getByEmail($email);
        
        if(count($users) === 1)
        {
            return $users[0];
        }
        else
        {
            return null;
        }
    }

    /**
     * Get the user's form
     *
     * @param $id_user optional
     * @return Zend_Form
     * 
     */   
    public function getUserForm($id_user = null)
    {
        // if a id_user is provided, populate the form with his informations
        if($id_user !== null)
        {
            // get the user
            $user = $this->getAccount($id_user);

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
                        $data["db_elu"]["db_elu_prefet"]["department"] = $user->getProfile()->getCity();
                        break;
                        
                    case "Application_Model_Profile_Elu_Prefet" :
                        $data["typeprofile"] = 3;
                        $data["db_elu"]["db_elu_prefet"]["department"] = $user->getProfile()->getDepartment();
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
    
        return $this->form;
    }

    /**
     * Get the ACL form
     *
     * @param $populate optional
     * @return Zend_Form
     * 
     */       
    public function getACLForm($populate = false)
    {
        $form = new Application_Form_ACL;
        
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
            
            $form->populate($data);
        }
        
        return $form;
    }
    
    /**
     * Save the ACL
     *
     * @param  array $data
     * @return bool
     * 
     */      
    public function saveACL($data)
    {
        if($this->getACLForm()->isValid($data))
        {
            $group_service = new Application_Service_UsersGroup;
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
                                $group = $group_service->get($id);
                                
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
    
    /**
     * Get the navigation XML for a user
     *
     * @return Zend_Config_Xml
     * 
     */      
    public function getNavigationXML()
    {
        // get the xml
        $xml = new Zend_Config_Xml(APPLICATION_PATH . '/configs/user_navigation.xml', 'user_nav');
        
        return $xml;
    }

}