<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Mapper_User_Db
 */

 /**
 * Class to map DB User instance.
 *
 * @category   Application
 * @package    Application_Model_Mapper_User_Db
 */
class Application_Model_Mapper_User_Db extends Application_Model_Mapper_User
{
    /**
     * Save the user
     *
     * @param  Application_Model_User_Db $user
     * @return int
     * 
     */
     public function save(Application_Model_User_Db &$user)
     {    
        // On détermine si on ajoute ou on update un user
        $is_new_user = $user->getId() === null;
        
        $id = parent::save($user);

        // On commence la transaction
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        
        try
        {
            $dbTable_Users = new Application_Model_DbTable_Users;
            $dbTable_UsersDb = new Application_Model_DbTable_UsersDb;
            
            // Save the usersdb row
            $row = $dbTable_Users->find($id)->current();
            $rowUserDb = $is_new_user ? $dbTable_UsersDb->createRow() : $row->findDependentRowset("Application_Model_DbTable_UsersDb")->current();
            $rowUserDb->password = $user->getPassword();
            $rowUserDb->id_user = $id;
            $id_usersdb = $rowUserDb->save();

            $db->commit();
        }
        catch(Exception $e)
        {
            $db->rollBack();
            throw $e;
        }

        // Save the profile
        // question : on update l'actuel ou on change de type ?
        if(!$is_new_user)
        {
            $user_tmp = $this->findByCriteria(array("id" => $user->getId()));
            $user_tmp = $user_tmp[0];
            if(get_class($user_tmp->getProfile()) !== get_class($user->getProfile()))
            {
                $profileMapper = new Application_Model_Mapper_Profile;
                $profileMapper->delete($user_tmp->getProfile());
                $user->getProfile()->setId(null);
            }
        }
        $profileMapper = Application_Model_Mapper_Profile::getProfileMapper($user->getProfile());
        $profileMapper->save($id_usersdb, $user->getProfile());
     }
     
     /**
     * Find users with criteria
     *
     * @param  array $criterias optional
     * @return array<Application_Model_User>
     */
     public function findByCriteria(array $criterias = array())
     {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $select = $db->select();
        $select->from("users")
            ->join("usersdb", "users.id_user = usersdb.id_user", null)
            ->join("profiles", "profiles.id_userdb = usersdb.id_userdb")
            ->joinLeft("profilespompiers", "profilespompiers.id_profile = profiles.id_profile")
            ->joinLeft("profileselus", "profileselus.id_profile = profiles.id_profile")
            ->joinLeft("profileselusmaires", "profileselusmaires.id_profileelu = profileselus.id_profileelu")
            ->joinLeft("profileselusprefets", "profileselusprefets.id_profileelu = profileselus.id_profileelu")
            ->columns(array("id_profile" => "profiles.id_profile"))
            ->order("users.id_user");
            
        // critères
        foreach($criterias as $criteria => $value)
        {
            switch($criteria)
            {
                case "last_name":
                    $select->where("profiles.last_name = ?", $value);
                    break;
                    
                case "id":
                    $select->where("users.id_user = ?", $value);
                    break;
            }
        }
            
        $results = $db->fetchAll($select);

        if(count($results) > 0)
        {
            $array_returns = array();
            
            foreach($results as $result)
            {
                $profile = null;
                
                // populate the profile
                
                if($result->id_profileelumaire !== null)
                {
                    $profile = new Application_Model_Profile_Elu_Maire;
                    $profile->setCity($result->city);
                }
                else if($result->id_profileeluprefet !== null)
                {
                    $profile = new Application_Model_Profile_Elu_Prefet;
                    $profile->setDepartment($result->department);
                }
                else if($result->id_profilepompier !== null)
                {
                    $profile = new Application_Model_Profile_Pompier;
                    $profile->setGrade($result->grade);
                }
                else
                {
                    $profile = new Application_Model_Profile;
                }
                
                $profile->setFirstName($result->first_name);
                $profile->setLastName($result->last_name);
                $result->gender ? $profile->setAsMan() : $profile->setAsWoman();
                $profile->setPhone($result->phone);
                $profile->setAddress($result->address);
                $profile->setEmail($result->email);
                $profile->setId($result->id_profile);
                
                // Create the user object
                $user = new Application_Model_User_Db($profile);
                $user->setActiveStatus($result->is_active);
                $user->setRole($result->role);
                $user->setId($result->id_user);
                
                // get apps
                $user->setApplications($this->getApplications($user->getId()));
                
                // populate the array
                $array_returns[] = $user;
            }
            
            return $array_returns;
        }
        else
        {
            return array();
        }
     }
}