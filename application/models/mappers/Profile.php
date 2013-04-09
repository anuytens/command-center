<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Mapper_Profile
 */

 /**
 * Abstract class to map Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Mapper_Profile
 * @abstract
 */
abstract class Application_Model_Mapper_Profile
{
    /**
     * Save the profile
     *
     * @param  int $id_userdb
     * @param  Application_Model_Business_Profile $profile
     * @return int
     * @abstract
     * 
     */
     public function save($id_userdb, Application_Model_Business_Profile &$profile)
     {
        // On commence la transaction
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        
        try
        {
            // On détermine si on ajoute ou on update un user
            $is_new_profile = $profile->getId() === null;
                
            $dbTable_profiles = new Application_Model_DbTable_Profiles;

            // Save the base row
            $row = $is_new_profile ? $dbTable_profiles->createRow() : $dbTable_profiles->find($profile->getId())->current();
            $row->first_name = $profile->getFirstName();
            $row->last_name = $profile->getLastName();            
            $row->address = $profile->getAddress();
            $row->phone = $profile->getPhone();
            $row->email = $profile->getEmail();
            $row->id_userdb = $id_userdb;
            $row->gender = $profile->isMan(); // man = 1 ; woman = 0
            
            $id = $row->save();
            $profile->setId($id);
            
            $db->commit();
            
            return $id;
        }
        catch(Exception $e)
        {
            $db->rollBack();
            throw $e;
        }
     }

     /**
     * Get the right profile mapper
     *
     * @param  Application_Model_Business_Profile $profile
     * @return Application_Model_Mapper_Profile|null
     * @static
     * 
     */     
     static public function getProfileMapper(Application_Model_Business_Profile $profile)
     {
        switch(get_class($profile))
        {
            case "Application_Model_Business_Profile_Pompier" :
                return new Application_Model_Mapper_Profile_Pompier;
                break;
                
            case "Application_Model_Business_Profile_Elu_Maire" :
                return new Application_Model_Mapper_Profile_Elu_Maire;
                break;
                
            case "Application_Model_Business_Profile_Elu_Prefet" :
                return new Application_Model_Mapper_Profile_Elu_Prefet;
                break;
        }
        
        return null;
     }
}